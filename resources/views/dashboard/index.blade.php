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

          <div class="col-md-12">
            <div class="btn-group" style="margin-bottom:20px;">
              <a href="#barchart" id="toggle-barchart" type="button" class="btn btn-primary">Bar Chart</a>
              <a href="#linechart" id="toggle-linechart" type="button" class="btn btn-primary">Line Chart</a>
              <a href="#piechart" id="toggle-piechart" type="button" class="btn btn-primary">Pie Chart</a>
            </div>
          </div>

            <div class="col-md-12" id="barchart">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4>Number of activated student registered per month (2017)</h4>
                  </div>
                  <div class="panel-body">
                    <div id="poll_div"></div>
                    <div id="chart-div"></div>
                    {!! $lava->render('ColumnChart', 'columnchart', 'chart-div') !!}
                  </div>
                </div>
            </div>

            <div class="col-md-12 hide" id="linechart">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4>Number of activated student registered per month (2017)</h4>
                  </div>
                  <div class="panel-body">
                    <div id="poll_div"></div>
                    <div id="chart-div2"></div>
                    {!! $lava->render('AreaChart', 'areachart', 'chart-div2') !!}
                  </div>
                </div>
            </div>

            <div class="col-md-12 hide" id="piechart">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4>Number of activated student registered per month (2017)</h4>
                  </div>
                  <div class="panel-body">
                    <div id="poll_div"></div>
                    <div id="chart-div3"></div>
                    {!! $lava->render('PieChart', 'piechart', 'chart-div3') !!}
                  </div>
                </div>
            </div>

            <div class="col-md-12" id="coursechart">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4>Number of members per course</h4>
                  </div>
                  <div class="panel-body">
                    <div id="poll_div"></div>
                    <div id="chart-div4"></div>
                    {!! $lava->render('ColumnChart', 'coursechart', 'chart-div4') !!}
                  </div>
                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-delete')

@endsection

@section('footer_scripts')

    <script>
    $('#toggle-barchart').click(function(){
      hideAllChart();
      $('#barchart').removeClass('hide');
    })
    $('#toggle-piechart').click(function(){
      hideAllChart();
      $('#piechart').removeClass('hide');
    })
    $('#toggle-linechart').click(function(){
      hideAllChart();
      $('#linechart').removeClass('hide');
    })

    function hideAllChart(){
      $('#barchart').addClass('hide');
      $('#linechart').addClass('hide');
      $('#piechart').addClass('hide');
    }
    </script>

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
@endsection
