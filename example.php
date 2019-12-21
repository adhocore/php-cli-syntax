<?php

/*
 * This file is part of the CLI-SYNTAX package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

use Ahc\CliSyntax\Highlighter;

require_once __DIR__ . '/src/Highlighter.php';

// Highlight code
echo (new Highlighter("<?php echo 'Hello world!'; ?>\n"))->highlight();

// Highlight file
echo Highlighter::for(__FILE__)->highlight();

// Magic string works too:
// echo new Highlighter('<?php echo "Hello world!";');
// echo Highlighter::for(__FILE__);
