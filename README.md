## adhocore/cli-syntax

[![Latest Version](https://img.shields.io/github/release/adhocore/php-cli-syntax.svg?style=flat-square)](https://github.com/adhocore/php-cli-syntax/releases)
[![Travis Build](https://img.shields.io/travis/com/adhocore/php-cli-syntax.svg?branch=master&style=flat-square)](https://travis-ci.com/adhocore/php-cli-syntax?branch=master)
[![Scrutinizer CI](https://img.shields.io/scrutinizer/g/adhocore/php-cli-syntax.svg?style=flat-square)](https://scrutinizer-ci.com/g/adhocore/php-cli-syntax/?branch=master)
[![Codecov branch](https://img.shields.io/codecov/c/github/adhocore/php-cli-syntax/master.svg?style=flat-square)](https://codecov.io/gh/adhocore/php-cli-syntax)
[![StyleCI](https://styleci.io/repos/229348504/shield)](https://styleci.io/repos/229348504)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](./LICENSE)


## Installation
```bash
composer require adhocore/cli-syntax
```

## Usage

You can either highlight PHP code in CLI or export to png image.

### Highlight

```php
use Ahc\CliSyntax\Highlighter;

// PHP code
echo new Highlighter('<?php echo "Hello world!";');
// OR
echo (new Highlighter)->highlight('<?php echo "Hello world!";');

// PHP file
echo Highlighter::for('/path/to/file.php');
```

### Export

```php
use Ahc\CliSyntax\Exporter;

// PHP file
Exporter::for('/path/to/file.php')->export('file.png');
```

See [example usage](./example.php). Here's how the export looks like:

![adhocore/cli-syntax](./example.png)

## Contributing

Please check [the guide](./CONTRIBUTING.md).

## LICENSE

> &copy; [MIT](./LICENSE) | 2019, Jitendra Adhikari

### Credits

This project is bootstrapped by [phint](https://github.com/adhocore/phint)
and releases managed by [please](https://github.com/adhocore/please).
