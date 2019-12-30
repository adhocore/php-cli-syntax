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

use Ahc\CliSyntax\Exporter;
use PHPUnit\Framework\TestCase;

class ExporterTest extends TestCase
{
    protected $out = __DIR__ . '/export.png';
    protected $ref = __DIR__ . '/../example.png';

    public function setUp()
    {
        if (\is_file($this->out)) {
            @unlink($this->out);
        }
    }

    public function testExport()
    {
        Exporter::for(__DIR__ . '/../example.php')->export($this->out);

        $this->assertFileExists($this->out, 'It should export to given output path');
        // $this->assertSame(\file_get_contents($this->ref), \file_get_contents($this->out));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The output path doesnot exist.
     */
    public function testExportThrows()
    {
        Exporter::for(__DIR__ . '/../example.php')->export(__DIR__ . '/no/dir/file.png');
    }

    public function testSetOptions()
    {
        Exporter::for(__DIR__ . '/../example.php')->export($this->out, ['font' => 'ubuntu', 'size' => 18]);

        $this->assertFileExists($this->out, 'It should export with given options');
        // $this->assertSame(\file_get_contents($this->ref), \file_get_contents($this->out));
    }

    public function testSetOptionsFont()
    {
        Exporter::for(__DIR__ . '/../example.php')->export($this->out, ['font' => __DIR__ . '/../font/dejavu.ttf']);

        $this->assertFileExists($this->out, 'It should export with given font');
        // $this->assertSame(\file_get_contents($this->ref), \file_get_contents($this->out));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The given font doesnot exist.
     */
    public function testSetOptionsThrows()
    {
        Exporter::for(__DIR__ . '/../example.php')->export($this->out, ['font' => 'invalid']);
    }
}
