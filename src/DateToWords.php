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
		$formats = ['Y-m-d', 'd-m-Y', 'm/d/Y', 'd/m/Y', 'Y/m/d', 'F j, Y'];
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
		if ($day == 1) {
			return 'First';
		} elseif ($day == 21) {
			return 'Twenty-first';
		} elseif ($day == 31) {
			return 'Thirty-first';
		}

		$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
		$dayInWords = ucfirst($formatter->format($day));

		if ($day == 2 || $day == 22) {
			return $dayInWords . 'nd';
		} elseif ($day == 3 || $day == 23) {
			return $dayInWords . 'rd';
		} else {
			return $dayInWords . 'th';
		}
	}

	private static function convertYearToWords($year)
	{
		$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);

		if ($year == 2000) {
			return 'Two thousand';
		}

		if ($year >= 1000 && $year <= 9999) {
			$century = floor($year / 100);
			$remainder = $year % 100;

			$centuryWord = ucfirst($formatter->format($century));

			if ($remainder == 0) {
				return $centuryWord . ' hundred';
			} elseif ($remainder < 10) {
				return $centuryWord . ' oh ' . $formatter->format($remainder);
			} else {
				return $centuryWord . ' ' . $formatter->format($remainder);
			}
		} else {
			return ucfirst($formatter->format($year));
		}
	}
}