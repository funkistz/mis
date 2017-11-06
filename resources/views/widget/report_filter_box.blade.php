<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="text-muted font-thin">{!! $form_title or null!!}</h4>
    </div>
    <div class="panel-body">
        <form class="bs-example form-horizontal report-filter-box" action="{{ $form_action or null }}" method="post" target="_blank" id="{{ $form_id or null }}">
            {{ csrf_field() }}

            <input type="hidden" name="permission_name" value="{!! \Route::currentRouteName() !!}">

            {!! $form_filter or null!!}

            @if(!empty($field_option))
            <div class="form-group required">
                <label class="col-lg-2 control-label">{{ msg('lbl_field_to_appear') }}</label>
                <div class="col-lg-8">
                    {!! Form::multiSelectDropdown('field_2_appear[]', $field_option, @$field_default, array('id' => 'field_2_appear', 'class' => 'multiSelect', 'data-placeholder-left' => 'Filter Option...', 'data-placeholder-right' => 'Filter Selection...')) !!}
                </div>
            </div>
            @endif

            <div class="line line-dashed b-b line-lg"></div>

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-8">
                    {!! Form::buttonSubmit('<i class="fa fa-gavel"></i>' . msg('lbl_generate')) !!}
                    {!! Form::buttonLink('<i class="fa fa-save"></i>' . msg('lbl_save_form', ['name' => msg('lbl_filter')]), '#', ['id' => 'report-filter', 'data-toggle' => 'modal', 'data-target' => '#modal_global_form', 'data-title' => msg('lbl_save_form', ['name' => msg('lbl_filter')]), 'data-url' => route('report.create'), 'data-action' => route('report.store'), 'data-param' => '']) !!}
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $().ready(function () {
            initializeMultiSelect('.multiSelect');

            @if(!empty($field_default))
                update_data_param();
            @endif
        });

        $('#{{ $form_id }} input, #{{ $form_id }} select').change(function (){
            update_data_param();
        });

        function update_data_param() {
            var param = populate_param();

            if (param.length > 0) {
                $('#report-filter').attr('data-param', param);
            }
        }

        function populate_param() {
            var param = "{";

            $('#{{ $form_id }} input, #{{ $form_id }} select').each(function () {
                var value = $(this).val();
                var name = $(this).prop('name');

                if (value) {
                    if (Array.isArray(value)) {
                        param += '"' + name.replace(/[\[(.)?\]]/gi, "") + '":{';

                        for (var index = 0, len = value.length; index < len; index++) {
                            param += '"' + index + '":"' + value[index] + '"';

                            if (index + 1 < len) {
                                param += ',';
                            }
                        }

                        param += '},';
                    } else {
                        param += '"' + name.replace(/[\[(.)?\]]/gi, "") + '":"' + value + '",';
                    }
                }
            });

            return param.substr(0, param.length - 1) + "}";
        }
    </script>
@endpush
