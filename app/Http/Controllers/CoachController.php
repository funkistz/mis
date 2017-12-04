<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coach;
use App\Models\Profile;
use App\Models\User;
use App\Traits\CaptureIpTrait;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
          'users' => User::where('userable_type', 'App\Models\Coach')->get(),
          'roles' => Role::all()
        ];

        return view('coach.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        $data = [
            'roles' => $roles,
        ];

        return view('coach.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ipAddress = new CaptureIpTrait();
        $profile = new Profile();

        $coach = Coach::create([
          'phone_1' => $request->input('phone_1'),
        ]);

        $user = User::create([
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'password'          => bcrypt($request->input('password')),
            'token'             => str_random(64),
            'admin_ip_address'  => $ipAddress->getClientIp(),
            'activated'         => 1,
            'userable_type'         => Coach::class,
            'userable_id'         => $coach->id,
        ]);

        $user->profile()->save($profile);
        $user->attachRole(7);
        $user->save();

        return redirect('coachs/' . $user->id)->with('success', 'Coach Succesfully Created');
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

        $data = [
            'user' => $user,
        ];
        return view('coach.show')->with($data);
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

        $data = [
            'user' => $user,
        ];

        return view('coach.edit')->with($data);
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

        if ($emailCheck) {
            $user->email = $request->input('email');
        }

        if ($request->input('password') != null) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->updated_ip_address = $ipAddress->getClientIp();
        $user->save();

        Coach::find($user->userable_id)->update([
          'phone_1' => $request->input('phone_1')
        ]);

        return back()->with('success', 'Coach Updated Succesfully');
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

            return redirect('coachs')->with('success', 'Coach Deleted Sucessfully');
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    public function memberList($id)
    {
        $user = User::findOrFail($id);

        $data = [
            'user' => $user,
        ];

        return view('coach.table')->with($data);
    }
}
