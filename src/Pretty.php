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

abstract class Pretty
{
    /** @var string The PHP code. */
    protected $code;

    /** @var int The current line number. */
    protected $lineNo = 0;

    /** @var int The total lines count. */
    protected $lineCount = 0;

    /** @var bool Show line numbers. */
    protected $withLineNo = false;

    /** @var array Lengths of each line */
    protected $lengths = [];

    /** @var bool Indicates if it has been already configured. */
    protected static $configured;

    public function __construct(string $code = null)
    {
        $this->code = $code ?? '';
    }

    public static function for(string $file): self
    {
        if (!\is_file($file)) {
            throw new \InvalidArgumentException('The given file doesnot exist or is unreadable.');
        }

        return new static(\file_get_contents($file));
    }

    public static function configure()
    {
        if (static::$configured) {
            return;
        }

        foreach (['comment', 'default', 'html', 'keyword', 'string'] as $type) {
            \ini_set("highlight.$type", \ini_get("highlight.$type") . \sprintf('" data-type="%s', $type));
        }

        static::$configured = true;
    }

    protected function setOptions(array $options)
    {
        if ($options['lineNo'] ?? false) {
            $this->withLineNo = true;
        }
    }

    protected function parse(string $code = null)
    {
        $this->reset();

        $dom = new \DOMDocument;
        $dom->loadHTML($this->codeToHtml($code ?? $this->code));

        $adjust = -1;
        foreach ((new \DOMXPath($dom))->query('/html/body/code/span/*') as $el) {
            $this->lineNo = $el->getLineNo() + $adjust;
            $this->visit($el);
        }
    }

    protected function codeToHtml(string $code): string
    {
        static::configure();

        $this->lineCount = \substr_count($code, "\n") ?: 1;

        $html = \highlight_string($code, true);

        return \str_replace(['<br />'], ["\n"], $html);
    }

    protected function formatLineNo(): string
    {
        if ($this->withLineNo && $this->lineNo <= $this->lineCount && !isset($this->lengths[$this->lineNo])) {
            return \str_pad("$this->lineNo", \strlen("$this->lineCount"), ' ', \STR_PAD_LEFT) . '. ';
        }

        return '';
    }

    protected function reset()
    {
        $this->doReset();

        $this->lengths = [];
        $this->lineNo  = $this->lineCount = 0;
    }

    abstract protected function doReset();

    abstract protected function visit(\DOMNode $el);
}
