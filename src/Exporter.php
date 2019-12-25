<?php

declare(strict_types=1);

/*
 * This file is part of the CLI-SYNTAX package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\CliSyntax;

class Exporter extends Pretty
{
    /** @var int Font size */
    protected $size = 16;

    /** @var string Font path */
    protected $font = __DIR__ . '/../font/dejavu.ttf';

    /** @var resource The image */
    protected $image;

    /** @var array */
    protected $imgSize = [];

    /** @var array Colors cached for each types. */
    protected static $colors = [];

    /** @var array Lengths of each line */
    protected static $lengths = [];

    public function __destruct()
    {
        if (\is_resource($this->image)) {
            \imagedestroy($this->image);
        }
    }

    public function export(string $output)
    {
        $this->imgSize = $this->estimateSize($this->code, 25);
        $this->image   = \imagecreate($this->imgSize['x'], $this->imgSize['y']);

        \imagecolorallocate($this->image, 0, 0, 0);

        $this->parse();

        \imagepng($this->image, $output);
    }

    protected function estimateSize(string $for, int $pad = 0): array
    {
        $eol = \substr_count($for, "\n") ?: 1;
        $box = \imagettfbbox($this->size, 0, $this->font, $for);

        return ['x' => $box[2] + $pad, 'y' => $box[1] + $pad, 'y1' => \intval($box[1] / $eol)];
    }

    protected function visit(\DOMElement $el)
    {
        $lineNo = $el->getLineNo() - 1;
        $type   = $el->getAttribute('data-type');
        $color  = $this->colorCode($type);
        $text   = \str_replace(['&nbsp;', '&lt;', '&gt;'], [' ', '<', '>'], $el->textContent);

        foreach (\explode("\n", \rtrim($text, "\r\n")) as $line) {
            $lineNo++;

            $xlen = static::$lengths[$lineNo] ?? 0;
            $xpos = 12 + $xlen;
            $ypos = $this->imgSize['y1'] * $lineNo;

            \imagefttext($this->image, $this->size, 0, $xpos, $ypos, $color, $this->font, $line);

            static::$lengths[$lineNo] = $xlen + $this->estimateSize($line)['x'];
        }
    }

    protected function colorCode(string $type): int
    {
        if (isset(static::$colors[$type])) {
            return static::$colors[$type];
        }

        $palette = [
            'comment' => [0, 96, 192],
            'default' => [0, 192, 0],
            'keyword' => [192, 0, 0],
            'string'  => [192, 192, 0],
        ];

        return static::$colors[$type] = \imagecolorallocate($this->image, ...$palette[$type]);
    }
}
