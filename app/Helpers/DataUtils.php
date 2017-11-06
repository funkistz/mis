<?php

namespace app\Helpers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use App\Helpers\DateUtils as DateUtil;
use App\Models\FinanceGeneral;
use App\Models\Student;
use App\Repositories\Student\StudentLetterRepository;

class DataUtils
{

    public function __construct(StudentLetterRepository $student_letter)
    {
        $this->student_letter = $student_letter;
    }
    /**
     * Get months in year value in array format
     *
     * @param  string $format PHP date format for month
     * @return array
     */
    public static function months($format = 'F')
    {
        setlocale(LC_TIME, Session::get('app_locale'));
        $month_collection = collect(range(1, 12))->mapWithKeys(function ($value, $key) use ($format) {
            return [$value => Carbon::create(2017, $value)->formatLocalized(DateUtil::date_to_strftime($format))];
        });

        return $month_collection->all();
    }

    /**
     * Get years value in array format
     *
     * @param  integer $previous Start year
     * @param  integer $next     End year
     * @param  string  $format   PHP date format for year
     * @return array
     */
    public static function years($previous = 5, $next = 5, $format = 'Y')
    {
        setlocale(LC_TIME, Session::get('app_locale'));
        $current_year = date('Y');

        $year_collection = collect(range($current_year - $previous, $current_year + $next))->mapWithKeys(function ($value, $key) use ($previous, $next, $format) {
            return [$value => Carbon::create($value)->formatLocalized(DateUtil::date_to_strftime($format))];
        });

        return $year_collection->all();
    }

    /**
     * Get days value in array format
     *
     * @param  string  $format   PHP date format for strftime
     * @return array
     */
    public static function days($format = 'l')
    {
        setlocale(LC_TIME, Session::get('app_locale'));

        $day_collection = collect(['01-05-2017', '02-05-2017', '03-05-2017', '04-05-2017', '05-05-2017', '06-05-2017', '07-05-2017'])->mapWithKeys(function ($value, $key) use ($format) {
            $date = Carbon::createFromFormat('d-m-Y', $value);

            return [$date->format('N') => $date->formatLocalized(DateUtil::date_to_strftime($format))];
        });

        return $day_collection->all();
    }

    /**
     * Get time zones value in array format
     *
     * @param  string  $format   PHP date format for strftime
     * @return array
     */
    public static function timezones()
    {
        $timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

        $timezone_collection = collect($timezones)->mapWithKeys(function ($value, $key) {
            return [$value => $value];
        });

        return $timezone_collection->all();
    }

    /**
     * Get semester value in array format
     *
     * @param  string  $maximum   maximum number of semester
     * @return array
     */
    public static function semesters($maximum = 10)
    {
        $semester_collection = collect(range(1, abs($maximum)))->mapWithKeys(function ($value, $key) {
            return [$value => $value];
        });

        return $semester_collection->all();
    }

    /**
     * Get placeholder value in array format
     *
     * @return array
     */
    public static function placeholders()
    {
        $placeholder_collection = collect(array(
            'STUDENTNAME' => '{STUDENTNAME}',
            'STUDENTID' => '{STUDENTID}',
            'STUDENTNATIONALITY' => '{STUDENTNATIONALITY}',
            'ICNUMBER/PASSPORT' => '{ICNUMBER/PASSPORT}',
            '*e*CURRENTSTATUS' => '{CURRENTSTATUS}',
            '*e*CURRENTSEMESTER' => '{CURRENTSEMESTER}',
            'CURRENTACADEMICSESSION' => '{CURRENTACADEMICSESSION}',
            '*e*NEXTSEMESTER' => '{NEXTSEMESTER}',
            'PERMANENTADDRESS' => '{PERMANENTADDRESS}',
            'CONTACTADDRESS' => '{CONTACTADDRESS}',
            'FACULTYCODE' => '{FACULTYCODE}',
            'FACULTYNAME' => '{FACULTYNAME}',
            'PROGRAM' => '{PROGRAM}',
            'PROGRAMCAPS' => '{PROGRAM(CAPS)}',
            '*e*INTAKE' => '{INTAKE}',
            'VENUE' => '{VENUE}',
            'COUNTRY' => '{COUNTRY}',
            'NATIONALITY' => '{NATIONALITY}',
            '*e*CURRENTDATE[d F Y]' => '{CURRENTDATE}',
            '*e*CURRENTDATEADD[d F Y 7]' => '{CURRENTDATEADD}',
            '*e*REGDATESTART[d F Y (D)]' => '{REGDATESTART}',
            '*e*REGDATEEND[d F Y (D)]' => '{REGDATEEND}',
            'REGTIMESTART[h:i a]' => '{REGTIMESTART}',
            'REGTIMEEND[h:i a]' => '{REGTIMEEND}',
            '*e*DATEDUE[d F Y]' => '{DATEDUE}',
            'OUTSTANDING' => '{OUTSTANDING}',
            'STAFFNAME' => '{STAFFNAME}',
            'STAFFPHONEOFFICE' => '{STAFFPHONEOFFICE}',
            'STAFFPHONEMOBILE' => '{STAFFPHONEMOBILE}',
            'STAFFEMAIL' => '{STAFFEMAIL}',
            'LOGO' => '{LOGO}',
            'COLLEGEADDRESS' => '{COLLEGEADDRESS}',
            'COLLEGEWEBSITE' => '{COLLEGEWEBSITE}',
            'COLLEGENUMBER' => '{COLLEGENUMBER}',
            'COLLEGEFAX' => '{COLLEGEFAX}',
            'COLLEGENAME' => '{COLLEGENAME}',
            'STUDYMODE' => '{STUDYMODE}',
            'SALUTATION' => '{SALUTATION}',
            'GPA' => '{GPA}',
            'CGPA' => '{CGPA}',
            '*e*STUDENTSTATUS' => '{STUDENTSTATUS}',
            'PROGRAMTYPE' => '{PROGRAMTYPE}',
            'LETTERHEADHEADER' => '{LETTERHEADHEADER}',
            'LETTERHEADFOOTER' => '{LETTERHEADFOOTER}',
            'ACADEMICSESSION' => '{ACADEMICSESSION}',
            'DEPOSIT' => '{DEPOSIT}',
            'FIRSTSEMFEE' => '{FIRSTSEMFEE}',
            'REFNUMBER' => '{REFNUMBER}',
            '*y*DURATION' => '{DURATION}',
            'PROGRAMCODE' => '{PROGRAMCODE}',
            'SUBJECTCODE' => '{SUBJECTCODE}',
            'SUBJECTNAME' => '{SUBJECTNAME}',
            'ATTENDANCEPERCENTAGE' => '{ATTENDANCEPERCENTAGE}',
            'ATTENDANCEDETAILS' => '{ATTENDANCEDETAILS}',
            'FIRSTWARNINGDATETIME' => '{FIRSTWARNINGDATETIME}',
            'SECONDWARNINGDATETIME' => '{SECONDWARNINGDATETIME}',
            'COURSELECTURER' => '{COURSELECTURER}',
            'PARENTGUARDIAN' => '{PARENTGUARDIAN}',
            'PROGCOORDINATOR' => '{PROGCOORDINATOR}',
            'PROGDIRECTOR' => '{PROGDIRECTOR}',
            'BARCODE[]' => '{BARCODE}',
            'REMOVEHEADER' => '{REMOVEHEADER}',
            'GUARANTEEAMOUNT' => '{GUARANTEEAMOUNT}',
            '*e*VISAEXPIREDDATE[d F Y]' => '{VISAEXPIREDDATE}',
            'VISANUMBER' => '{VISANUMBER}',
            'VISAREFNUMBER' => '{VISAREFNUMBER}',
            'ADDPAGEBREAKAFTER' => '{ADDPAGEBREAKAFTER}',
            'ADDPAGEBREAKBEFORE' => '{ADDPAGEBREAKBEFORE}',
            'DISABLEPAGEBREAKAFTER' => '{DISABLEPAGEBREAKAFTER}',
            'MARGIN[1 left right top bottom]' => '{MARGIN}',
            '*e*DATEISSUE[d F Y (D)]' => '{DATEISSUE}',
            'STUDENTPHONENUMBER' => '{STUDENTPHONENUMBER}',
            'RECRUITEDBY' => '{RECRUITEDBY}',
            'AMOUNT' => '{AMOUNT(RM)}',
            '*e*APPLICATIONDATE[j F Y]' => '{APPLICATIONDATE}',
            'ENFORCEMENT' => '{ENFORCEMENT}',
            'CONDITIONALREQ' => '{CONDITIONALREQ}',
            'ENFORCEMENT' => '{ENFORCEMENT}',
            '*e*MAXDURATION' => '{MAXDURATION}',
            'MARGIN[1 left right top bottom]' => '{MARGIN}',
        ))->sort();

        return $placeholder_collection->all();
    }

    public function duration($duration, $frequency = FREQUENCY_MONTHLY)
    {
        $duration_desc = '';

        if (!empty($duration)) {
            //Monthly
            if ($frequency == FREQUENCY_MONTHLY || $duration < 12) {
                $duration_desc = $duration . ' ' . msg('lbl_month', [], true);
            }
            //Yearly
            elseif ($frequency == FREQUENCY_YEARLY) {
                $year = (int) ($duration / 12);
                $month = '';

                if (($result % 12) == 0) {
                    $month = '';
                } elseif (($duration % 12) <= 3) {
                    $month = ' 1/4';
                } elseif (($duration % 12) <= 6) {
                    $month = ' 1/2';
                } elseif (($duration % 12) <= 9) {
                    $month = ' 3/4';
                }

                $duration_desc = $year . $month . ' ' . msg('lbl_year', [], true);
            }
        }

        return $duration_desc;
    }

    public static function ordinalNumber($num)
    {
        if (!in_array(($num % 100), array(11,12,13))) {
            switch ($num % 10) {
        // Handle 1st, 2nd, 3rd
        case 1:  return $num.'st';
        case 2:  return $num.'nd';
        case 3:  return $num.'rd';
      }
        }
        return $num.'th';
    }

    public function getRounding($exnett)
    {
        $lastchar = substr($exnett, -1);

        // dd($lastchar);


        if ($lastchar == "1") {
            $roundingvalue = -0.01;
        } elseif ($lastchar == "2") {
            $roundingvalue = -0.02;
        } elseif ($lastchar == "3") {
            $roundingvalue = 0.02;
        } elseif ($lastchar == "4") {
            $roundingvalue = 0.01;
        } elseif ($lastchar == "6") {
            $roundingvalue = -0.01;
        } elseif ($lastchar == "7") {
            $roundingvalue = -0.02;
        } elseif ($lastchar == "8") {
            $roundingvalue = 0.02;
        } elseif ($lastchar == "9") {
            $roundingvalue = 0.01;
        } elseif ($lastchar == "0" || $lastchar == "5") {
            $roundingvalue = 0;
        }

        $afterrounding = $roundingvalue;
        return $afterrounding;
    }
}
