

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
        // put your options and callbacks here
    })

});

</script>
@endpush
