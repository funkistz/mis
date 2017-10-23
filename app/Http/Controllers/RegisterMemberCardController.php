<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rank;
use App\Models\MemberCard;
use App\Http\Requests\MemberCardRequest;
use Carbon\Carbon;

class RegisterMemberCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
          'rank' => Rank::all()->pluck('name','id')->toArray(),
        ];

        return view('member_card.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberCardRequest $request)
    {
        $request['due_date'] = Carbon::now()->addMonths( config('settings.memberDueDuration') );
        $request['card_no'] = $this->randomNumber(12);

        //todo get member activated date
        $request['induction'] = Carbon::now();

        // dd($request->all());

        $member_card = MemberCard::create($request->only(['card_no', 'blood_type', 'rank_id', 'induction', 'due_date']));

        $member = auth()->user()->userable;

        $member->update([
          'member_card_id' => $member_card->id
        ]);

        return redirect( url('home') )->with('success', 'Member Card Registered Succesfully');
    }

    public function randomNumber($length) {
        $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
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
