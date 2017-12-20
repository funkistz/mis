<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ReportTrait;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;

class ReportController extends Controller
{
    use ReportTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(empty($request['year'])){
          $request['year'] = Carbon::now()->year;
        }

        $lava = new Lavacharts;

        $member_data = $this->memberChart($request['year']);
        $course_data = $this->courseChart($request['year']);
        $year_selection = $this->getMemberYearSelection();

        $column = $lava->ColumnChart('columnchart', $member_data, ['height' => 400]);
        $areachart = $lava->AreaChart('areachart', $member_data, []);
        $piechart = $lava->PieChart('piechart', $member_data, ['height' => 400]);

        $coursechart = $lava->ColumnChart('coursechart', $course_data, []);
        $lava->AreaChart('courseareachart', $course_data, []);
        $lava->PieChart('coursepiechart', $course_data, ['height' => 400]);

        $data = [
          'lava' => $lava,
          'year' => $request['year'],
          'year_selection' => $year_selection->toArray()
        ];

        return view('report.index')->with($data);
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
}
