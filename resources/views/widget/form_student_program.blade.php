@if( !empty($student_program->id) )
<input type="hidden" value="{{ $student_program->id }}" name="student_program[{{ $index }}][id]">
@endif
<div class="form-group">
  <label class="col-md-2 control-label">Campus</label>
  <div class="col-md-4">
    {!! Form::dropdown('student_program['.$index.'][campus_id]', $campus, @$student_program->campus_id ,'class="select2-form" ') !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Program</label>
  <div class="col-md-4">
    {!! Form::dropdown('student_program['.$index.'][program_id]', $program, @$student_program->program_id,'class="select2-form" ') !!}
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Intake</label>
  <div class="col-md-4">
    <p>
      {{ $student_marketing->intake->name }}
    </p>
  </div>
</div>

<div class="form-group">
  <label class="col-md-2 control-label">Study Mode</label>
  <div class="col-md-4">
    {!! Form::dropdown('student_program['.$index.'][study_mode_id]', $study_mode, @$student_program->study_mode_id,'class="select2-form" ') !!}
  </div>
</div>
