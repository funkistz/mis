<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;
use App\Traits\CaptureIpTrait;
use App\Models\Course;
use App\Models\Profile;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
          'users' => User::where('userable_type', 'App\Models\Member')->get(),
          'roles' => Role::all()
        ];

        return view('member.index')->with($data);
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
        $user = User::find($id);
        $user_course = $user->userable->courses;

        $data = [
            'user' => $user,
            'user_course' => $user_course
        ];
        return view('member.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user_course = $user->userable->courses->pluck('id')->toArray();

        $data = [
            'user' => $user,
            'user_course' => @$user_course,
            'course' => Course::all()->pluck('name','id')->toArray()
        ];

        return view('member.edit')->with($data);
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
        $currentUser = auth()->user();
        $user = User::find($id);
        $member = $user->userable;

        $emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email);
        $ipAddress = new CaptureIpTrait();

        if ($emailCheck) {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:255',
                'email'     => 'email|max:255|unique:users',
                'password'  => 'present|confirmed|min:6',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'      => 'required|max:255',
                'password'  => 'nullable|confirmed|min:6',
            ]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $request->input('name');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');

        if ($emailCheck) {
            $user->email = $request->input('email');
        }

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->detachAllRoles();
        $user->attachRole($request->input('role'));
        $user->updated_ip_address = $ipAddress->getClientIp();
        $user->save();

        $member->courses()->detach();
        if(!empty($request->course)){
          foreach ($request->course as $course) {
            $member->courses()->attach($course);
          }
        }

        return back()->with('success', 'Member Updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = auth()->user();
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        if ($user->id != $currentUser->id) {
            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();

            return redirect('members')->with('success', trans('usersmanagement.deleteSuccess'));
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approveMember($id)
    {
      $currentUser = auth()->user();
      $user = User::findOrFail($id);

      if ($user->id != $currentUser->id) {
          $user->update([
            'activated' => true
          ]);

          Profile::create([
            'user_id' => $id,
            'theme_id' => 1,
          ]);

          return redirect('members')->with('success', 'Member Approved');
      }

      return back()->with('error', 'Some error occured');
    }
}
