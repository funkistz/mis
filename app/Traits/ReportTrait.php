<?php

namespace App\Traits;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\Course;
use App\Models\CourseClass;
use Khill\Lavacharts\Lavacharts;

trait ReportTrait
{
    public function memberChart($year)
    {
        $column_chart_data = $this->getMemberMonthData($year);

        $lava = new Lavacharts;

        $member_data = $lava->DataTable();

        $member_data->addStringColumn('Month')
                ->addNumberColumn('Member')
                ->addRow(['JAN',  $column_chart_data[1]])
                ->addRow(['FEB',  $column_chart_data[2]])
                ->addRow(['MAR',  $column_chart_data[3]])
                ->addRow(['APR',  $column_chart_data[4]])
                ->addRow(['MAY',  $column_chart_data[5]])
                ->addRow(['JUN',  $column_chart_data[6]])
                ->addRow(['JUL',  $column_chart_data[7]])
                ->addRow(['AUG',  $column_chart_data[8]])
                ->addRow(['SEP',  $column_chart_data[9]])
                ->addRow(['OCT',  $column_chart_data[10]])
                ->addRow(['NOV',  $column_chart_data[11]])
                ->addRow(['DEC',  $column_chart_data[12]]);

        return $member_data;
    }

    public function courseChart($year)
    {
        $course = CourseClass::withCount('membersAccepted')
        ->whereYear('created_at', $year)->get();

        $lava = new Lavacharts;

        $course_data = $lava->DataTable();
        $course_data->addStringColumn('Course')->addNumberColumn('Member');

        foreach ($course as $key => $value) {
            $course_data->addRow([$value->name,  $value->members_accepted_count]);
        }

        return $course_data;
    }

    public function getMemberYearSelection(){

        $members = Member::whereHas('user', function ($query) {
            $query->where('activated', true);
        })->get()->pluck('created_at', 'created_at');

        $year_selection = collect();

        foreach ($members as $key => $value) {

          $year_convert = $value->format('Y');

          $year_selection->put($year_convert, $year_convert);
        }

        return $year_selection;
    }

    public function getMemberMonthData($year){

        if(empty($year)){
          $year = Carbon::now()->year;
        }

        $members = Member::whereHas('user', function ($query) {
            $query->where('activated', true);
        })
        ->whereYear('created_at', $year)
        ->select('id', 'created_at')
        ->get()
        ->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        $usermcount = [];
        $userArr = [];

        foreach ($members as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[$i] = $usermcount[$i];
            }else{
                $userArr[$i] = 0;
            }
        }

        return $userArr;
    }

    public function getMemberCourseData($year){
        $members = Member::whereHas('user', function ($query) {
            $query->where('activated', true);
        })
        ->whereYear('created_at', $year)
        ->select('id', 'created_at')
        ->get()
        ->groupBy(function($date) {
            //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        $usermcount = [];
        $userArr = [];

        foreach ($members as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++){
            if(!empty($usermcount[$i])){
                $userArr[$i] = $usermcount[$i];
            }else{
                $userArr[$i] = 0;
            }
        }

        return $userArr;
    }

}
