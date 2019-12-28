[0;32;40m<?php

[0m[0;34;40m/*
 * This file is part of the CLI-SYNTAX package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

[0m[0;31;40muse [0m[0;32;40mAhc[0m[0;31;40m\[0m[0;32;40mCliSyntax[0m[0;31;40m\[0m[0;32;40mExporter[0m[0;31;40m;
use [0m[0;32;40mAhc[0m[0;31;40m\[0m[0;32;40mCliSyntax[0m[0;31;40m\[0m[0;32;40mHighlighter[0m[0;31;40m;

require_once [0m[0;32;40m__DIR__ [0m[0;31;40m. [0m[0;33;40m'/src/Pretty.php'[0m[0;31;40m;
require_once [0m[0;32;40m__DIR__ [0m[0;31;40m. [0m[0;33;40m'/src/Exporter.php'[0m[0;31;40m;
require_once [0m[0;32;40m__DIR__ [0m[0;31;40m. [0m[0;33;40m'/src/Highlighter.php'[0m[0;31;40m;

[0m[0;34;40m// Highlight code
[0m[0;31;40mecho (new [0m[0;32;40mHighlighter[0m[0;31;40m([0m[0;33;40m"<?php echo 'Hello world!'; ?>" [0m[0;31;40m. [0m[0;32;40mPHP_EOL[0m[0;31;40m))
    ->[0m[0;32;40mhighlight[0m[0;31;40m();

[0m[0;34;40m// Highlight file
[0m[0;31;40mecho [0m[0;32;40mHighlighter[0m[0;31;40m::for([0m[0;32;40m__FILE__[0m[0;31;40m)->[0m[0;32;40mhighlight[0m[0;31;40m();

[0m[0;34;40m// Export highlighted file as image
[0m[0;32;40mExporter[0m[0;31;40m::for([0m[0;32;40m__FILE__[0m[0;31;40m)->[0m[0;32;40mexport[0m[0;31;40m([0m[0;32;40m__DIR__ [0m[0;31;40m. [0m[0;33;40m'/example.png'[0m[0;31;40m);

[0m[0;34;40m// Magic string works too:
[0m[0;31;40mecho new [0m[0;32;40mHighlighter[0m[0;31;40m([0m[0;33;40m'<?php echo "Hello Again!";' [0m[0;31;40m. [0m[0;32;40mPHP_EOL[0m[0;31;40m);
[0m[0;34;40m// echo Highlighter::for(__FILE__);
[0m
