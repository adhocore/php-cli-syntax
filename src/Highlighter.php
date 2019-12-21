<?php

declare(strict_types=1);

namespace Ahc\CliSyntax;

class Highlighter
{
    /** @var string The PHP code. */
    protected $code;

    /** @var bool Indicates if it has been already configured. */
    protected static $configured;

    public function __construct(string $code = null)
    {
        $this->code = $code ?? '';
    }

    public function __toString(): string
    {
        return $this->highlight();
    }

    public static function for(string $file): self
    {
        if (!\is_file($file)) {
            throw new \InvalidArgumentException('The given file doesnot exist or is unreadable.');
        }

        return new static(\file_get_contents($file));
    }

    public function highlight(string $code = null): string
    {
        static::configure();

        $html = \highlight_string($code ?? $this->code, true);
        $html = \str_replace(['<br />', '<br/>', '<br>'], "\n", $html);

        return $this->parse($html);
    }

    public function configure()
    {
        if (static::$configured) {
            return;
        }

        foreach (['comment', 'default', 'html', 'keyword', 'string'] as $type) {
            \ini_set("highlight.$type", \ini_get("highlight.$type") . \sprintf('" data-type="%s', $type));
        }

        static::$configured = true;
    }

    protected function parse(string $html): string
    {
        $str = '';
        $dom = new \DOMDocument;

        $dom->loadHTML($html);
        foreach ($dom->getElementsByTagName('span') as $el) {
            $str .= $this->visit($el);
        }

        return $str;
    }

    protected function visit(\DOMElement $el): string
    {
        if ('html' === $type = $el->getAttribute('data-type')) {
            return '';
        }

        $text = $el->textContent;

        $text = \str_replace(['&nbsp;', '&lt;', '&gt;'], [' ', '<', '>'], $text);

        return $this->format($text, $type);
    }

    protected function format(string $text, string $type): string
    {
        static $formats = [
            'comment' => "\033[1;30;40m%s\033[0m",
            'default' => "\033[0;32;40m%s\033[0m",
            'keyword' => "\033[0;36;40m%s\033[0m",
            'string'  => "\033[0;33;40m%s\033[0m",
        ];

        return \sprintf($formats[$type] ?? '%s', $text);
    }
}
