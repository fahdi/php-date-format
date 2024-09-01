<?php

namespace Fahdi\PhpDateFormat\Tests;

use PHPUnit\Framework\TestCase;
use Fahdi\PhpDateFormat\DateToWords;

class DateToWordsTest extends TestCase {
	public function testValidDates()
	{
		$testCases = [
			'1890-05-15' => 'Fifteenth of May, Eighteen ninety',
			'1990-05-15' => 'Fifteenth of May, Nineteen ninety',
			'2000-01-01' => 'First of January, Two thousand',
			'2023-12-31' => 'Thirty-first of December, Twenty twenty-three',
			'1800-03-14' => 'Fourteenth of March, Eighteen hundred',
			'2024-02-29' => 'Twenty-ninth of February, Twenty twenty-four',
			'1900-01-01' => 'First of January, Nineteen hundred',
			'2100-12-31' => 'Thirty-first of December, Twenty-one hundred',
		];

		foreach ($testCases as $input => $expected) {
			$this->assertEquals($expected, DateToWords::convert($input));
		}
	}

	public function testDifferentFormats() {
		$testCases = [
			'15/05/1890'   => 'Fifteenth of May, Eighteen ninety',
			'05/15/1990'   => 'Fifteenth of May, Nineteen ninety',
			'15-05-2090'   => 'Fifteenth of May, Twenty ninety',
			'1890/05/15'   => 'Fifteenth of May, Eighteen ninety',
			'May 15, 1990' => 'Fifteenth of May, Nineteen ninety',
			'2023.07.04'   => 'Fourth of July, Twenty twenty-three',
		];

		foreach ( $testCases as $input => $expected ) {
			$this->assertEquals( $expected, DateToWords::convert( $input ) );
		}
	}

	public function testInvalidDates() {
		$invalidDates = [
			'Invalid date',
			'2023-13-01',
			'2023-02-30',
			'abc123',
			'0000-00-00',
			'2023/14/01',
		];

		foreach ( $invalidDates as $input ) {
			$this->assertEquals( 'Invalid date format', DateToWords::convert( $input ) );
		}
	}

	public function testEdgeCases() {
		$this->assertEquals( 'First of January, One', DateToWords::convert( '0001-01-01' ) );
		$this->assertEquals( 'Thirty-first of December, Nine thousand nine hundred ninety-nine', DateToWords::convert( '9999-12-31' ) );
	}

	public function testLeapYears() {
		$this->assertEquals( 'Twenty-ninth of February, Two thousand', DateToWords::convert( '2000-02-29' ) );
		$this->assertEquals( 'Twenty-ninth of February, Twenty twenty-four', DateToWords::convert( '2024-02-29' ) );
		$this->assertEquals( 'Invalid date format', DateToWords::convert( '2023-02-29' ) );
	}

	public function testCenturyYears() {
		$this->assertEquals( 'First of January, Eighteen hundred', DateToWords::convert( '1800-01-01' ) );
		$this->assertEquals( 'Thirty-first of December, Eighteen ninety-nine', DateToWords::convert( '1899-12-31' ) );
		$this->assertEquals( 'First of January, Nineteen hundred', DateToWords::convert( '1900-01-01' ) );
		$this->assertEquals( 'Thirty-first of December, Nineteen ninety-nine', DateToWords::convert( '1999-12-31' ) );
		$this->assertEquals( 'First of January, Two thousand', DateToWords::convert( '2000-01-01' ) );
		$this->assertEquals( 'Thirty-first of December, Two thousand', DateToWords::convert( '2000-12-31' ) );
		$this->assertEquals( 'First of January, Twenty oh-one', DateToWords::convert( '2001-01-01' ) );
		$this->assertEquals( 'First of January, Twenty ten', DateToWords::convert( '2010-01-01' ) );
		$this->assertEquals( 'Thirty-first of December, Twenty ninety-nine', DateToWords::convert( '2099-12-31' ) );
		$this->assertEquals( 'First of January, Twenty-one hundred', DateToWords::convert( '2100-01-01' ) );
		$this->assertEquals( 'Thirty-first of December, Twenty-two hundred', DateToWords::convert( '2200-12-31' ) );
	}

	public function testDifferentDayFormats() {
		$this->assertEquals( 'First of June, Twenty twenty-three', DateToWords::convert( '2023-06-01' ) );
		$this->assertEquals( 'Second of June, Twenty twenty-three', DateToWords::convert( '2023-06-02' ) );
		$this->assertEquals( 'Third of June, Twenty twenty-three', DateToWords::convert( '2023-06-03' ) );
		$this->assertEquals( 'Twenty-first of June, Twenty twenty-three', DateToWords::convert( '2023-06-21' ) );
		$this->assertEquals( 'Twenty-second of June, Twenty twenty-three', DateToWords::convert( '2023-06-22' ) );
		$this->assertEquals( 'Twenty-third of June, Twenty twenty-three', DateToWords::convert( '2023-06-23' ) );
		$this->assertEquals( 'Thirtieth of June, Twenty twenty-three', DateToWords::convert( '2023-06-30' ) );
	}

}