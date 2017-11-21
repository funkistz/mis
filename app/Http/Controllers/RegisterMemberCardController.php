<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rank;
use App\Models\MemberCard;
use App\Http\Requests\MemberCardRequest;
use Carbon\Carbon;
use App\Traits\MemberCardTrait;

class RegisterMemberCardController extends Controller
{
    use MemberCardTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
        ];

        return view('member_card.show')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', MemberCard::class);

        $data = [
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
        $this->authorize('create', MemberCard::class);

        $request['due_date'] = $this->calculateDueDate();
        $request['card_no'] = $this->incrementCardNumber();
        $request['prefix'] = $this->cardPrefix();
        $request['postfix'] = $this->cardPostfix();

        //to update get from setting
        $request['rank_id'] = 1;

        $member_created_at = auth()->user()->userable->created_at->format("Y-m-d H:i:s");
        $request['induction'] = $member_created_at;

        // create
        $member_card = MemberCard::create($request->only(['card_no', 'blood_type', 'rank_id', 'induction', 'due_date', 'prefix', 'postfix']));

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
