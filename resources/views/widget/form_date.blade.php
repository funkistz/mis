<div class="input-group date random{{ $id }}" data-disablefuture="{{ $disablefuture }}" data-date="{{ $value }}" data-startview="{{ $startview }}" data-minview="{{ $minview }}" data-format="{{ $format }}" data-disableprev="{{ $disableprev }}"  data-showmeridian="{{ $showmeridian }}" data-minutestep="{{ $minutestep }}">
    <input type="text" name="{{ $name }}" value = "{{ $value }}" class="form-control {!! $class !!}" {!! $extra !!} readonly>
    <span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>
    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
</div>
@push('scripts')
<script type="text/javascript">
initializedatetimepicker(".input-group.date.random{{ $id }}");
function initializedatetimepicker(selection){
    var startview = $(selection).data('startview');
    var minview = $(selection).data('minview');
    var format = $(selection).data('format');
    var showmeridian = $(selection).data('showmeridian');
    var minutestep = $(selection).data('minutestep');
    var date = $(selection).data('date');
    var startdate = $(selection).data('disableprev');
    var enddate = $(selection).data('disablefuture');
    $(selection).datetimepicker({
        format: format,
        startView: startview,
        minView: minview,
        autoclose: true,
        showMeridian: showmeridian,
        todayBtn: true,
        startDate: startdate,
        endDate: enddate,
        // startDate: "2017-08-22 15:54",
        minuteStep: minutestep
    });
}
</script>
@endpush
