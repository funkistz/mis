@extends('layouts.app')

@section('template_title')
  Editing User {{ $user->name }}
@endsection

@section('template_linked_css')
  <style type="text/css">
    .btn-save,
    .pw-change-container {
      display: none;
    }
  </style>
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">

            <strong>Editing Member:</strong> {{ $user->name }}

            <a href="/members" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              <span class="hidden-xs">Back to </span>Member
            </a>

          </div>

          {!! Form::model($user, array('action' => array('MemberController@update', $user->id), 'method' => 'PUT')) !!}

            {!! csrf_field() !!}

            <div class="panel-body">

              <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                {!! Form::label('email', 'E-mail' , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('email', old('email'), array('id' => 'email', 'class' => 'form-control', 'placeholder' => trans('forms.ph-useremail'))) !!}
                    <label class="input-group-addon" for="email"><i class="fa fa-fw fa-envelope " aria-hidden="true"></i></label>
                  </div>
                </div>
              </div>


              <div class="form-group has-feedback row {{ $errors->has('first_name') ? ' has-error ' : '' }}">
                {!! Form::label('name', 'First Name', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('first_name', old('first_name'), array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => 'First Name')) !!}
                    <label class="input-group-addon" for="first_name"><i class="fa fa-fw {{ trans('forms.create_user_icon_firstname') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('last_name') ? ' has-error ' : '' }}">
                {!! Form::label('last_name', 'Last Name', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('last_name', old('last_name'), array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => 'Last Name')) !!}
                    <label class="input-group-addon" for="last_name"><i class="fa fa-fw {{ trans('forms.create_user_icon_firstname') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              @role(['coofficer'])
              <div class="form-group has-feedback row {{ $errors->has('coach[]') ? ' has-error ' : '' }}">
                {!! Form::label('coach[]', 'coach', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  {!! Form::select('coach[]', $coach, $user_coach, array('multiple' => 'multiple','name' => 'coach[]', 'id' => 'coach', 'class' => 'form-control')) !!}
                  @if ($errors->has('coach'))
                    <span class="help-block">
                        <strong>{{ $errors->first('coach') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              @endrole

              <div class="pw-change-container">
                <div class="form-group has-feedback row">
                  {!! Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 control-label')); !!}
                  <div class="col-md-9">
                    <div class="input-group">
                      {!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'))) !!}
                      <label class="input-group-addon" for="password"><i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}" aria-hidden="true"></i></label>
                    </div>
                  </div>
                </div>

                <div class="form-group has-feedback row">
                  {!! Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-3 control-label')); !!}
                  <div class="col-md-9">
                    <div class="input-group">
                      {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))) !!}
                      <label class="input-group-addon" for="password_confirmation"><i class="fa fa-fw {{ trans('forms.create_user_icon_pw_confirmation') }}" aria-hidden="true"></i></label>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="panel-footer">

              <div class="row">

                <div class="col-xs-6">
                  <a href="#" class="btn btn-default btn-block margin-bottom-1 btn-change-pw" title="Change Password">
                    <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
                    <span></span> Change Password
                  </a>
                </div>
                <div class="col-xs-6">
                  {!! Form::button('<i class="fa fa-fw fa-save" aria-hidden="true"></i> Save Changes', array('class' => 'btn btn-success btn-block margin-bottom-1 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                </div>
              </div>
            </div>

          {!! Form::close() !!}

        </div>
      </div>
    </div>
  </div>

  @include('modals.modal-save')
  @include('modals.modal-delete')

@endsection

@section('footer_scripts')
  <script>
  $(document).ready(function() {
      $('#course').select2();
      $('#coach').select2();
  });
  </script>
  @include('scripts.delete-modal-script')
  @include('scripts.save-modal-script')
  @include('scripts.check-changed')

@endsection
