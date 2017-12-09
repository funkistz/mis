@extends('layouts.app')

@section('template_title')
  Showing User {{ $user->name }}
@endsection

@php
  $levelAmount = trans('usersmanagement.labelUserLevel');
  if ($user->level() >= 2) {
      $levelAmount = trans('usersmanagement.labelUserLevels');
  }
@endphp

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="panel @if ($user->activated == 1) panel-success @else panel-danger @endif">

          <div class="panel-heading">
            <a href="/members/" class="btn btn-primary btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              <span class="hidden-xs">Back to Members</span>
            </a>
            Member Information
          </div>
          <div class="panel-body">

            <div class="well">
              <div class="row">
                <div class="col-sm-6">
                  <img src="@if ($user->profile && $user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" id="" class="img-circle center-block margin-bottom-2 margin-top-1 user-image">
                </div>

                <div class="col-sm-6">
                  <h4 class="text-muted margin-top-sm-1 text-center text-left-tablet">
                    {{ $user->name }}
                  </h4>
                  <p class="text-center text-left-tablet">
                    {{ HTML::mailto($user->email, $user->email) }}
                  </p>

                  @if ($user->profile)
                    <div class="text-center text-left-tablet margin-bottom-1">

                      <a href="{{ url('/profile/'.$user->name) }}" class="btn btn-sm btn-info">
                        <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md"> {{ trans('usersmanagement.viewProfile') }}</span>
                      </a>

                      <a href="/members/{{$user->id}}/edit" class="btn btn-sm btn-warning">
                        <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md"> {{ trans('usersmanagement.editUser') }} </span>
                      </a>

                      {!! Form::open(array('url' => 'members/' . $user->id, 'class' => 'form-inline')) !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md">' . trans('usersmanagement.deleteUser') . '</span>' , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user?')) !!}
                      {!! Form::close() !!}

                    </div>
                  @endif

                </div>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            @if ($user->email)

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                {{ trans('usersmanagement.labelEmail') }}
              </strong>
            </div>

            <div class="col-sm-7">
              {{ HTML::mailto($user->email, $user->email) }}
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            @endif

            @if ($user->name)

              <div class="col-sm-5 col-xs-6 text-larger">
                <strong>
                  Name
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                {{ trans('usersmanagement.labelRole') }}
              </strong>
            </div>

            <div class="col-sm-7">
              @foreach ($user->roles as $user_role)

                @if ($user_role->name == 'User')
                  @php $labelClass = 'primary' @endphp

                @elseif ($user_role->name == 'Admin')
                  @php $labelClass = 'warning' @endphp

                @elseif ($user_role->name == 'Unverified')
                  @php $labelClass = 'danger' @endphp

                @else
                  @php $labelClass = 'default' @endphp

                @endif

                <span class="label label-{{$labelClass}}">{{ $user_role->name }}</span>

              @endforeach
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                {{ trans('usersmanagement.labelStatus') }}
              </strong>
            </div>

            <div class="col-sm-7">
              @if ($user->activated == 1)
                <span class="label label-success">
                  Activated
                </span>
              @else
                <span class="label label-danger">
                  Not-Activated
                </span>
              @endif
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Race
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->race->name }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Date of birth
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->date_of_birth }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Place of birth
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->place_of_birth }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                IC
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->nric }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Nationality
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->nationality->name }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Phone no
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->phone_1 }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Home no
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->phone_2 }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Education level
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->educationLevel->name }}
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Illness
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->userable->illness }}
              </ul>
            </div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Address
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                {{ $user->getPrimaryAddress()->line_1 }}<br>
                {{ $user->getPrimaryAddress()->line_2 }}<br>
                {{ $user->getPrimaryAddress()->post_code }}<br>
                {{ $user->getPrimaryAddress()->city }}<br>
                {{ $user->getPrimaryAddress()->state }}<br>
                {{ $user->getPrimaryAddress()->country->name }}<br>
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Coach
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                @foreach( $user->userable->coaches as $coach)
                <li class="list-group-item">{{$coach->user->name}}</li>
                @endforeach
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>
                Course
              </strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group">
                @foreach( $user_course as $course)
                <li class="list-group-item">{{$course->course->name}} - {{$course->name}}</li>
                @endforeach
              </ul>
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            @if ($user->created_at)

              <div class="col-sm-5 col-xs-6 text-larger">
                <strong>
                  {{ trans('usersmanagement.labelCreatedAt') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->created_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($user->updated_at)

              <div class="col-sm-5 col-xs-6 text-larger">
                <strong>
                  {{ trans('usersmanagement.labelUpdatedAt') }}
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $user->updated_at }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif


          </div>

        </div>
      </div>
    </div>
  </div>

  @include('modals.modal-delete')

@endsection

@section('footer_scripts')

  @include('scripts.delete-modal-script')

@endsection
