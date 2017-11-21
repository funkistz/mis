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

                            Showing All Members

                            <div class="btn-group pull-right btn-group-xs">

                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                                    <span class="sr-only">
                                        Show Course Management Menu
                                    </span>
                                </button>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/courses/create">
                                            <i class="fa fa-fw fa-user-plus" aria-hidden="true"></i>
                                            Create New Course
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
                                    @foreach($members->courses as $course)
                                        <tr>
                                            <td>{{$course->name}}</td>
                                            <td>{{$course->date}}</td>
                                            <td>{{$course->decription}}</td>
                                            <td>{{$course->venue}}</td>
                                            <td>
                                              @can('acceptCourse', $course)
                                                {!! Form::open(array('url' => 'member_courses/' . $course->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Accept')) !!}
                                                    {!! Form::hidden('_method', 'PUT') !!}
                                                    {!! Form::button('<i class="fa fa-check fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Accept</span><span class="hidden-xs hidden-sm hidden-md"> Course</span>', array('class' => 'btn btn-primary btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => 'Accept Course', 'data-message' => 'Are you sure you want to accept this Course ?')) !!}
                                                {!! Form::close() !!}
                                              @else
                                              Accepted
                                              @endcan
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
