<div id="rootwizard" class="" >
  <div class="wrapper navbar b-b">
    <div class="navbar-inner">
        <ul class="nav nav-pills">
          @php $tab_count = 0; @endphp
          @foreach ($tab_nav as $key => $tab_value)
            @if(!is_numeric($key))
              <li><a href="#tabwizard_{{$tab_count++}}" data-tab-link="{{$key}}" data-toggle="tab" class="text-capitalize">{{$tab_value}}</a></li>
            @else
              <li><a href="#tabwizard_{{$tab_count++}}" data-tab-link="false" data-toggle="tab" class="text-capitalize">{{$tab_value}}</a></li>
            @endif
          @endforeach
        </ul>
    </div>
  </div>
  <div class="panel-body">

    <h4>Complete all the steps</h4>
    <div id="bar" class="progress">

      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
    </div>
    <div class="tab-content">
      @php $tab_count = 0; @endphp
      @foreach ($tab_content as $tab_content)
      @if(!empty($tab_content))
      <div class="tab-pane" id="tabwizard_{{$tab_count++}}">
          @include($tab_content)
      </div>
      @endif
      @endforeach
  </div>
</div>

</div>

@push('scripts')
<script src="{{ asset('js/jquery.bootstrap.wizard.min.js')}}" ></script>
<script>
var form_wizard_changes = false;
$(document).ready(function() {

  $('#rootwizard').bootstrapWizard({onTabClick: function(tab, navigation, currentIndex, clickedIndex) {

    if( $("#rootwizard a[href='#tabwizard_" + clickedIndex +"']").data('tab-link') != false){
      window.location.href = $("#rootwizard a[href='#tabwizard_" + clickedIndex +"']").data('tab-link');
      return false;
    }

    @if( !empty($tab_active) )
    if( $.inArray(clickedIndex, {!! json_encode($tab_active) !!}) == -1 ){
      return false;
    }else{

      history.pushState({}, "", addQSParm("form", clickedIndex ));

      if( form_wizard_changes ){

        swal({
          title: 'Are you sure want to proceed?',
          text: "Your changes will not be save!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then(function () {

          $("#tabwizard_" + currentIndex + " form")[0].reset();
          form_wizard_changes = false;
          window.location.reload();

          return false;

        }, function (dismiss) {
          if (dismiss === 'cancel') {
            $('#rootwizard a[href="#tabwizard_' + currentIndex + '"]').tab('show');
            history.pushState({}, "", addQSParm("form", currentIndex ));
          }
        })

      }


    }
    @endif
  },onNext: function(tab, navigation, index) {

      if( $("#rootwizard a[href='#tabwizard_" + index +"']").data('tab-link') != false){
        window.location.href = $("#rootwizard a[href='#tabwizard_" + index +"']").data('tab-link');
        return false;
      }

      history.pushState({}, "", addQSParm("form", index ));

  },onPrevious: function(tab, navigation, index) {

      if( $("#rootwizard a[href='#tabwizard_" + index +"']").data('tab-link') != false){
        window.location.href = $("#rootwizard a[href='#tabwizard_" + index +"']").data('tab-link');
        return false;
      }

      history.pushState({}, "", addQSParm("form", index ));

  }, onTabShow: function(tab, navigation, index) {

    var $total = navigation.find('li').length;
    var $current = index+1;
    var $percent = ($current/$total) * 100;
    $('#rootwizard .progress-bar').css({width:$percent+'%'});

  }, 'nextSelector': '.button-next', 'previousSelector': '.button-previous'
});

  @if( isset( $tab_current ) )
  $('#rootwizard a[href="#tabwizard_{{ $tab_current }}"]').tab('show');
  @endif
  if (getUrlParameter('form') != '') {
    var tabwizardcurrent = "#tabwizard_" + getUrlParameter('form');
    $('#rootwizard a[href="'+ tabwizardcurrent +'"]').tab('show');
  }

});
</script>
@endpush
