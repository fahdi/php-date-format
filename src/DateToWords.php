<?php

namespace Fahdi\PhpDateFormat;

use DateTime;
use NumberFormatter;

class DateToWords
{
	public static function convert($dateString)
	{
		$cleanDate = self::cleanDateString($dateString);

		if ($cleanDate === false) {
			return "Invalid date format";
		}

		$date = new DateTime($cleanDate);

		$day = $date->format('j');
		$month = $date->format('F');
		$year = $date->format('Y');

		$dayInWords = self::convertDayToWords($day);
		$yearInWords = self::convertYearToWords($year);

		return "$dayInWords of $month, $yearInWords";
	}

	private static function cleanDateString($dateString)
	{
		$formats = ['Y-m-d', 'd-m-Y', 'm/d/Y', 'd/m/Y', 'Y/m/d', 'F j, Y', 'Y.m.d'];
		foreach ($formats as $format) {
			$date = DateTime::createFromFormat($format, $dateString);
			if ($date !== false && $date->format($format) == $dateString) {
				return $date->format('Y-m-d');
			}
		}

		return false;
	}

	private static function convertDayToWords($day)
	{
		$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
		$dayInWords = ucfirst($formatter->format($day));

		$specialCases = [
			1 => 'First',
			2 => 'Second',
			3 => 'Third',
			20 => 'Twentieth',
			21 => 'Twenty-first',
			22 => 'Twenty-second',
			23 => 'Twenty-third',
			29 => 'Twenty-ninth',
			30 => 'Thirtieth',
			31 => 'Thirty-first'
		];

		if (isset($specialCases[$day])) {
			return $specialCases[$day];
		}

		if ($day >= 4 && $day <= 20) {
			return $dayInWords . 'th';
		}

		$lastDigit = $day % 10;
		switch ($lastDigit) {
			case 1: return $dayInWords . 'st';
			case 2: return $dayInWords . 'nd';
			case 3: return $dayInWords . 'rd';
			default: return $dayInWords . 'th';
		}
	}

	private static function convertYearToWords($year)
	{
		$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);

		if ($year >= 1000 && $year <= 9999) {
			$century = floor($year / 100);
			$remainder = $year % 100;

			if ($year == 2000) {
				return 'Two thousand';
			}

			$centuryWords = [
				18 => 'Eighteen',
				19 => 'Nineteen',
				20 => 'Twenty',
				21 => 'Twenty-one',
				22 => 'Twenty-two'
			];

			if (isset($centuryWords[$century])) {
				if ($remainder == 0) {
					return $centuryWords[$century] . ' hundred';
				} else {
					if ($century == 20 && $remainder < 10) {
						return $centuryWords[$century] . ' oh-' . $formatter->format($remainder);
					} else {
						return $centuryWords[$century] . ' ' . $formatter->format($remainder);
					}
				}
			}

			$centuryWord = ucfirst($formatter->format($century * 100));

			if ($remainder == 0) {
				return $centuryWord;
			} else {
				return $centuryWord . ' ' . $formatter->format($remainder);
			}
		} else {
			return ucfirst($formatter->format($year));
		}
	}
}