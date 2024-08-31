# PHP Date to Words Converter

This project provides a PHP function to convert dates into words. It includes a main function file and a set of PHPUnit tests.

## Usage

Include the `date_to_words.php` file in your project and use the `dateToWords()` function:

```php
<?php
require_once 'date_to_words.php';

echo dateToWords('1990-05-15');  // Output: Fifteen of May, Nineteen ninety
```

## Running Tests

To run the tests, you need PHPUnit installed. Then, you can run:

```
phpunit DateToWordsTest.php
```

## Contributing

Feel free to open issues or submit pull requests to improve this project.

## License

This project is open-sourced under the MIT license.
