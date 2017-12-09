<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\AdminLog;
use App\Traits\CaptureIpTrait;
use Auth;
use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;

class UsersManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = @$request->get('role');
        if(!empty($role)){
          $users = User::whereHas('roles', function ($query) use($role) {
              $query->where('slug', $role);
              $query->whereNotIn('roles.id', [6, 7]);
          })->get();
          $role_name = ucfirst($role);
        }else{
          $users = User::whereHas('roles', function ($query) {
              $query->whereNotIn('roles.id', [6, 7]);
          })->get();
          $role_name = 'User';
        }
        $roles = Role::all();

        return View('usersmanagement.show-users', compact('users', 'roles', 'role_name'));
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

        return view('usersmanagement.create-user')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'first_name'            => 'required|max:255|unique:users',
                'last_name'             => 'required|max:255|unique:users',
                'email'                 => 'required|email|max:255|unique:users',
                'password'              => 'required|min:6|max:20|confirmed',
                'password_confirmation' => 'required|same:password',
                'role'                  => 'required',
            ],
            [
                'name.unique'           => trans('auth.userNameTaken'),
                'name.required'         => trans('auth.userNameRequired'),
                'first_name.required'   => trans('auth.fNameRequired'),
                'last_name.required'    => trans('auth.lNameRequired'),
                'email.required'        => trans('auth.emailRequired'),
                'email.email'           => trans('auth.emailInvalid'),
                'password.required'     => trans('auth.passwordRequired'),
                'password.min'          => trans('auth.PasswordMin'),
                'password.max'          => trans('auth.PasswordMax'),
                'role.required'         => trans('auth.roleRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $ipAddress = new CaptureIpTrait();
        $profile = new Profile();

        $user = User::create([
            'name'              => $request->input('name'),
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'password'          => bcrypt($request->input('password')),
            'token'             => str_random(64),
            'admin_ip_address'  => $ipAddress->getClientIp(),
            'activated'         => 1,
        ]);

        $user->profile()->save($profile);
        $user->attachRole($request->input('role'));
        $user->save();

        $log = 'Created new ' . Role::find($request->input('role'))->name . ' named ' . $user->name;
        AdminLog::create([
          'user_id' => auth()->user()->id,
          'log' => $log
        ]);

        return redirect('users')->with('success', trans('usersmanagement.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('usersmanagement.show-user')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('level','!=' ,1)->get();

        foreach ($user->roles as $user_role) {
            $currentRole = $user_role;
        }

        $data = [
            'user'          => $user,
            'roles'         => $roles,
            'currentRole'   => $currentRole,
        ];

        return view('usersmanagement.edit-user')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $currentUser = Auth::user();
        $user = User::find($id);
        $emailCheck = ($request->input('email') != '') && ($request->input('email') != $user->email);
        $ipAddress = new CaptureIpTrait();

        if ($emailCheck) {
            $validator = Validator::make($request->all(), [
                'first_name'      => 'required|max:255',
                'last_name'      => 'required|max:255',
                'email'     => 'email|max:255|unique:users',
                'password'  => 'present|confirmed|min:6',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'first_name'      => 'required|max:255',
                'last_name'      => 'required|max:255',
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

        $log = 'Edited user ' . $user->name;
        AdminLog::create([
          'user_id' => auth()->user()->id,
          'log' => $log
        ]);

        return back()->with('success', trans('usersmanagement.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = Auth::user();
        $user = User::findOrFail($id);
        $ipAddress = new CaptureIpTrait();

        if ($user->id != $currentUser->id) {
            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();

            if(!empty($user->userable)){
              $user->userable->delete();
            }

            $log = 'Deleted user ' . $user->name;
            AdminLog::create([
              'user_id' => auth()->user()->id,
              'log' => $log
            ]);

            return redirect('users')->with('success', trans('usersmanagement.deleteSuccess'));
        }


        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }
}
