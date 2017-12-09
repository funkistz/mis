@extends('layouts.app')

@section('template_title')
    Member Card Registration
@endsection

@section('head')
@endsection

@section('content')

<style>

table th, table td{
  border: 0 !important;
  padding: 4px !important;
}

.card{
  height: auto !important;
}

</style>

@php

$user = auth()->user();
$member = $user->userable;
$card = $member->memberCard;

@endphp

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Member Card</div>
                <div class="panel-body">

                  <div class="card" style="border: solid black 2px; width:600px;">
                    <div class="row">
                      <div class="col-xs-12 text-center">
                        <h5 style="font-weight: bold;">JABATAN PERTAHANAN AWAM MALAYSIA</h5>
                        <h6>JABATAN PERDANA MENTERI</h6>
                        <h4 style="font-weight: bolder;">KAD PELANTIKAN</h4>
                      </div>

                      <div class="col-xs-12">
                        <img src="{{ @Auth::user()->profile->avatar }}" class="rounded pull-left" alt="..." width="150px" style="margin:10px;">
                        <table class="table pull-left" style="width:400px;">
                          <tbody>
                            <tr>
                              <th width="120">Name:</th>
                              <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            </tr>
                            <tr>
                              <th >No. K.P.:</th>
                              <td>{{ $member->nric }}</td>
                            </tr>
                            <tr>
                              <th>No. Anggota:</th>
                              <td>{{ $card->prefix . ' ' . $card->card_no . $card->postfix }}</td>
                            </tr>
                            <tr>
                              <th>Daerah/Unit:</th>
                              <td>DUNGUN</td>
                            </tr>
                            <tr>
                              <th>Tarikh Lantikan:</th>
                              <td>{{ $card->induction->format('d.m.o') }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-xs-12" style="padding-left:25px;">
                        <p style="margin-bottom:0; font-weight: bolder;">No. SIRI</p>
                        <h4 style="margin-top:0px; font-weight: bolder;">{{ $card->card_no}}</h4>
                      </div>
                    </div>

                  </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
