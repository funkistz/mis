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

          @include('partials.carousell')

          <!-- change based on role  -->
          @role(['admin'])
          @include('partials.admin-dashboard-box')
          @endrole

          @role(['officer'])
          @include('partials.officer-dashboard-box')
          @endrole

          @role(['coofficer'])
          @include('partials.coofficer-dashboard-box')
          @endrole

          @role(['staff'])
          @include('partials.staff-dashboard-box')
          @endrole

          <!-- below box  -->

          @role(['admin'])
          @include('partials.task-dashboard')
          @endrole

          @role(['staff'])
          @include('partials.calendar-dashboard')
          @endrole

          @role(['officer', 'coofficer'])
          @include('partials.news-dashboard', ['col' => 12])
          @endrole

          @role(['admin'])
          @include('partials.news-dashboard')
          @endrole

          @role(['staff'])
          @include('partials.news-dashboard',['add_news' => true])
          @endrole

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

    $('[name="year"]').on('change', function(){
      $('#form_filter_year').submit();
    });

    </script>

    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    {{--
        @include('scripts.tooltips')
    --}}
@endsection
