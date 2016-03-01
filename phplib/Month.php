<?php

class Month {

    public static function getCompetitionName() {
        $month = date("m");
        switch ($month) {
            case 01:
                return "Frugal January";
            case 02:
                return "Frugal February";
            case 03:
                return "Miserly March";
            case 04:
                return "Austere April";
            case 05:
                return "Miserly May";
            case 06:
                return "Frugal June";
            case 07:
                return "Frugal July";
            case 08:
                return "Austere August";
            case 09:
                return "Stingy September";
            case 10:
                return "Austere October";
            case 11:
                return "Niggardly November";
            case 12:
                return "Frugal December";
            default:
                throw new Exception("Invalid month: $month.");
        }
    }

    /**
     * @param  int $month_number The month to get the epoch date for. null means now.
     * @return int
     */
    public static function getEpochDateForBeginningOfMonth($month_number = null) {
        if ($month_number === null) {
            $month_name_and_year = date("F Y"); // "February 2016"
            return strtotime($month_name_and_year);
        }

        $current_month_number = date("m");
        $current_year = date("Y");
        if ($current_month_number >= $month_number) {
            return strtotime("{$current_year}-{$month_number}"); // "2016-02"
        } else {
            // Month from last year
            $last_year = $current_year - 1;
            return strtotime("{$last_year}-{$month_number}");
        }


    }

    /**
     * @param  int $month_number The month to get the epoch date for. null means now.
     * @return int
     */
    public static function getEpochDateForEndOfMonth($month_number = null) {
        // Subtract one because otherwise we have the beginning of next month.
        return strtotime("+1 month", self::getEpochDateForBeginningOfMonth($month_number)) - 1;
    }

}
