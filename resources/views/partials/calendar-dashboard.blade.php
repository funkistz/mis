

<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading">Calendar</div>
    <div class="panel-body">
        <div id='calendar'></div>
    </div>
  </div>
</div>

@push('scripts')
<script>

$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
      header: {
				left: 'prev',
				center: 'title',
				right: 'next'
			},
			defaultView: 'month',
			editable: true,
      events: [
        @foreach( App\Models\CourseClass::all() as $course )
				{
					title: '{{ $course->name }}',
          start: '{{ $course->date }}',
					id: '{{ $course->id }}'
				},
        @endforeach
			],
      eventRender: function(event, element) {
          $(element).tooltip({title: event.title});
      },
      eventClick: function(calEvent, jsEvent, view) {

        window.location.href = "{{ url('courses') }}/" + calEvent.id;

    }
    })

});

</script>
@endpush
