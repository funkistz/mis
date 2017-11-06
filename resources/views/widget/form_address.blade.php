@if( isset($index_copy) )
<div class="form-group">
  <label class="col-md-{{ $label_size or '4' }} control-label"></label>
  <div class="col-md-{{ $size or '8' }}">
    <div class="checkbox">
      <label class="i-checks">
        <input type="checkbox" data-toggle="copy-address-{{ $index_copy }}"><i></i>Same as above
      </label>
    </div>
  </div>
</div>
@endif

@if( !empty($address->id) )
<input type="hidden" value="{{ $address->id }}" name="address[{{ $index }}][id]">
@endif
<div class="form-group {{ !empty($required)? 'required':'' }}">
  <label class="col-md-{{ $label_size or '4' }} control-label">Address Line 1</label>
  <div class="col-md-{{ $size or '8' }}">
    <input name="address[{{ $index }}][line_1]" class="form-control" placeholder=""
    value="{{ $address->line_1 or old('address[' . $index . '][line_1]') }}">
  </div>
</div>

<div class="form-group">
  <label class="col-md-{{ $label_size or '4' }} control-label">Address Line 2</label>
  <div class="col-md-{{ $size or '8' }}">
    <input name="address[{{ $index }}][line_2]" class="form-control" placeholder=""
    value="{{ $address->line_2 or old('address[' . $index . '][line_2]') }}">
  </div>
</div>

<div class="form-group {{ !empty($required)? 'required':'' }}">
  <label class="col-md-{{ $label_size or '4' }} control-label">City</label>
  <div class="col-md-{{ $size or '8' }}">
    <input name="address[{{ $index }}][city]" class="form-control" placeholder=""
    value="{{ $address->city or old('address[' . $index . '][city]') }}">
  </div>
</div>

<div class="form-group {{ !empty($required)? 'required':'' }}">
  <label class="col-md-{{ $label_size or '4' }} control-label">Country</label>
  <div class="col-md-{{ $size or '8' }}">
    {!! Form::dropdown('address['.$index.'][country_id]', $country, !empty($address->country_id)? $address->country_id : old('address[' . $index . '][country_id]') ,'class="select2-form"') !!}
  </div>
</div>

<div class="form-group {{ !empty($required)? 'required':'' }}">
  <label class="col-md-{{ $label_size or '4' }} control-label">State</label>
  <div class="col-md-{{ $size or '8' }}">
    {!! Form::dropdown('address['.$index.'][state_id]', [],
    !empty($address->state_id)? $address->state : old('address[' . $index . '][state_id]') ,'class="select2-form select-state"') !!}
  </div>
</div>

<div class="form-group {{ !empty($required)? 'required':'' }}">
  <label class="col-md-{{ $label_size or '4' }} control-label">Postcode</label>
  <div class="col-md-{{ $size or '8' }}">
    <input name="address[{{ $index }}][postcode]" type="number" class="form-control" placeholder=""
    value="{{ $address->postcode or old('address[' . $index . '][postcode]') }}">
  </div>
</div>

<?php $state_select = @$address->state_id; ?>
<script>
$( document ).ready(function() {

@if( !empty($state_select) )
$state_id_{{$index}} = '{{ $state_select }}';
@else
$state_id_{{$index}} = '';
@endif

function changeState(){
      var country_id = $('[name="address[{{ $index }}][country_id]"]').val();
      $('[name="address[{{ $index }}][state_id]"]').empty();

      if( country_id != '' )
      $.ajax({
              type: 'GET',
              dataType: 'json',
              url: '{{ url("country_state/states") . "/" }}' + country_id,
              data: {
                  param: country_id
              },
              success: function (data) {
                var select_data_{{$index}} = [];

                $.each(data, function(i, object) {
                      select_data_{{$index}}.push({id:i, text:object});
                });

                $('[name="address[{{ $index }}][state_id]"]').select2({ data: select_data_{{$index}} });
                $('[name="address[{{ $index }}][state_id]"]').val($state_id_{{$index}}).trigger('change');
              }
      });
}

changeState();

$('[name="{{ 'address['.$index.'][country_id]' }}"]').on('change', function(){

      changeState()
});

@if( isset($index_copy) )
$('[data-toggle="copy-address-{{ $index_copy }}"]').on('change', function(e){

    if ($(this).is(":checked"))
    {
      var address_{{ $index }} = [
        $('input[name="address[{{ $index_copy }}][line_1]"]').val(),
        $('input[name="address[{{ $index_copy }}][line_2]"]').val(),
        $('input[name="address[{{ $index_copy }}][postcode]"]').val(),
        $('input[name="address[{{ $index_copy }}][city]"]').val(),
        $('input[name="address[{{ $index_copy }}][state]"]').val(),
        $('[name="address[{{ $index_copy }}][country_id]"]').val()
      ];

      $('input[name="address[{{ $index }}][line_1]"]').val( address_{{ $index }}[0] ),
      $('input[name="address[{{ $index }}][line_2]"]').val( address_{{ $index }}[1] );
      $('input[name="address[{{ $index }}][postcode]"]').val( address_{{ $index }}[2] );
      $('input[name="address[{{ $index }}][city]"]').val( address_{{ $index }}[3] );
      $('input[name="address[{{ $index }}][state]"]').val( address_{{ $index }}[4] );
      $('[name="address[{{ $index }}][country_id]"]').select2("val", address_{{ $index }}[5]);

    }else{
      $('input[name="address[{{ $index }}][line_1]"]').val(function() {
        return this.defaultValue;
      }),
      $('input[name="address[{{ $index }}][line_2]"]').val(function() {
        return this.defaultValue;
      });
      $('input[name="address[{{ $index }}][postcode]"]').val(function() {
        return this.defaultValue;
      });
      $('input[name="address[{{ $index }}][city]"]').val(function() {
        return this.defaultValue;
      });
      $('input[name="address[{{ $index }}][state]"]').val(function() {
        return this.defaultValue;
      });
      $('[name="address[{{ $index }}][country_id]"]').val(function() {
        return this.defaultValue;
      }).trigger('change');
    }

});
@endif

});

</script>
