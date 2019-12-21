[0;32;40m<?php

[0m[0;36;40muse [0m[0;32;40mAhc[0m[0;36;40m\[0m[0;32;40mCliSyntax[0m[0;36;40m\[0m[0;32;40mHighlighter[0m[0;36;40m;

require_once [0m[0;32;40m__DIR__ [0m[0;36;40m. [0m[0;33;40m'/src/Highlighter.php'[0m[0;36;40m;

[0m[1;30;40m// Highlight code
[0m[0;36;40mecho (new [0m[0;32;40mHighlighter[0m[0;36;40m([0m[0;33;40m"<?php echo 'Hello world!'; ?>\n"[0m[0;36;40m))->[0m[0;32;40mhighlight[0m[0;36;40m();

[0m[1;30;40m// Highlight file
[0m[0;36;40mecho [0m[0;32;40mHighlighter[0m[0;36;40m::for([0m[0;32;40m__FILE__[0m[0;36;40m)->[0m[0;32;40mhighlight[0m[0;36;40m();

[0m[1;30;40m// Magic string works too:
// echo new Highlighter('<?php echo "Hello world!";');
// echo Highlighter::for(__FILE__);
[0m