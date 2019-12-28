<?php

/*
 * This file is part of the CLI-SYNTAX package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\CliSyntax\Test\Console;

use Ahc\Cli\Application;
use Ahc\Cli\IO\Interactor;
use Ahc\Cli\Test\CliTestCase;
use Ahc\CliSyntax\Console\ClishCommand;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../vendor/adhocore/cli/tests/CliTestCase.php';

class ClishCommandTest extends CliTestCase
{
    protected $app;

    protected static $in = __DIR__ . '/stdin';
    protected static $ou = __DIR__ . '/stdout';
    protected static $ex = __DIR__ . '/output/export.png';

    public function setUp()
    {
        parent::setUp();
        \touch(static::$in);

        $this->app = (new Application('clish', 'test', function () {}))->add(new ClishCommand, 'c', true);
        $this->app->io(new Interactor(static::$in, static::$ou));
    }

    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();

        if (\is_file(static::$ex)) {
            \unlink(static::$ex);
        }
        if (\is_file(static::$in)) {
            \unlink(static::$in);
        }

        if (\is_dir(\dirname(static::$ex))) {
            \rmdir(\dirname(static::$ex));
        }
    }

    public function testExecute()
    {
        $this->app->handle(['clish', 'c', '--file=' . __DIR__ . '/../../example.php']);

        $this->assertBufferContains("<?php echo 'Hello world!'; ?>");
        $this->assertBufferContains('This file is part of the CLI-SYNTAX package');
    }

    public function testExecuteExport()
    {
        $this->app->handle(['clish', 'c', '--file=' . __DIR__ . '/../../example.php', '--output=' . static::$ex]);

        $this->assertFileExists(static::$ex, 'Should export to a file');
        $this->assertEmpty($this->buffer(), 'Shouldnt write to stdout when --output is given');
    }

    public function testInteractEmptyInput()
    {
        \file_put_contents(static::$in, '');

        $this->app->handle(['clish', 'c']);

        $this->assertBufferContains('Type in or paste PHP Code below, Press Ctrl+D when done');
    }

    public function testInteractNonEmpty()
    {
        \file_put_contents(static::$in, 'echo 1234;');

        $this->app->handle(['clish', 'c']);

        $this->assertBufferContains('<?php');
        $this->assertBufferContains('echo');
        $this->assertBufferContains('1234');
    }
}
