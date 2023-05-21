<?php

/*
 * This file is part of the CLI-SYNTAX package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\CliSyntax\Test;

use Ahc\CliSyntax\Highlighter;
use PHPUnit\Framework\TestCase;

class HighlighterTest extends TestCase
{
    public function testHighlightCode()
    {
        $code = (new Highlighter)->highlight('<?php echo "Hello world!";');

        $this->assertContains(
            '[0;32;40m<?php [0m[0;31;40mecho [0m[0;33;40m"Hello world!"[0m[0;31;40m;[0m',
            $code
        );
    }

    public function testHighlightCodeWithLineNo()
    {
        $code = (new Highlighter)->highlight('<?php echo "Hello world!";', ['lineNo' => true]);

        $this->assertContains(
            '[2;36;40m1. [0m[0;32;40m<?php [0m[0;31;40mecho [0m[0;33;40m"Hello world!"[0m[0;31;40m;[0m',
            $code
        );
    }

    public function testHighlightFile()
    {
        $code = (string) Highlighter::for(__DIR__ . '/../example.php');

        $this->assertSame(\file_get_contents(__DIR__ . '/example.phps'), $code);
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @expectedExceptionMessage The given file doesnot exist or is unreadable.
     */
    public function testHighlightFileThrows()
    {
        Highlighter::for(__DIR__ . '/' . rand());
    }
}
