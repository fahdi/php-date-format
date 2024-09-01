# PHP Date to Words Converter

This library provides a simple and flexible way to convert dates into word representations in PHP. It handles various date formats and offers customizable output for days, months, and years.

## Features

- Convert dates to word representations
- Support for multiple input date formats
- Handles special cases for days (1st, 2nd, 3rd, 21st, 22nd, etc.)
- Consistent word representation for years from 1 to 9999
- Extensive test suite to ensure accuracy

## Requirements

- PHP 7.4 or higher
- ext-intl extension

## Installation

You can install this package via Composer:

```bash
composer require fahdi/php-date-format
```

## Usage

Here's a basic example of how to use the DateToWords converter:

```php
<?php

require_once 'vendor/autoload.php';

use Fahdi\PhpDateFormat\DateToWords;

echo DateToWords::convert('1890-05-15');
// Output: Fifteenth of May, Eighteen ninety

echo DateToWords::convert('1990-05-15');
// Output: Fifteenth of May, Nineteen ninety

echo DateToWords::convert('2023-12-31');
// Output: Thirty-first of December, Twenty twenty-three

echo DateToWords::convert('1800-01-01');
// Output: First of January, Eighteen hundred

echo DateToWords::convert('1900-01-01');
// Output: First of January, Nineteen hundred

echo DateToWords::convert('2000-02-29');
// Output: Twenty-ninth of February, Two thousand

echo DateToWords::convert('2100-12-31');
// Output: Thirty-first of December, Twenty-one hundred
```

The `convert` method accepts dates in various formats:

- 'Y-m-d' (e.g., '1990-05-15')
- 'd-m-Y' (e.g., '15-05-1990')
- 'm/d/Y' (e.g., '05/15/1990')
- 'd/m/Y' (e.g., '15/05/1990')
- 'Y/m/d' (e.g., '1990/05/15')
- 'F j, Y' (e.g., 'May 15, 1990')
- 'Y.m.d' (e.g., '1990.05.15')

If an invalid date format is provided, the method will return "Invalid date format".

## Running Tests

To run the tests, use the following command in your project root:

```bash
./vendor/bin/phpunit tests
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the MIT license.