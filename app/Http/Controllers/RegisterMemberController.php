<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Race;
use App\Models\Nationality;
use App\Models\EducationLevel;
use App\Models\Country;
use App\Models\User;
use App\Models\Member;

use App\Http\Requests\RegisterMemberRequest;

class RegisterMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
          'race' => Race::all()->pluck('name','id')->toArray(),
          'nationality' => Nationality::all()->pluck('name','id')->toArray(),
          'education_level' => EducationLevel::all()->pluck('name','id')->toArray(),
          'country' => Country::all()->pluck('name','iso_3166_2')->toArray()
        ];

        return view('member.register')->with($data);
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
    public function store(RegisterMemberRequest $request)
    {
        // dd($request->all());

        DB::beginTransaction();

        try {

          //Member
          $member = Member::create($request->only([
            'gender',
            'race_id',
            'date_of_birth',
            'place_of_birth',
            'nric',
            'nationality_id',
            'phone_1',
            'phone_2',
            'education_level_id',
            'illness'
            ]
          ));

          //User
          $request['password'] = Hash::make($request['password']);
          $request['userable_type'] = Member::class;
          $request['userable_id'] = $member->id;
          $request['token'] = $request['_token'];
          $user = User::create($request->only([
            'token',
            'username',
            'name',
            'email',
            'password',
            'userable_type',
            'userable_id',
            ]
          ));

          $user->attachRole(ROLE_MEMBER);

          //Address
          $request['is_primary'] = 1;
          $user->addAddress($request->address);

        } catch(\Exception $e) {
          DB::rollback();
          throw $e;
        }

        DB::commit();

        return 'Thank you for your registration. please wait for your approval';
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
