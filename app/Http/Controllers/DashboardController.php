<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;
use App\Models\Member;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $column_chart_data = $this->getMemberMonthData();

        $lava = new Lavacharts;

        $reasons = $lava->DataTable();

        $reasons->addStringColumn('Month')
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


        $donutchart = $lava->ColumnChart('columnchart', $reasons, []);
        $barchart = $lava->BarChart('barchart', $reasons, []);
        $areachart = $lava->AreaChart('areachart', $reasons, []);
        $piechart = $lava->PieChart('piechart', $reasons, []);

        $data = [
          'lava' => $lava
        ];

        return view('dashboard.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getMemberMonthData(){
        $members = Member::whereHas('user', function ($query) {
            $query->where('activated', true);
        })
        ->whereYear('created_at', '2017')
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

    public function getMemberCourseData(){
        $members = Member::whereHas('user', function ($query) {
            $query->where('activated', true);
        })
        ->whereYear('created_at', '2017')
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
