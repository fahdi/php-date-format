# PHP Date to Words Converter

This project provides a PHP class to convert dates into words. It includes a main class file and a set of PHPUnit tests.

## Installation

You can install this package via Composer:

```
composer require fahdi/php-date-format
```

## Usage

After installing the package, you can use it like this:

```php
<?php
require_once 'vendor/autoload.php';

use Fahdi\PhpDateFormat\DateToWords;

echo DateToWords::convert('1990-05-15');  // Output: Fifteen of May, Nineteen ninety
```

## Running Tests

To run the tests, you can use the following command:

```
./vendor/bin/phpunit tests
```

## Contributing

Feel free to open issues or submit pull requests to improve this project.

## License

This project is open-sourced under the MIT license.
