<div class="col-md-12">
  <div class="btn-group" style="margin-bottom:20px;">
    <a href="#barchart" id="toggle-barchart" type="button" class="btn btn-primary">Bar Chart</a>
    <a href="#linechart" id="toggle-linechart" type="button" class="btn btn-primary">Line Chart</a>
    <a href="#piechart" id="toggle-piechart" type="button" class="btn btn-primary">Pie Chart</a>
  </div>
  <div class="pull-right form-horizontal">
    <form id="form_filter_year" method="get" action="{{ url('dashboard') }}">
      <div class="form-group required">
        <label class="col-md-4 control-label">Year</label>
        <div class="col-md-8">
        {!! Forms::dropdown('year', $year_selection, $year) !!}
        </div>
      </div>
    </form>
  </div>
</div>

  <div class="col-md-12" id="barchart">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Number of activated student registered per month ({{ $year }})</h4>
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
