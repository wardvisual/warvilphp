<?php

namespace app\core\utils;

class DateHelper
{
    /**
     * Get the end of the month in the range of the provided start month.
     *
     * @param string $startMonth Start month in the format 'Y-m-d'.
     * @param string $format (optional) Format for the result. Default is 'Y-m-d'.
     * @return string
     */
    public static function getEndOfMonthInRange($startMonth, $format = 'Y-m-d')
    {
        // Extract year and month from the start month
        list($startYear, $startMonth, $startDay) = explode('-', $startMonth);

        // Calculate the end of the month
        $endOfMonth = date($format, strtotime("{$startYear}-{$startMonth}-01 +1 month -1 day"));

        return $endOfMonth;
    }

    public static function getAllMonthsInYear($format = 'F')
    {
        $currentYear = date('Y');
        $months = [];

        for ($month = 1; $month <= 12; $month++) {
            $dateString = "{$currentYear}-{$month}-01";
            $formattedMonth = date($format, strtotime($dateString));
            $months[] = $formattedMonth;
        }

        return $months;
    }
    /**
     * Calculate age based on the provided birthdate.
     *
     * @param string $birthdate
     * @return int
     */
    public static function calculateAge($birthdate)
    {
        // Get the current date
        $currentDate = self::getCurrentDate();

        // Extract year, month, and day from birthdate
        list($birthYear, $birthMonth, $birthDay) = explode('-', $birthdate);
        list($currentYear, $currentMonth, $currentDay) = explode('-', $currentDate);

        // Calculate age based on the difference between birthdate and current date
        $age = $currentYear - $birthYear;

        // Adjust age if the birthdate has not occurred yet this year
        if ($currentMonth < $birthMonth || ($currentMonth == $birthMonth && $currentDay < $birthDay)) {
            $age--;
        }

        return $age;
    }

    /**
     * Add a specified number of days to a given date.
     *
     * @param string $date The original date.
     * @param int $days The number of days to add.
     * @param string $format (optional) Format for the result date. Default is 'Y-m-d'.
     * @return string The new date after adding days.
     */
    public static function addDaysToDate($date, $days, $format = 'Y-m-d')
    {
        $timestamp = strtotime($date);
        $newTimestamp = $timestamp + ($days * 24 * 60 * 60); // Convert days to seconds and add to timestamp
        return date($format, $newTimestamp);
    }

    /**
     * Get the current date.
     *
     * @param string $format (optional) Format for the date. Default is 'Y-m-d'.
     * @return string
     */
    public static function getCurrentDate($format = 'Y-m-d')
    {
        return date($format);
    }

    /**
     * Get the current time.
     *
     * @param string $format (optional) Format for the time. Default is 'H:i:s'.
     * @return string
     */
    public static function getCurrentTime($format = 'H:i:s')
    {
        return date($format);
    }
    /**
     * Get the current date and time.
     *
     * @param string $format (optional) Format for the date and time. Default is 'Y-m-d H:i:s'.
     * @return string
     */
    public static function getCurrentDateTime($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    /**
     * Format a date and time string.
     *
     * @param string $dateTime
     * @param string $format
     * @return string
     */
    public static function formatDateTime($dateTime, $format)
    {
        $timestamp = strtotime($dateTime);
        return date($format, $timestamp);
    }

    /**
     * Calculate the difference between two dates.
     *
     * @param string $startDate
     * @param string $endDate
     * @param string $interval (optional) Interval to calculate (e.g., 'days', 'hours', 'minutes'). Default is 'days'.
     * @return int
     */
    public static function dateDifference($startDate, $endDate, $interval = 'days')
    {
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        switch ($interval) {
            case 'hours':
                $difference = round(($endTimestamp - $startTimestamp) / 3600);
                break;
            case 'minutes':
                $difference = round(($endTimestamp - $startTimestamp) / 60);
                break;
            default: // 'days'
                $difference = round(($endTimestamp - $startTimestamp) / (60 * 60 * 24));
                break;
        }

        return $difference;
    }

    /**
     * Get the month, day, and year as an array from the provided date.
     *
     * @param string $date The date in the format 'Y-m-d'.
     * @return array ['year' => int, 'month' => int, 'day' => int]
     */
    public static function getDateComponents($date)
    {
        $dateComponents = [];
        $timestamp = strtotime($date);

        $dateComponents['year'] = date('Y', $timestamp);
        $dateComponents['month'] = date('F', $timestamp);
        $dateComponents['day'] = date('d', $timestamp);

        return $dateComponents;
    }

    /**
     * Get the month, day, year, hour, minute, and second as an array from the provided datetime.
     *
     * @param string $dateTime The datetime in the format 'Y-m-d H:i:s'.
     * @return array ['year' => int, 'month' => int, 'day' => int, 'hour' => int, 'minute' => int, 'second' => int]
     */
    public static function getDateTimeComponents($dateTime)
    {
        $dateTimeComponents = [];
        $timestamp = strtotime($dateTime);

        $dateTimeComponents['year'] = date('Y', $timestamp);
        $dateTimeComponents['month'] = date('m', $timestamp);
        $dateTimeComponents['day'] = date('d', $timestamp);
        $dateTimeComponents['hour'] = date('H', $timestamp);
        $dateTimeComponents['minute'] = date('i', $timestamp);
        $dateTimeComponents['second'] = date('s', $timestamp);

        return $dateTimeComponents;
    }
}
