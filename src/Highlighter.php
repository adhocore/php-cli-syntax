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

    public function highlight(string $code = null, array $options = []): string
    {
        $this->setOptions($options);

        $this->parse($code ?? $this->code);

        return \trim($this->out, "\n") . "\n";
    }

    protected function doReset()
    {
        $this->out = '';
    }

    protected function visit(\DOMNode $el)
    {
        $type = $el instanceof \DOMElement ? $el->getAttribute('data-type') : 'raw';
        $text = \str_replace(['&nbsp;', '&lt;', '&gt;'], [' ', '<', '>'], $el->textContent);

        $lastLine = 0;
        $lines    = \explode("\n", $text);
        foreach ($lines as $i => $line) {
            $this->out .= $this->formatLine($type, $line);

            if (isset($lines[$i + 1])) {
                $this->out .= "\n";
            }

            $this->lengths[$this->lineNo++] = \strlen($line);
        }
    }

    protected function formatLine(string $type, string $line)
    {
        static $formats = [
            'comment' => "\033[0;34;40m%s\033[0m",
            'default' => "\033[0;32;40m%s\033[0m",
            'keyword' => "\033[0;31;40m%s\033[0m",
            'string'  => "\033[0;33;40m%s\033[0m",
            'lineno'  => "\033[2;36;40m%s\033[0m",
            'raw'     => '%s',
        ];

        if ('' !== $lineNo = $this->formatLineNo()) {
            $lineNo = \sprintf($formats['lineno'], $lineNo);
        }

        return $lineNo . \sprintf($formats[$type], $line);
    }
}
