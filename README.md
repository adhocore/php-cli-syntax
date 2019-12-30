## adhocore/cli-syntax

[![Latest Version](https://img.shields.io/github/release/adhocore/php-cli-syntax.svg?style=flat-square)](https://github.com/adhocore/php-cli-syntax/releases)
[![Travis Build](https://img.shields.io/travis/com/adhocore/php-cli-syntax.svg?branch=master&style=flat-square)](https://travis-ci.com/adhocore/php-cli-syntax?branch=master)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/adhocore/php-cli-syntax.svg?style=flat-square)](https://scrutinizer-ci.com/g/adhocore/php-cli-syntax/?branch=master)
[![Codecov branch](https://img.shields.io/codecov/c/github/adhocore/php-cli-syntax/master.svg?style=flat-square)](https://codecov.io/gh/adhocore/php-cli-syntax)
[![StyleCI](https://styleci.io/repos/229348504/shield)](https://styleci.io/repos/229348504)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](./LICENSE)


## Installation

### As phar binary

```sh
curl -SsLo ~/clish.phar https://github.com/adhocore/php-cli-syntax/releases/latest/download/clish.phar

chmod +x ~/clish.phar && sudo ln -s ~/clish.phar /usr/local/bin/clish
```
> Follow same steps to upgrade.

### As standalone binary

```sh
composer global require adhocore/cli-syntax
```
> Follow same steps to upgrade.

### As project dependency
```bash
composer require adhocore/cli-syntax
```

## Usage

### Shell command

If you installed as binary following any of the above methods, then:

```sh
# you will be able to run it as
clish -h
clish -f file.php
echo '<?php date("Ymd");' | clish
cat file.php | clish

# export png
clish -f file.php -o file.png
```

> `clish` stands for CLI syntax highlight.

#### Options

Parameter options.

```
  [-e|--echo]         Forces echo to STDOUT when --output is passed
  [-f|--file]         Input PHP file to highlight and/or export
                      (will read from piped input if file not given)
  [-F|--font]         Font to use for export to png
  [-h|--help]         Show help
  [-o|--output]       Output filepath where PNG image is exported
  [-v|--verbosity]    Verbosity level
  [-V|--version]      Show version
```

##### Examples

```sh
  bin/clish --file file.php                           # print
  cat file.php | bin/clish                            # from piped stream
  bin/clish < file.php                                # from redirected stdin
  bin/clish --file file.php --output file.png         # export
  bin/clish --file file.php --output file.png --echo  # print + export
  bin/clish -f file.php -o file.png -F dejavu         # export in dejavu font
```

### Programatically

You can either highlight PHP code in terminal output or export to png image.

#### Highlight

```php
use Ahc\CliSyntax\Highlighter;

// PHP code
echo new Highlighter('<?php echo "Hello world!";');
// OR
echo (new Highlighter)->highlight('<?php echo "Hello world!";');

// PHP file
echo Highlighter::for('/path/to/file.php');
```

#### Export

```php
use Ahc\CliSyntax\Exporter;

// PHP file
Exporter::for('/path/to/file.php')->export('file.png');
```

See [example usage](./example.php). Here's how the export looks like:

![adhocore/cli-syntax](./example.png)


## Customisation

If you would like to change color etc, extend the classes
[`Highlighter`](./src/Highlighter.php) and [`Exporter`](./src/Exporter.php),
then override `visit()` method which recieves [`DOMNode`](https://php.net/DOMNode).

## Contributing

Please check [the guide](./CONTRIBUTING.md).

## LICENSE

> &copy; [MIT](./LICENSE) | 2019, Jitendra Adhikari

## Credits

This project is bootstrapped by [phint](https://github.com/adhocore/phint)
and releases managed by [please](https://github.com/adhocore/please).
