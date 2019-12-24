<?php

/*
 * This file is part of the CLI-SYNTAX package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

use Ahc\CliSyntax\Exporter;
use Ahc\CliSyntax\Highlighter;

require_once __DIR__ . '/src/Pretty.php';
require_once __DIR__ . '/src/Exporter.php';
require_once __DIR__ . '/src/Highlighter.php';

// Highlight code
echo (new Highlighter("<?php echo 'Hello world!'; ?>" . PHP_EOL))
    ->highlight();

// Highlight file
echo Highlighter::for(__FILE__)->highlight();

// Export highlighted file as image
Exporter::for(__FILE__)->export(__DIR__ . '/example.png');

// Magic string works too:
echo new Highlighter('<?php echo "Hello Again!";' . PHP_EOL);
// echo Highlighter::for(__FILE__);
