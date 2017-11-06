<div class="form-group required">
  <label class="col-md-2 control-label">Relatioship</label>
  <div class="col-md-4">
    {!! Form::dropdown('contact['.$index.'][relationship_id]', $relationship,
    (isset($contact->relationship_id))? $contact->relationship_id : old('relationship_id') ) !!}
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">Name</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][name]" value="{{ $contact->first_name or old('first_name') }}" required>
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">ID Type</label>
  <div class="col-md-4">
    {!! Form::dropdown('contact['.$index.'][identification_type_id]', $identification_type,
    (isset($contact->identification_type_id))? $contact->identification_type_id : old('identification_type_id') ) !!}
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">ID no</label>
  <div class="col-md-4">
    <input type="text" class="form-control" placeholder="e.g: 901021645632" name="contact[{{ $index }}][id_no]" value="{{ $contact->id_no or old('id_no') }}" required>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Race</label>
  <div class="col-md-4">
    {!! Form::dropdown('contact['.$index.'][race_id]', $race,
    (isset($contact->race_id))? $contact->race_id : old('race_id') ) !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label"></label>
  <div class="col-md-4">
    <div class="checkbox">
      <label class="i-checks">
        <input type="checkbox" data-toggle="copy-address"><i></i>Same as above
      </label>
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Address Line 1</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][line_1]"
    value="{{ !empty($contact)? $contact->address->where('type', 1)->first()->line_1 : old('line_1') }}" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Address Line 2</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][line_2]"
    value="{{ !empty($contact)? $contact->address->where('type', 1)->first()->line_2 : old('line_2') }}" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Postcode</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][postcode]"
    value="{{ !empty($contact)? $contact->address->where('type', 1)->first()->postcode : old('postcode') }}" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">City</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][city]"
    value="{{ !empty($contact)? $contact->address->where('type', 1)->first()->city : old('city') }}" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">State</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][state]"
    value="{{ !empty($contact)? $contact->address->where('type', 1)->first()->state : old('state') }}" >
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Country</label>
  <div class="col-md-4">
    {!! Form::dropdown('contact['.$index.'][country_id]', $country, !empty($contact)? $contact->address->where('type', 1)->first()->country_id : old('country_id') ) !!}
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">Occupation</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][occupation]" value="{{ $contact->occupation or old('occupation') }}" required>
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">Phone</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][phone]" value="{{ $contact->phone or old('phone') }}" required>
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">Secondary Phone</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][phone_2]" value="{{ $contact->phone_2 or old('phone_2') }}" required>
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">Email</label>
  <div class="col-md-4">
    <input type="text" class="form-control" name="contact[{{ $index }}][email]" value="{{ $contact->email or old('email') }}" required>
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">Annual Income</label>
  <div class="col-md-4">
    <input type="number" class="form-control" name="contact[{{ $index }}][income]" value="{{ $contact->income or old('income') }}" required>
  </div>
</div>

<div class="form-group required">
  <label class="col-md-2 control-label">Household Size</label>
  <div class="col-md-4">
    <input type="number" class="form-control" name="contact[{{ $index }}][liability]" value="{{ $contact->liability or old('liability') }}" required>
  </div>
</div>
