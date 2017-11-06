<form action="{{ $search_action or null }}" method="post" id="B3-filter-box">
    <div class="panel m-b-xs m-b bg-light lt">

        <div class="panel-body wrapper-sm">
            <div class="input-group" style="width:100%;">
                {!! $search_basic or null !!}
                <span class="input-group-btn" id="button-searchbar">
                    {!! Form::buttonSubmit(msg('lbl_search',['Name' => '']), '', 'href="#bottom-filter-box"') !!}
                </span>
            </div>
            @if( !empty($search_advanced) )
            <div class="clearfix">
                <div class="collapse col-md-12 no-padder" id="advancesearch">
                    <div class="form-horizontal m-t">
                        {!! $search_advanced !!}
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                {!! Form::buttonSubmit(msg('lbl_search',['Name' => '']), '#bottom-filter-box', array('id' => 'button-searchbar2', 'style' => 'display: none;', 'href' =>'#bottom-filter-box')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="btn btn-default btn-sm collapsed @if(!isset($add_button)) m-t-xs @endif" data-toggle="collapse" href="#advancesearch" id="button-advancesearch">
                {{ msg('lbl_more_filter') }}
            </a>
            @endif
        </div>

    </div>
</form>
<div id="bottom-filter-box" ></div>

@if(isset($add_button))
    <div class="m-b-xs m-t-xs text-right clearfix">
        {!! $add_button or null !!}
    </div>
@endif

@push('scripts')
    <script>
        $('#advancesearch').on('show.bs.collapse', function () {
            $('#button-searchbar').hide();
            $('#button-searchbar2').show(100);
            $('#button-advancesearch').html('{{ msg('lbl_less_filter') }}');
        });

        $('#advancesearch').on('hidden.bs.collapse', function () {
            $('#button-searchbar').show(100);
            $('#button-searchbar2').hide();
            $('#button-advancesearch').html('{{ msg('lbl_more_filter') }}');
        });
    </script>
@endpush
