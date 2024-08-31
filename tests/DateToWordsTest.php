<?php

namespace Fahdi\PhpDateFormat\Tests;

use PHPUnit\Framework\TestCase;
use Fahdi\PhpDateFormat\DateToWords;

class DateToWordsTest extends TestCase
{
	public function testValidDates()
	{
		$testCases = [
			'1990-05-15' => 'Fifteenth of May, One thousand nine hundred ninety',
			'2000-01-01' => 'First of January, Two thousand',
			'2023-12-31' => 'Thirty-first of December, Two thousand twenty-three',
			'1800-03-14' => 'Fourteenth of March, One thousand eight hundred',
			'2024-02-29' => 'Twenty-ninth of February, Two thousand twenty-four',
		];

		foreach ($testCases as $input => $expected) {
			$this->assertEquals($expected, DateToWords::convert($input));
		}
	}

	public function testDifferentFormats()
	{
		$testCases = [
			'15/05/1990' => 'Fifteenth of May, One thousand nine hundred ninety',
			'05/15/1990' => 'Fifteenth of May, One thousand nine hundred ninety',
			'15-05-1990' => 'Fifteenth of May, One thousand nine hundred ninety',
			'1990/05/15' => 'Fifteenth of May, One thousand nine hundred ninety',
			'May 15, 1990' => 'Fifteenth of May, One thousand nine hundred ninety',
			'2023.07.04' => 'Fourth of July, Two thousand twenty-three',
		];

		foreach ($testCases as $input => $expected) {
			$this->assertEquals($expected, DateToWords::convert($input));
		}
	}

	public function testInvalidDates()
	{
		$invalidDates = [
			'Invalid date',
			'2023-13-01',
			'2023-02-30',
			'abc123',
			'0000-00-00',
			'2023/14/01',
		];

		foreach ($invalidDates as $input) {
			$this->assertEquals('Invalid date format', DateToWords::convert($input));
		}
	}

	public function testEdgeCases()
	{
		$this->assertEquals('First of January, One', DateToWords::convert('0001-01-01'));
		$this->assertEquals('Thirty-first of December, Nine thousand nine hundred ninety-nine', DateToWords::convert('9999-12-31'));
	}

	public function testLeapYears()
	{
		$this->assertEquals('Twenty-ninth of February, Two thousand', DateToWords::convert('2000-02-29'));
		$this->assertEquals('Twenty-ninth of February, Two thousand twenty-four', DateToWords::convert('2024-02-29'));
		$this->assertEquals('Invalid date format', DateToWords::convert('2023-02-29'));
	}

	public function testCenturyYears()
	{
		$this->assertEquals('First of January, One thousand nine hundred', DateToWords::convert('1900-01-01'));
		$this->assertEquals('Thirty-first of December, Two thousand one hundred', DateToWords::convert('2100-12-31'));
	}

	public function testDifferentDayFormats()
	{
		$this->assertEquals('First of June, Two thousand twenty-three', DateToWords::convert('2023-06-01'));
		$this->assertEquals('Second of June, Two thousand twenty-three', DateToWords::convert('2023-06-02'));
		$this->assertEquals('Third of June, Two thousand twenty-three', DateToWords::convert('2023-06-03'));
		$this->assertEquals('Twenty-first of June, Two thousand twenty-three', DateToWords::convert('2023-06-21'));
		$this->assertEquals('Twenty-second of June, Two thousand twenty-three', DateToWords::convert('2023-06-22'));
		$this->assertEquals('Twenty-third of June, Two thousand twenty-three', DateToWords::convert('2023-06-23'));
		$this->assertEquals('Thirtieth of June, Two thousand twenty-three', DateToWords::convert('2023-06-30'));
	}
}