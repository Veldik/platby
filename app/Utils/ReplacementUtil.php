<?php

namespace App\Utils;

use Carbon\Carbon;

class ReplacementUtil
{
    public static function replace(string $text): string
    {
        $replacements = [
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d'),
            'hour' => date('H'),
            'minute' => date('i'),
            'second' => date('s'),

            'monthName' => Carbon::now()->monthName,
            'dayName' => Carbon::now()->dayName,
        ];

        foreach ($replacements as $key => $value) {
            $text = str_replace('{' . $key . '}', $value, $text);
        }

        return $text;
    }
    public static function formatCurrency($number)
    {
        return number_format($number, 2, ',', ' ') . ' Kč';
    }
}
