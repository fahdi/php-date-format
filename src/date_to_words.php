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
		$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
		$dayInWords = ucfirst($formatter->format($day));

		if ($day == 1 || $day == 21 || $day == 31) {
			return $dayInWords . 'st';
		} elseif ($day == 2 || $day == 22) {
			return $dayInWords . 'nd';
		} elseif ($day == 3 || $day == 23) {
			return $dayInWords . 'rd';
		} else {
			return $dayInWords . 'th';
		}
	}

	private static function convertYearToWords($year)
	{
		if ($year >= 1000 && $year <= 9999) {
			$century = floor($year / 100);
			$remainder = $year % 100;

			$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);

			if ($remainder == 0) {
				return ucfirst($formatter->format($century)) . ' hundred';
			} elseif ($remainder < 10) {
				return ucfirst($formatter->format($century)) . ' oh ' . $formatter->format($remainder);
			} else {
				return ucfirst($formatter->format($century)) . ' ' . $formatter->format($remainder);
			}
		} else {
			$formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
			return ucfirst($formatter->format($year));
		}
	}
}