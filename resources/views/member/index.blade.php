@extends('layouts.app')

@section('template_title')
  Showing Users
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

                            Showing All {{ ucfirst($member_type) }}
                        </div>
                    </div>

                    <div class="panel-body">

                        <div class="table-responsive users-table">
                            <table class="table table-striped table-condensed data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="hidden-xs">Email</th>
                                        <th class="hidden-xs">Name</th>
                                        <th>Status</th>
                                        <th class="hidden-sm hidden-xs hidden-md">Semester</th>
                                        <th class="hidden-sm hidden-xs hidden-md">Education Level</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        @php $user = $user->user; @endphp
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td class="hidden-xs"><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $user->email }}</a></td>
                                            <td class="hidden-xs">{{$user->first_name}} {{$user->last_name}}</td>
                                            <td>
                                              @if ($user->activated == 1)
                                                <span class="label label-success">
                                                  Activated
                                                </span>
                                              @else
                                                <span class="label label-danger">
                                                  Not-Activated
                                                </span>
                                              @endif
                                            </td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$user->userable->currentSemester}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{$user->userable->educationLevel->name}}</td>
                                            <td>
                                            @role(['officer', 'staff'])
                                                {!! Form::open(array('url' => 'members/' . $user->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Delete</span><span class="hidden-xs hidden-sm hidden-md"> User</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                                {!! Form::close() !!}
                                            @endrole
                                                <a class="btn btn-sm btn-success btn-block" href="{{ URL::to('members/' . $user->id) }}" data-toggle="tooltip" title="Show">
                                                    <i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Show</span><span class="hidden-xs hidden-sm hidden-md"> User</span>
                                                </a>
                                                <a class="btn btn-sm btn-info btn-block" href="{{ URL::to('members/' . $user->id . '/edit') }}" data-toggle="tooltip" title="Edit">
                                                    <i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Edit</span><span class="hidden-xs hidden-sm hidden-md"> User</span>
                                                </a>
                                            @role(['officer'])
                                            @if(empty($user->activated) && $user->userable->member_status_id == 1)
                                              {!! Form::open(array('url' => 'members/' . $user->id . '/approve', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Approve')) !!}
                                                  {!! Form::button('<i class="fa fa-check fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Approve Member</span>', array('class' => 'btn btn-primary btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmApprove', 'data-title' => 'Approve Member', 'data-message' => 'Are you sure you want to approve this member ?')) !!}
                                              {!! Form::close() !!}
                                              {!! Form::open(array('url' => 'members/' . $user->id . '/reject', 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Reject')) !!}
                                                  {!! Form::button('<i class="fa fa-check fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Reject Member</span>', array('class' => 'btn btn-danger btn-sm','type' => 'button', 'style' =>'width: 100%;' ,'data-toggle' => 'modal', 'data-target' => '#confirmApprove', 'data-title' => 'Reject Member', 'data-message' => 'Are you sure you want to reject this member ?')) !!}
                                              {!! Form::close() !!}
                                            @endif
                                            @endrole

                                            @role(['staff'])
                                              <a class="btn btn-sm btn-warning btn-block" href="{{ URL::to('members/' . $user->id . '/assign') }}" data-toggle="tooltip" title="Assign Course">
                                                  <i class="fa fa-share fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Assign</span><span class="hidden-xs hidden-sm hidden-md"> Course</span>
                                              </a>
                                            @endrole
                                          </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')
    @include('modals.modal-approve')

@endsection

@section('footer_scripts')

    @if (count($users) > 1)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.approve-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
@endsection
