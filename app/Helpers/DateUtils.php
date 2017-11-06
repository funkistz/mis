<?php

namespace app\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use \DateTime;
use App\Models\GeneralSetting;
use Carbon\Carbon;

class DateUtils
{
    private static $system_date_format;
    private static $system_time_format;
    private static $system_timezone_format = 'Asia/Kuala_Lumpur';

    public static function getSystemDateFormat()
    {
        if (empty(self::$system_date_format)) {
            self::$system_date_format = GeneralSetting::where('field', 'system_date_format')->select(['value'])->first()->value;
        }

        return self::$system_date_format;
    }

    /**
    * Format date based-on format date given.
    * Default format as defined at Settings > General > System Date Format
    *
    * @param  mixed $date Can be string or DateTime or Carbon type
    * @param  string $format PHP date format
    * @return string
    */
    public static function format_date($date, $format = '')
    {
        setlocale(LC_TIME, Session::get('app_locale'));

        if (empty(self::$system_date_format)) {
            self::$system_date_format = GeneralSetting::where('field', 'system_date_format')->select(['value'])->first()->value;
        }

        if (empty(self::$system_timezone_format)) {
            self::$system_timezone_format = GeneralSetting::where('field', 'system_timezone_format')->select(['value'])->first()->value;
        }

        $format = (!empty($format)) ? $format : self::$system_date_format;

        $date = (is_a($date, DateTime::class)) ? $date : Carbon::createFromTimestamp(strtotime($date));

        $formatted_date = $date->setTimezone(self::$system_timezone_format)->formatLocalized(self::date_to_strftime($format));

        return $formatted_date;
    }

    /**
    * Format date based-on format date given.
    * Default format as defined at Settings > General > System Date Format
    *
    * @param  mixed $date Can be string or DateTime or Carbon type
    * @param  string $format PHP date format
    * @return string
    */
    public static function sql_date($date, $format = 'Y-m-d H:i:s')
    {
        $date = (is_a($date, DateTime::class)) ? $date : Carbon::createFromTimestamp(strtotime(str_replace('/', '-', $date)));

        $formatted_date = $date->format($format);

        return $formatted_date;
    }

    /**
    * Format time based-on format date given.
    * Default format as defined at Settings > General > System Time Format
    *
    * @param  mixed $date Can be string or DateTime or Carbon type
    * @param  string $format PHP date format
    * @return string
    */
    public static function format_time($date, $format = '')
    {
        setlocale(LC_TIME, Session::get('app_locale'));

        if (empty(self::$system_time_format)) {
            self::$system_time_format = GeneralSetting::where('field', 'system_time_format')->select(['value'])->first()->value;
        }

        if (empty(self::$system_timezone_format)) {
            self::$system_timezone_format = GeneralSetting::where('field', 'system_timezone_format')->select(['value'])->first()->value;
        }

        $format = (!empty($format)) ? $format : self::$system_time_format;

        $date = (is_a($date, DateTime::class)) ? $date : Carbon::createFromTimestamp(strtotime($date));

        $formatted_time = $date->setTimezone(self::$system_timezone_format)->format($format);

        return $formatted_time;
    }

    /**
    * Check either string represent DateTime input or not
    *
    * @param  string   $input
    * @param  string   $format
    * @return bool
    */
    public static function checkDate($input, $format = 'Y-m-d H:i:s')
    {
        $datetime = \DateTime::createFromFormat($format, $input);

        return ($datetime && $datetime->format($format) == $input);
    }

    /**
    * Convert date/time format between `date()` and `strftime()`
    *
    * Timezone conversion is done for Unix. Windows users must exchange %z and %Z.
    *
    * Unsupported date formats : S, n, t, L, B, G, u, e, I, P, Z, c, r
    * Unsupported strftime formats : %U, %W, %C, %g, %r, %R, %T, %X, %c, %D, %F, %x
    *
    * @example Convert `%A, %B %e, %Y, %l:%M %P` to `l, F j, Y, g:i a`, and vice versa for "Saturday, March 10, 2001, 5:16 pm"
    * @link http://php.net/manual/en/function.strftime.php#96424
    *
    * @param string $format The format to parse.
    * @param string $from The format's syntax. Use 'strf' for `strtime()` or 'date' for `date()` or 'momentjs' for `moment()`.
    * @param string $to The format's syntax. Use 'strf' for `strtime()` or 'date' for `date()` or 'momentjs' for `moment()`.
    * @return bool|string Returns a string formatted according $syntax using the given $format or `false`.
    */
    public static function date_format_to($format, $from, $to)
    {
        // http://php.net/manual/en/function.strftime.php
        $strf_syntax = [
            // Day - no strf eq : S (created one called %O)
            '%O', '%A', '%a', '%j', '%d', '%w', '%e', '%u',
            // Week - no date eq : %U, %W
            '%V',
            // Month - no strf eq : n, t
            '%B', '%b', '%m', '%m',
            // Year - no strf eq : L; no date eq : %C, %g
            '%Y', '%y', '%G',
            // Time - no strf eq : B, G, u; no date eq : %r, %R, %T, %X
            '%P', '%p', '%l', '%k', '%I', '%H', '%M', '%S',
            // Timezone - no strf eq : e, I, P, Z
             '%Z', '%z',
            // Full Date / Time - no strf eq : c, r; no date eq : %c, %D, %F, %x
            '%s'
        ];

        // http://php.net/manual/en/function.date.php
        $date_syntax = [
            'S', 'l', 'D', 'z', 'd', 'w', 'j', 'N',
            'W',
            'F', 'M', 'm', 'n',
            'Y', 'y', 'o',
            'a', 'A', 'g', 'G', 'h', 'H', 'i', 's',
            'T', 'O',
            'U'
        ];

        // https://momentjs.com/docs/
        $momentjs_syntax = [
            'Do', 'dddd', 'ddd', 'DDD', 'DD', 'd', 'D', 'E',
            'W',
            'MMMM', 'MMM', 'MM', 'M',
            'YYYY', 'YY', 'Y',
            'a', 'A', 'h', 'H', 'hh', 'HH', 'mm', 'ss',
            'zz', 'ZZ',
            'X'
        ];

        switch ($from) {
            case 'strf':
                $from_syntax   = $strf_syntax;
                break;
            case 'date':
                $from_syntax   = $date_syntax;
                break;
            case 'momentjs':
                $from_syntax   = $momentjs_syntax;
                break;
            default:
                return false;
        }

        switch ($to) {
            case 'strf':
                $to_syntax   = $strf_syntax;
                break;
            case 'date':
                $to_syntax   = $date_syntax;
                break;
            case 'momentjs':
                $to_syntax   = $momentjs_syntax;
                break;
            default:
                return false;
        }

        $pattern = array_map(
            function ($s) {
                return '/(?<!\\\\|\%)' . $s . '/';
            },
            $from_syntax
        );

        return preg_replace($pattern, $to_syntax, $format);
    }

    /**
    * Equivalent to `date_format_to( $format, 'strf', 'date' )`
    *
    * @param string $strf_format A `strftime()` date/time format
    * @return string
    */
    public static function strftime_to_date($strf_format)
    {
        return self::date_format_to($strf_format, 'strf', 'date');
    }

    /**
    * Equivalent to `date_format_to( $format, 'strf', 'momentjs' )`
    *
    * @param string $strf_format A `strftime()` date/time format
    * @return string
    */
    public static function strftime_to_momentjs($strf_format)
    {
        return self::date_format_to($strf_format, 'strf', 'momentjs');
    }

    /**
    * Equivalent to `date_format_to( $format, 'date', 'strf' )`
    *
    * @param string $date_format A `date()` date/time format
    * @return string
    */
    public static function date_to_strftime($date_format)
    {
        return self::date_format_to($date_format, 'date', 'strf');
    }

    /**
    * Equivalent to `date_format_to( $format, 'date', 'momentjs' )`
    *
    * @param string $date_format A `date()` date/time format
    * @return string
    */
    public static function date_to_momentjs($date_format)
    {
        return self::date_format_to($date_format, 'date', 'momentjs');
    }

    /**
    * Equivalent to `date_format_to( $format, 'momentjs', 'strf' )`
    *
    * @param string $momentjs_format A `moment()` date/time format
    * @return string
    */
    public static function momentjs_to_strftime($momentjs_format)
    {
        return self::date_format_to($momentjs_format, 'momentjs', 'strf');
    }

    /**
    * Equivalent to `date_format_to( $format, 'momentjs', 'date' )`
    *
    * @param string $momentjs_format A `moment()` date/time format
    * @return string
    */
    public static function momentjs_to_date($momentjs_format)
    {
        return self::date_format_to($momentjs_format, 'momentjs', 'date');
    }

    /**
    * Get next datetime based on frequency, next, interval, and date string provided
    *
    * @param int $frequency 1=daily, 2=weekly, 3=monthly, 4=yearly
    * @param int $next number of day, week or month
    * @param int $interval in DateInterval
    * @param string $datestring
    * @return string $date in format 'Y-m-d H:i:s'
    */
    public static function next_datetime($frequency, $next, $interval, $datestring)
    {
        $date = new \DateTime($datestring);

        if (!empty($interval)) {
            $interval_str = 'P';
            $year = $interval->y;
            $month = $interval->m;
            $day = $interval->d;
            $hour = $interval->h;
            $minute = $interval->i;
            $second = $interval->s;

            if (!empty($year) || !empty($month) || !empty($day)) {
                if (!empty($year)) {
                    $interval_str = $interval_str . $year . 'Y';
                }

                if (!empty($month)) {
                    $interval_str = $interval_str . $month . 'M';
                }

                if (!empty($day)) {
                    $interval_str = $interval_str . $day . 'D';
                }
            }

            if (!empty($hour) || !empty($minute) || !empty($day)) {
                $interval_str = $interval_str . 'T';

                if (!empty($hour)) {
                    $interval_str = $interval_str . $hour . 'H';
                }

                if (!empty($minute)) {
                    $interval_str = $interval_str . $minute . 'M';
                }

                if (!empty($second)) {
                    $interval_str = $interval_str . $second . 'S';
                }
            }

            $date->add(new \DateInterval($interval_str));
        }

        if (!empty($frequency) && !empty($next)) {
            $interval_str = 'P';

            if ($frequency == 1) { //Daily
                $interval_str = $interval_str . $next . 'D';
            } elseif ($frequency == 2) { //Weekly
                $interval_str = $interval_str . $next . 'W';
            } elseif ($frequency == 3) { //Monthly
                $interval_str = $interval_str . $next . 'M';
            } elseif ($frequency == 4) { //Yearly
                $interval_str = $interval_str . $next . 'Y';
            }

            $date->add(new \DateInterval($interval_str));
        }

        return $date->format('Y-m-d H:i:s');
    }
}
