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

          {!! Form::model($user, array('action' => array('AssignCourseController@update', $user->id), 'method' => 'PUT')) !!}

            {!! csrf_field() !!}

            <div class="panel-body">

              @role(['staff'])
              <div class="form-group has-feedback row {{ $errors->has('course[]') ? ' has-error ' : '' }}">
                {!! Form::label('course[]', 'Course', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  {!! Form::select('course[]', $course, $user_course, array('multiple' => 'multiple','name' => 'course[]', 'id' => 'course', 'class' => 'form-control')) !!}
                  @if ($errors->has('course'))
                    <span class="help-block">
                        <strong>{{ $errors->first('course') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              @endrole

            </div>
            <div class="panel-footer">

              <div class="row">

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
  });
  </script>
  @include('scripts.delete-modal-script')
  @include('scripts.save-modal-script')
  @include('scripts.check-changed')

@endsection
