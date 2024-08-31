<?php

namespace Fahdi\PhpDateFormat\Tests;

use PHPUnit\Framework\TestCase;
use Fahdi\PhpDateFormat\DateToWords;

class DateToWordsTest extends TestCase
{
	public function testValidDates()
	{
		$testCases = [
			'1990-05-15' => 'Fifteenth of May, Nineteen ninety',
			'2000-01-01' => 'First of January, Two thousand',
			'2023-12-31' => 'Thirty-first of December, Twenty twenty-three',
		];

		foreach ($testCases as $input => $expected) {
			$this->assertEquals($expected, DateToWords::convert($input));
		}
	}

	public function testDifferentFormats()
	{
		$testCases = [
			'15/05/1990' => 'Fifteenth of May, Nineteen ninety',
			'05/15/1990' => 'Fifteenth of May, Nineteen ninety',
			'15-05-1990' => 'Fifteenth of May, Nineteen ninety',
			'1990/05/15' => 'Fifteenth of May, Nineteen ninety',
			'May 15, 1990' => 'Fifteenth of May, Nineteen ninety',
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
}