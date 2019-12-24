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

    protected function parse(string $code = null)
    {
        static::configure();

        $html = \highlight_string($code ?? $this->code, true);
        $html = \str_replace('<br />', "\n", $html);

        $dom = new \DOMDocument;
        $dom->loadHTML($html);

        foreach ($dom->getElementsByTagName('span') as $el) {
            if ('html' !== $el->getAttribute('data-type')) {
                $this->visit($el);
            }
        }
    }

    abstract protected function visit(\DOMElement $el);
}
