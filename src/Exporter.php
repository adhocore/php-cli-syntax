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

        $this->imgSize   = $this->estimateSize($this->code);
        $this->lineCount = \substr_count($this->code, "\n") ?: 1;

        $padLineNo   = $this->withLineNo ? $this->estimateSize($this->formatLineNo())['x'] : 0;
        $this->image = \imagecreate($this->imgSize['x'] + $padLineNo + 50, $this->imgSize['y'] + 25);

        \imagecolorallocate($this->image, 0, 0, 0);

        $this->parse();

        \imagepng($this->image, $output);
    }

    protected function setOptions(array $options)
    {
        parent::setOptions($options);

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

    protected function doReset()
    {
        $this->colors = [];
    }

    protected function visit(\DOMNode $el)
    {
        $type   = $el instanceof \DOMElement ? $el->getAttribute('data-type') : 'raw';
        $color  = $this->colorCode($type);
        $ncolor = $this->colorCode('lineno');
        $text   = \str_replace(['&nbsp;', '&lt;', '&gt;'], [' ', '<', '>'], $el->textContent);

        foreach (\explode("\n", $text) as $line) {
            $xlen = $this->lengths[$this->lineNo] ?? 0;
            $ypos = 12 + $this->imgSize['y1'] * $this->lineNo;

            if ('' !== $lineNo = $this->formatLineNo()) {
                $xlen += $this->estimateSize($lineNo)['x'];
                \imagefttext($this->image, $this->size, 0, 12, $ypos, $ncolor, $this->font, $lineNo);
            }

            \imagefttext($this->image, $this->size, 0, 12 + $xlen, $ypos, $color, $this->font, $line);

            $this->lengths[$this->lineNo] = $xlen + $this->estimateSize($line)['x'];

            $this->lineNo++;
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
            'lineno'  => [128, 224, 224],
        ];

        return $this->colors[$type] = \imagecolorallocate($this->image, ...$palette[$type]);
    }
}
