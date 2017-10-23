@extends('layouts.app')

@section('template_title')
    Member Card Registration
@endsection

@section('head')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register Member Card</div>
                <div class="panel-body">

                    {!! Form::open(['route' => 'member_card.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST'] ) !!}

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('blood_type') ? ' has-error' : '' }}">
                            <label for="blood_type" class="col-sm-4 control-label">Blood Type</label>
                            <div class="col-sm-6">
                                {!! Form::select('blood_type', ['AB','A','B','O'], null, ['placeholder' => 'Please choose...', 'class' => 'form-control']) !!}
                                @if ($errors->has('blood_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('blood_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('rank_id') ? ' has-error' : '' }}">
                            <label for="rank_id" class="col-sm-4 control-label">Rank</label>
                            <div class="col-sm-6">
                                {!! Form::select('rank_id', $rank, null, ['placeholder' => 'Please choose...', 'class' => 'form-control']) !!}
                                @if ($errors->has('rank_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rank_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group margin-bottom-2">
                            <div class="col-sm-6 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
