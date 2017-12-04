@extends('layouts.app')

@section('template_title')
    Member Registration
@endsection

@section('head')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register as Member</div>
                <div class="panel-body">

                    {!! Form::open(['route' => 'register_member.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST'] ) !!}

                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <label for="first_name" class="col-sm-4 control-label">First Name</label>
                            <div class="col-sm-6">
                                {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'first_name']) !!}
                                @if ($errors->has('first_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <label for="last_name" class="col-sm-4 control-label">Last Name</label>
                            <div class="col-sm-6">
                                {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'last_name']) !!}
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-sm-4 control-label">E-Mail Address</label>
                            <div class="col-sm-6">
                                {!! Form::email('email', null, ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'E-Mail Address', 'required']) !!}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-6">
                                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password', 'required']) !!}
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-sm-4 control-label">Confirm Password</label>
                            <div class="col-sm-6">
                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password-confirm', 'placeholder' => 'Confirm Password', 'required']) !!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="col-sm-4 control-label">Gender</label>
                            <div class="col-sm-6">
                              <label class="radio-inline"><input type="radio" name="gender" value="m" >Male</label>
                              <label class="radio-inline"><input type="radio" name="gender" value="f" >Female</label>
                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('race_id') ? ' has-error' : '' }}">
                            <label for="race_id" class="col-sm-4 control-label">Race</label>
                            <div class="col-sm-6">
                                {!! Form::select('race_id', $race, null, ['placeholder' => 'Please choose...', 'class' => 'form-control']) !!}
                                @if ($errors->has('race_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('race_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
                            <label for="date_of_birth" class="col-sm-4 control-label">Date of Birth</label>
                            <div class="col-sm-6">
                                {!! Form::date('date_of_birth', null, ['class' => 'form-control']) !!}
                                @if ($errors->has('date_of_birth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('place_of_birth') ? ' has-error' : '' }}">
                            <label for="place_of_birth" class="col-sm-4 control-label">Place of Birth</label>
                            <div class="col-sm-6">
                                {!! Form::text('place_of_birth', null, ['class' => 'form-control', 'placeholder' => 'Place of Birth', 'id' => 'place_of_birth', 'required', 'autofocus']) !!}
                                @if ($errors->has('place_of_birth'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('place_of_birth') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nric') ? ' has-error' : '' }}">
                            <label for="nric" class="col-sm-4 control-label">IC</label>
                            <div class="col-sm-6">
                                {!! Form::text('nric', null, ['class' => 'form-control', 'placeholder' => 'Identification Certificated', 'id' => 'nric', 'required', 'autofocus']) !!}
                                @if ($errors->has('nric'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nric') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('nationality_id') ? ' has-error' : '' }}">
                            <label for="nationality_id" class="col-sm-4 control-label">Nationality</label>
                            <div class="col-sm-6">
                                {!! Form::select('nationality_id', $nationality, null, ['placeholder' => 'Please choose...', 'class' => 'form-control']) !!}
                                @if ($errors->has('nationality_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nationality_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_1') ? ' has-error' : '' }}">
                            <label for="phone_1" class="col-sm-4 control-label">Phone No</label>
                            <div class="col-sm-6">
                                {!! Form::text('phone_1', null, ['class' => 'form-control', 'placeholder' => 'Mobile', 'id' => 'phone_1', 'required', 'autofocus']) !!}
                                @if ($errors->has('phone_1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone_2') ? ' has-error' : '' }}">
                            <label for="phone_2" class="col-sm-4 control-label">Home No</label>
                            <div class="col-sm-6">
                                {!! Form::text('phone_2', null, ['class' => 'form-control', 'placeholder' => 'Home', 'id' => 'phone_2', 'required', 'autofocus']) !!}
                                @if ($errors->has('phone_2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone_2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('education_level_id') ? ' has-error' : '' }}">
                            <label for="education_level_id" class="col-sm-4 control-label">Educational Level</label>
                            <div class="col-sm-6">
                                {!! Form::select('education_level_id', $education_level, null, ['placeholder' => 'Please choose...', 'class' => 'form-control']) !!}
                                @if ($errors->has('education_level_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('education_level_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('illness') ? ' has-error' : '' }}">
                            <label for="illness" class="col-sm-4 control-label">Illness</label>
                            <div class="col-sm-6">
                                {!! Form::textarea('illness', null, ['class' => 'form-control', 'placeholder' => 'please state your illness (if any)', 'id' => 'illness', 'rows' => 3, 'autofocus']) !!}
                                @if ($errors->has('illness'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('illness') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-10 col-md-offset-2">
                          <h4>Address</h4>
                        </div>

                        <div class="form-group{{ $errors->has('address[line_1]') ? ' has-error' : '' }}">
                            <label for="address[line_1]" class="col-sm-4 control-label">Line 1</label>
                            <div class="col-sm-6">
                                {!! Form::text('address[line_1]', null, ['class' => 'form-control', 'placeholder' => 'Line 1', 'id' => 'line_1', 'required', 'autofocus']) !!}
                                @if ($errors->has('address[line_1]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address[line_1]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address[line_2]') ? ' has-error' : '' }}">
                            <label for="address[line_2]" class="col-sm-4 control-label">Line 2</label>
                            <div class="col-sm-6">
                                {!! Form::text('address[line_2]', null, ['class' => 'form-control', 'placeholder' => 'Line 2', 'id' => 'line_2', 'autofocus']) !!}
                                @if ($errors->has('address[line_2]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address[line_2]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address[post_code]') ? ' has-error' : '' }}">
                            <label for="address[post_code]" class="col-sm-4 control-label">Postcode</label>
                            <div class="col-sm-6">
                                {!! Form::number('address[post_code]', null, ['class' => 'form-control', 'placeholder' => 'Postcode', 'id' => 'post_code', 'required', 'autofocus']) !!}
                                @if ($errors->has('address[post_code]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address[post_code]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address[city]') ? ' has-error' : '' }}">
                            <label for="address[city]" class="col-sm-4 control-label">City</label>
                            <div class="col-sm-6">
                                {!! Form::text('address[city]', null, ['class' => 'form-control', 'placeholder' => 'City', 'id' => 'city', 'required', 'autofocus']) !!}
                                @if ($errors->has('address[city]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address[city]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address[state]') ? ' has-error' : '' }}">
                            <label for="address[state]" class="col-sm-4 control-label">State</label>
                            <div class="col-sm-6">
                                {!! Form::select('address[state]', $state, null, ['placeholder' => 'Please choose...', 'class' => 'form-control']) !!}
                                @if ($errors->has('address[state]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address[state]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address[country]') ? ' has-error' : '' }}">
                            <label for="address[country]" class="col-sm-4 control-label">Country</label>
                            <div class="col-sm-6">
                                {!! Form::select('address[country]', $country, 'MY', ['placeholder' => 'Please choose...', 'class' => 'form-control']) !!}
                                @if ($errors->has('address[country]'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address[country]') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(config('settings.reCaptchStatus'))
                            <div class="form-group">
                                <div class="col-sm-6 col-sm-offset-4">
                                    <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group margin-bottom-2">
                            <div class="col-sm-6 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    Clear
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
