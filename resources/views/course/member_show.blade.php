@extends('layouts.app')

@section('template_title')
  Showing User {{ $course->name }}
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="panel panel-success">

          <div class="panel-heading">
            <a href="/member_courses/" class="btn btn-primary btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              <span class="hidden-xs">Back</span>
            </a>
            Course Information
          </div>
          <div class="panel-body">



            @if ($course->name)

              <div class="col-sm-5 col-xs-6 text-larger">
                <strong>Name</strong>
              </div>

              <div class="col-sm-7">
                {{ $course->course->name }} - {{ $course->name }}
              </div>

              <div class="clearfix"></div>
              <div class="border-bottom"></div>

            @endif

            @if ($course->venue)

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>Venue</strong>
            </div>

            <div class="col-sm-7">
              {{ $course->venue }}
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            @endif

            @if ($course->date)

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>Date</strong>
            </div>

            <div class="col-sm-7">
              {{ $course->date->format('d M Y') }}
            </div>

            <div class="clearfix"></div>
            <div class="border-bottom"></div>

            @endif

            @if ($course->description)

              <div class="col-sm-5 col-xs-6 text-larger">
                <strong>
                  Description
                </strong>
              </div>

              <div class="col-sm-7">
                {{ $course->description }}
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
