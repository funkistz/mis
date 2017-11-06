<button class="btn m-b-xs btn-{{ $button_type or 'default' }} text-capitalize"
type="button" data-toggle="collapse" data-target="#{{ $collapse_id or 'collapse' }}" aria-expanded="false">
  {{ $collapse_button or null }}
</button>
<div class="collapse" id="{{ $collapse_id or 'collapse' }}">
  <div class="well">
    {{ $collapse_content or null }}
  </div>
</div>
