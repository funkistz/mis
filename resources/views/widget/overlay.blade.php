<!-- Button trigger modal -->
<button type="button" class="btn m-b-xs btn-{{ $button_type or 'default' }} text-capitalize btn-addon" data-toggle="modal" data-target="#{{ $modal_id or 'modal' }}" data-backdrop="{{ $modal_backdrop or 'true' }}">
  @if(isset($icon))
  <i class="fa fa-{{ $icon or null }}"></i>
  @endif
  {{ $modal_button or null }}
</button>

<style>

  body.modal-open .app-header {
    padding-right: 17px;
  }

  .modal-backdrop {
    background-color: rgba(0, 0, 0, 0.4);
  }

  .modal.modal-overlay .modal-dialog{
		position: fixed;
    right: 0;
		margin: auto;
		height: 100%;
    -webkit-transform: translate3d(0, 0, 0);
  	transform: translate3d(0, 0, 0);
	}

  .modal.modal-overlay .modal-content{
    height: 100%;
    border-radius: 0;
    border: none;
  }

  .modal.modal-overlay .modal-header{
    position: absolute;
    top: 0;
    width: 100%;
    background-color: #fff;
  }

  .modal.modal-overlay .modal-footer{
    position: absolute;
    bottom: 0;
    width: 100%;
    background-color: #fff;
  }

  .modal.modal-overlay .modal-content form{
    height: 100%;
  }

  .modal.modal-overlay .modal-content .modal-body{
    height: 100%;
    padding-top: 80px;
    padding-bottom: 80px;
    overflow-y: scroll;
  }

  .modal.fade:not(.in).modal-overlay .modal-dialog {
  	-webkit-transform: translateX(10%);
  	transform: translateX(10%);
  }

  .modal.modal-overlay .modal-dialog{
    width: 50%;
  }

  @media screen and (max-width: 768px) {
    .modal.modal-overlay .modal-dialog{
      width: 95%;
    }

  }

</style>

<!-- Modal -->
<div class="modal modal-overlay fade" id="{{ $modal_id or 'modal' }}" role="dialog" >
  <div class="modal-dialog modal-{{ $modal_size or 'md' }}" role="document">
    <div class="modal-content">

      @if(isset($form_action))
      <form class="form-horizontal" action="{{ url($form_action) }}">
      @endif

      <div class="modal-body">
        {{ $modal_content or null }}
      </div>

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" >{{ $modal_title or null }}</h4>
      </div>

      @if(isset($modal_footer) || isset($form_action))
      <div class="modal-footer">
        {{ $modal_footer or null }}

        @if(isset($form_action))
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info">{{ $form_submit or 'Submit' }}</button>
        @endif
      </div>
      @endif

      @if(isset($form_action))
      </form>
      @endif

    </div>
  </div>
</div>

@push('scripts')
<script>
$('#{{ $modal_id or 'modal' }}').appendTo("body")
</script>
@endpush
