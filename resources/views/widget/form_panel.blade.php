<div class="panel panel-default">
  <div class="panel-heading font-bold text-capitalize"><h4>{{ $form_action or 'set title here' }}</h4></div>
  <div class="panel-body">

    <form class="form-horizontal" action="{{ url($form_action) }}">
      {{ $form_content or 'form content here' }}

      <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
          <button type="submit" class="btn btn-sm btn-info">{{ $form_submit or 'Submit' }}</button>
        </div>
      </div>
    </form>

  </div>
</div>
