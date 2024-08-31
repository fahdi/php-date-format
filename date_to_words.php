<?php

function dateToWords($dateString) {
    // Clean up the date string
    $cleanDate = cleanDateString($dateString);
    
    // If cleaning failed, return an error message
    if ($cleanDate === false) {
        return "Invalid date format";
    }
    
    $date = new DateTime($cleanDate);
    
    $day = $date->format('j');
    $month = $date->format('F');
    $year = $date->format('Y');
    
    $dayInWords = convertNumberToWords($day);
    $yearInWords = convertNumberToWords($year);
    
    return "$dayInWords of $month, $yearInWords";
}

function cleanDateString($dateString) {
    // Remove any non-digit, non-dash, non-slash characters
    $cleaned = preg_replace('/[^0-9\-\/]/', '', $dateString);
    
    // Try to parse the date in various formats
    $formats = ['Y-m-d', 'd-m-Y', 'm/d/Y', 'd/m/Y', 'Y/m/d'];
    foreach ($formats as $format) {
        $date = DateTime::createFromFormat($format, $cleaned);
        if ($date !== false) {
            return $date->format('Y-m-d');
        }
    }
    
    return false;  // If no valid format was found
}

function convertNumberToWords($number) {
    $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
    return ucfirst($formatter->format($number));
}

// Example usage:
$dates = [
    '1990-05-15',
    '15/05/1990',
    '05/15/1990',
    '15-05-1990',
    '1990/05/15',
    'May 15, 1990',
    'Invalid date'
];

foreach ($dates as $date) {
    echo "Input: $date\n";
    echo "Output: " . dateToWords($date) . "\n\n";
}
