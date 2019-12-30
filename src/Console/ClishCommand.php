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

namespace Ahc\CliSyntax\Console;

use Ahc\Cli\Input\Command;
use Ahc\Cli\IO\Interactor;
use Ahc\CliSyntax\Exporter;
use Ahc\CliSyntax\Highlighter;

class ClishCommand extends Command
{
    public function __construct()
    {
        parent::__construct('clish', 'PHP CLI syntax highlight and/or export.');

        $this
            ->option('-o --output', 'Output filepath where PNG image is exported', null, '')
            ->option('-e --echo', 'Forces echo to STDOUT when --output is passed', null, '')
            ->option('-f --file', \implode("\n", [
                'Input PHP file to highlight and/or export',
                '(will read from piped input if file not given)',
            ]), null, '')
            ->option('-F --font', 'Font to use for export to png', null, '')
            ->usage(
                '<bold>  $0</end> <comment>--file file.php</end> ## print<eol/>'
                . '<comment>  cat file.php |</end> <bold>$0</end> ## from piped stream<eol/>'
                . '<bold>  $0</end> <comment>< file.php</end> ## from redirected stdin<eol/>'
                . '<bold>  $0</end> <comment>--file file.php --output file.png</end> ## export<eol/>'
                . '<bold>  $0</end> <comment>--file file.php --output file.png --echo</end> ## print + export<eol/>'
                . '<bold>  $0</end> <comment>-f file.php -o file.png -F dejavu</end> ## export in dejavu font<eol/>'
            );
    }

    public function interact(Interactor $io)
    {
        if ($this->file) {
            return;
        }

        $code = $io->readPiped(function ($reader) use ($io) {
            $io->warn('Type in or paste PHP Code below, Press Ctrl+D when done.', true);
            $io->warn('(Opening tag `<?php` will be prepended as required):', true);

            return $reader->readAll();
        });

        if ('' !== $code && \substr($code, 0, 5) != '<?php') {
            $eol  = \substr_count(\rtrim($code), "\n") ? "\n\n" : '';
            $code = '<?php ' . $eol . $code;
        }

        $this->set('code', $code);
    }

    public function execute()
    {
        $code = $this->file ? \file_get_contents($this->file) : $this->code;

        if ('' === \trim($code)) {
            return;
        }

        $this->doExport($code);
        $this->doHighlight($code);
    }

    protected function doHighlight(string $code = null)
    {
        if (!$this->output || $this->echo) {
            $this->app()->io()->raw((string) new Highlighter($code));
        }
    }

    protected function doExport(string $code = null)
    {
        if (!$this->output) {
            return;
        }

        if (!\is_dir(\dirname($this->output))) {
            \mkdir(\dirname($this->output), 0755, true);
        }

        $options = ['font' => $this->fixFont($this->font ?: 'ubuntu')];

        (new Exporter($code))->export($this->output, $options);
    }

    /** @codeCoverageIgnore */
    protected function fixFont(string $font): string
    {
        if (\Phar::running()) {
            $basename = \basename($font, '.ttf');
            $pharfont = __DIR__ . "/../../font/$basename.ttf";

            if (!\is_file($font) && \is_file($pharfont)) {
                \copy($pharfont, $font = sys_get_temp_dir() . '/clish.ttf');
            }
        }

        return $font;
    }
}
