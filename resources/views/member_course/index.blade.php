@extends('layouts.app')

@section('template_title')
  Showing Member Course
@endsection

@section('template_linked_css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style type="text/css" media="screen">
        .users-table {
            border: 0;
        }
        .users-table tr td:first-child {
            padding-left: 15px;
        }
        .users-table tr td:last-child {
            padding-right: 15px;
        }
        .users-table.table-responsive,
        .users-table.table-responsive table {
            margin-bottom: 0;
        }

    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">

                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            Showing All Member Courses

                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Venue</th>
                                        <th>Actions</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($members->courseClasses as $course)
                                        <tr>
                                            <td>{{$course->course->name}} - {{$course->name}}</td>
                                            <td>{{$course->date}}</td>
                                            <td>{{$course->decription}}</td>
                                            <td>{{$course->venue}}</td>
                                            <td>
                                              @can('acceptCourse', $course)
                                                {!! Form::open(array('url' => 'member_courses/' . $course->id . '?status=1', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Accept')) !!}
                                                    {!! Form::hidden('_method', 'PUT') !!}
                                                    {!! Form::button('<i class="fa fa-check fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Accept</span>', array('class' => 'btn btn-primary btn-sm margin-bottom-xs','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Accept Course', 'data-message' => 'Are you sure you want to accept this Course ?')) !!}
                                                {!! Form::close() !!}

                                                {!! Form::open(array('url' => 'member_courses/' . $course->id . '?status=0', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Decline')) !!}
                                                    {!! Form::hidden('_method', 'PUT') !!}
                                                    {!! Form::button('<i class="fa fa-check fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Decline</span>', array('class' => 'btn btn-danger btn-sm margin-bottom-xs','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Decline Course', 'data-message' => 'Are you sure you want to decline this Course ?')) !!}
                                                {!! Form::close() !!}
                                              @else
                                                @if(!empty($course->pivot->accepted))
                                                  <span class="label label-success">Accepted</span>
                                                @else
                                                  <span class="label label-danger">Declined</span>
                                                @endif
                                              @endcan

                                              <a class="btn btn-primary" href="{{ route('member_courses.show', $course->id) }}" >View</a>
                                            </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')

@endsection

@section('footer_scripts')

    @if (count($members->courses) > 10)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
@endsection
