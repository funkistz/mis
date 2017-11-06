<div class="panel panel-default">
  <div class="panel-heading font-bold text-capitalize wrapper">
    <h4 class="m-t-xs pull-left">
      {{ $panel_title or null }}
    </h4>
    <span class="pull-right">
      {{ $panel_action or null }}
    </span>
    <div class="clearfix"></div>
  </div>

  {{ $panel_table or null }}

  @if(isset($panel_content))
  <div class="panel-body">
    {{ $panel_content or null }}
  </div>
  @endif


</div>
