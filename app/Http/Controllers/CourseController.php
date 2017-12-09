<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseClass;
use App\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
          'course' => CourseClass::with('course')->get()
        ];

        return view('course.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
          'courses' => Course::all()->pluck('name', 'id')->toArray()
        ];
        return view('course.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $request['is_active'] = 1;
        CourseClass::create($request->only([
          'course_id',
          'name',
          'date',
          'description',
          'venue',
          'is_active',
        ]));

        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [
          'course' => CourseClass::find($id)
        ];

        return view('course.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
          'courses' => Course::all()->pluck('name', 'id')->toArray(),
          'course' => CourseClass::find($id)
        ];
        return view('course.update')->with($data);
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
        CourseClass::find($id)->update($request->only([
          'course_id',
          'name',
          'date',
          'description',
          'venue'
        ]));

        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = CourseClass::findOrFail($id);
        $course->delete();

        return redirect('courses')->with('success', 'Course Deleted Successfully');

    }
}
