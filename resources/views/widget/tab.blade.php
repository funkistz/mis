<div class="tab-container">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    @foreach ($tab_nav as $nav)
        <li class="@if($loop->first) active @endif">
          <a href="#tab_{{$nav}}" role="tab" data-toggle="tab">{{$nav}}</a>
        </li>
    @endforeach

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <p class="m-b ng-scope">Please complete all form first</p>
    <div class="progress-xs progress ng-isolate-scope" value="steps.percent" type="success">
      <div class="progress-bar progress-bar-success" ng-class="type &amp;&amp; 'progress-bar-' + type" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" ng-style="{width: percent + '%'}" aria-valuetext="10%" ng-transclude="" style="width: 10%;"></div>
    </div>

    @php $tabcount = 0; @endphp

      @foreach ($tab_nav as $nav)
      <div role="tabpanel" class="tab-pane form-horizontal @if($loop->first) active @endif" id="tab_{{$nav}}">
        @includeIf($tab_content[$tabcount])
        @php $tabcount++; @endphp
        <div class="text-right">
          @if($loop->first)
          <a class="btn btn-primary tabNext" >Next</a>
          @elseif($loop->last)
          <a class="btn btn-primary tabPrevious" >Previous</a>
          @else
          <a class="btn btn-primary tabNext" >Next</a>
          <a class="btn btn-primary tabPrevious" >Previous</a>
          @endif
        </div>
      </div>
      @endforeach

  </div>

</div>
