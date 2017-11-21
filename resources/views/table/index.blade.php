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

          <div class="col-md-12 margin-bottom-lg">
            <div id="myCarousel" class="carousel slide card-2" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <div class="item active">
                  <img src="{{ asset('images/banner.jpg') }}" alt="isispa">
                </div>
              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
          </div>


          <div class="col-md-12" id="barchart">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4>Sispa's Member</h4>
                </div>
                <div class="panel-body">
                  <div class="table-responsive users-table">
                      <table class="table table-striped table-condensed data-table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Name</th>
                                  <th>Gender</th>
                                  <th>Race</th>
                                  <th>DOB</th>
                                  <th>POB</th>
                                  <th>Nric</th>
                                  <th>Phone</th>
                                  <th>Education Skill</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($users as $user)
                              <tr>
                                  <td>{{ $user->id }}</td>
                                  <td>{{ $user->name }}</td>
                                  <td>{{ $user->userable->gender() }}</td>
                                  <td>{{ $user->userable->race->name }}</td>
                                  <td>{{ $user->userable->date_of_birth->format('d/m/Y') }}</td>
                                  <td>{{ $user->userable->place_of_birth }}</td>
                                  <td>{{ $user->userable->nric }}</td>
                                  <td>{{ $user->userable->phone_1 }}</td>
                                  <td></td>
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


@endsection

@section('footer_scripts')

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
@endsection
