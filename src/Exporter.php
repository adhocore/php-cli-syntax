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
    protected $font = __DIR__ . '/../font/ubuntu.ttf';

    /** @var resource The image */
    protected $image;

    /** @var array */
    protected $imgSize = [];

    /** @var array Colors cached for each types. */
    protected $colors = [];

    /** @var array Lengths of each line */
    protected $lengths = [];

    public function __destruct()
    {
        if (\is_resource($this->image)) {
            \imagedestroy($this->image);
        }
    }

    public function export(string $output, array $options = [])
    {
        if (!\is_dir(\dirname($output))) {
            throw new \InvalidArgumentException('The output path doesnot exist.');
        }

        $this->setOptions($options);

        $this->imgSize = $this->estimateSize($this->code);
        $this->image   = \imagecreate($this->imgSize['x'] + 50, $this->imgSize['y'] + 25);

        \imagecolorallocate($this->image, 0, 0, 0);

        $this->parse();

        \imagepng($this->image, $output);
    }

    protected function setOptions(array $options)
    {
        if (isset($options['size'])) {
            $this->size = $options['size'];
        }

        if (!isset($options['font'])) {
            return;
        }

        if (\is_file($options['font'])) {
            $this->font = $options['font'];

            return;
        }

        $base = \basename($options['font'], '.ttf');
        if (!\is_file($font = __DIR__ . "/../font/$base.ttf")) {
            throw new \InvalidArgumentException('The given font doesnot exist.');
        }

        $this->font = $font;
    }

    protected function estimateSize(string $for): array
    {
        $eol = \substr_count($for, "\n") ?: 1;
        $box = \imagettfbbox($this->size, 0, $this->font, $for);

        return ['x' => $box[2], 'y' => $box[1], 'y1' => \intval($box[1] / $eol)];
    }

    protected function reset()
    {
        $this->colors = $this->lengths = [];
    }

    protected function visit(\DOMNode $el)
    {
        $lineNo = $el->getLineNo() - 2;
        $type   = $el instanceof \DOMElement ? $el->getAttribute('data-type') : 'raw';
        $color  = $this->colorCode($type);
        $text   = \str_replace(['&nbsp;', '&lt;', '&gt;'], [' ', '<', '>'], $el->textContent);

        foreach (\explode("\n", $text) as $line) {
            $lineNo++;

            $xlen = $this->lengths[$lineNo] ?? 0;
            $xpos = 12 + $xlen;
            $ypos = 12 + $this->imgSize['y1'] * $lineNo;

            \imagefttext($this->image, $this->size, 0, $xpos, $ypos, $color, $this->font, $line);

            $this->lengths[$lineNo] = $xlen + $this->estimateSize($line)['x'];
        }
    }

    protected function colorCode(string $type): int
    {
        if (isset($this->colors[$type])) {
            return $this->colors[$type];
        }

        $palette = [
            'comment' => [0, 96, 192],
            'default' => [0, 192, 0],
            'keyword' => [192, 0, 0],
            'string'  => [192, 192, 0],
            'raw'     => [128, 128, 128],
        ];

        return $this->colors[$type] = \imagecolorallocate($this->image, ...$palette[$type]);
    }
}
