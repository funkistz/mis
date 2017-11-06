@if(isset($modal_button))
<!-- Button trigger modal -->
<button type="button" class="btn btn-{{ $button_type or 'default' }} text-capitalize btn-addon" data-toggle="modal" data-target="#{{ $modal_id or 'modal' }}" data-backdrop="{{ $modal_backdrop or 'true' }}">
  @if(isset($icon))
  <i class="fa fa-{{ $icon or null }}"></i>
  @endif
  {{ $modal_button or null }}
</button>
@endif

<!-- Modal -->
<div class="modal fade" id="{{ $modal_id or 'modal' }}" role="dialog" >
  <div class="modal-dialog modal-{{ $modal_size or 'md' }}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-capitalize" >{{ $modal_title or null }}</h4>
      </div>

      @if(isset($form_action))
      <form class="form-horizontal" action="{{ url($form_action) }}" method="post">
      @endif

      <div class="modal-body">
        {{ $modal_content or null }}
      </div>
      @if(isset($modal_footer) || isset($form_action))
      <div class="modal-footer">
        {{ $modal_footer or null }}

        @if(isset($form_action))
        <button type="submit" class="btn btn-success">{{ $form_submit or 'Save' }}</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
