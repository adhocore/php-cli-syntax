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

class Highlighter extends Pretty
{
    /** @var string Output string */
    protected $out = '';

    public function __toString(): string
    {
        return $this->highlight();
    }

    public function highlight(string $code = null): string
    {
        $this->parse($code);

        return \trim($this->out, "\n") . "\n";
    }

    protected function reset()
    {
        $this->out = '';
    }

    protected function visit(\DOMNode $el)
    {
        static $formats = [
            'comment' => "\033[0;34;40m%s\033[0m",
            'default' => "\033[0;32;40m%s\033[0m",
            'keyword' => "\033[0;31;40m%s\033[0m",
            'string'  => "\033[0;33;40m%s\033[0m",
        ];

        $type = $el instanceof \DOMElement ? $el->getAttribute('data-type') : 'raw';
        $text = \str_replace(['&nbsp;', '&lt;', '&gt;'], [' ', '<', '>'], $el->textContent);

        $this->out .= \sprintf($formats[$type] ?? '%s', $text);
    }
}
