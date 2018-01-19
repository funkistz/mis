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
            <a href="/courses/" class="btn btn-primary btn-xs pull-right hidden-print">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              <span class="hidden-xs">Back to Courses</span>
            </a>
            <button class="btn btn-xs btn-default pull-right hidden-print pull-right" onclick="window.print()" style="margin-right:5px;">Print</button>
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

            <div class="col-sm-5 col-xs-6 text-larger">
              <strong>Participant(s)</strong>
            </div>

            <div class="col-sm-7">
              <ul class="list-group hidden-print">
                @foreach ($course->members as $member)
                <li class="list-group-item">{{ $loop->index+1 . '. ' . $member->user->first_name . ' ' . $member->user->last_name }}
                  <div class="pull-right">
                    <!-- <button class="btn btn-sm btn-success action-attendance" data-id="{{ $course->id }}" data-member-id="{{ $member->id }}" data-attendance="1" >Attend</button>
                    <button class="btn btn-sm btn-danger action-attendance" data-id="{{ $course->id }}" data-member-id="{{ $member->id }}" data-attendance="2" >Not Attend</button> -->
                    <label class="radio-inline">
                      <input class="action-attendance" type="radio"
                      name="attendance-{{ $member->id }}" data-id="{{ $course->id }}" value="1"
                      data-member-id="{{ $member->id }}" data-attendance="1" {{ ($member->pivot->attendance == 1)? 'checked':'' }}>Attend
                    </label>
                    <label class="radio-inline">
                      <input class="action-attendance" type="radio"
                      name="attendance-{{ $member->id }}" data-id="{{ $course->id }}" value="2"
                      data-member-id="{{ $member->id }}" data-attendance="2" {{ ($member->pivot->attendance == 2)? 'checked':'' }}>Not Attend
                    </label>
                  </div>
                </li>
                @endforeach
              </ul>
              <table class="table visible-print-inline" style="width:100%;">
                <thead>
                  <th>no.</th>
                  <th>Name</th>
                  <th>Attedance</th>
                </thead>
                <tbody>
                  @foreach ($course->members as $member)
                  <tr>
                    <td>{{ $loop->index+1 }}</td>
                    <td>{{ $member->user->first_name . ' ' . $member->user->last_name }}</td>
                    <td id="row-{{ $member->id }}">
                      @if($member->pivot->attendance == 1)
                      Attend
                      @elseif($member->pivot->attendance == 2)
                      Not Attend
                      @else
                      N/A
                      @endif
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <table>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

  @include('modals.modal-delete')

@endsection

@section('footer_scripts')

  @include('scripts.delete-modal-script')
  <script>
  $(function() {
     $('.action-attendance').change(function() {

       var course_id = $(this).data('id');
       var course_member_id = $(this).data('member-id');
       var attendance = $(this).data('attendance');

       $.ajax({
           type: "POST",
           url:'{{ url('courses') }}/' + course_id + '/attendance/' + course_member_id,
           data: {attendance:attendance},
           headers: {
               'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
           },
           success:function(data){
              if(attendance == 1 ){
                $('#row-' + course_member_id).html('Attend')
              }

              if(attendance == 2 ){
                $('#row-' + course_member_id).html('Not Attend')
              }
               console.log(data);
           },
           error: function(data){
              alert('Some error occured');
           }
       });
      });
  });
  </script>

@endsection
