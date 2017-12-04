@extends('layouts.app')

@section('template_title')
  Create New User
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">

            Create New Course

            <a href="/courses" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Course</span>
            </a>

          </div>
          <div class="panel-body">

            {!! Form::open(array('action' => 'CourseController@store')) !!}

              <div class="form-group has-feedback row {{ $errors->has('course_id') ? ' has-error' : '' }}">
                  <label for="course_id" class="col-md-3 control-label">Course</label>
                  <div class="col-md-9">
                      {!! Form::select('course_id', $courses, null, ['placeholder' => 'Please choose...', 'class' => 'form-control', 'required' => true]) !!}
                      @if ($errors->has('course_id'))
                          <span class="help-block">
                              <strong>{{ $errors->first('course_id') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                {!! Form::label('name', 'Name', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  {!! Form::text('name', NULL, array('id' => 'name', 'class' => 'form-control', 'placeholder' => '')) !!}
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('date') ? ' has-error ' : '' }}">
                {!! Form::label('date', 'Date', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  {!! Form::date('date', null, ['class' => 'form-control']) !!}
                  @if ($errors->has('date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('date') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('description') ? ' has-error ' : '' }}">
                {!! Form::label('description', 'Description', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'description', 'id' => 'description', 'rows' => 3, 'autofocus']) !!}
                  @if ($errors->has('description'))
                    <span class="help-block">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('venue') ? ' has-error ' : '' }}">
                {!! Form::label('venue', 'Venue', array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  {!! Form::textarea('venue', null, ['class' => 'form-control', 'placeholder' => 'venue', 'id' => 'venue', 'rows' => 3, 'autofocus']) !!}
                  @if ($errors->has('venue'))
                    <span class="help-block">
                        <strong>{{ $errors->first('venue') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;' . 'Create New Course', array('class' => 'btn btn-success btn-flat margin-bottom-1 pull-right','type' => 'submit', )) !!}

            {!! Form::close() !!}

          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer_scripts')
@endsection
