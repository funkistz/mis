<form action="{{ $search_action or null }}">
    <div class="input-group">
      {!! $search_basic !!}
      <span class="input-group-addon rounded"><i class="fa fa-search pull-right"></i></span>
    </div>
    <button class="btn btn-default btn-block btn-rounded text-left" data-toggle="collapse" href="#advancesearch">
      <i class="fa fa-search pull-right">
      </i> <span class="pull-left">Search</span>
    </button>
    <div class="clearfix">
      <div class="col-md-2 no-padder">
        <a class="btn btn-default btn-sm collapsed m-t-xs @if(!isset($add_button)) m-b @endif" data-toggle="collapse" href="#advancesearch">
          More filter options
        </a>
      </div>
      <div class="collapse col-md-10 no-padder" id="advancesearch">
        <div class="panel">
          <div class="panel-body wrapper-lg padder">
            {!! $search_advanced !!}
          </div>
        </div>
      </div>
    </div>
</form>

@if(isset($add_button))
<div class="m-b-xs m-t-xs text-right clearfix">
{!! $add_button or null !!}
</div>
@endif
