<?php

namespace app\Helpers;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Models\ApplicationFormSetting;
use App\Helpers\DateUtils;
use App\Helpers\DataUtils;
use Carbon\Carbon;

class Forms
{
    private static $system_date_format;
    private static $system_week_first_day;

    /**
    * [buttonAdd description]
    * @param  [string] $title      [set button name, default = "add"]
    * @param  ['string'] $url        [set url, if no url keyed in #]
    * @param  array  $additional [example array('class'=>'btn', 'onClick = ""', 'onChange = ""')]
    * @return [type]             [html]
    */
    public static function button($icon, $title, $url, $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-default btn-addon text-capitalize $class' $extra><i class='$icon'></i>".(($title == '') ? msg('lbl_add_new') : $title)."</a>";

        return $html;
    }

    public static function buttonAdd($title, $url, $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-info btn-addon text-capitalize $class' $extra><i class='fa fa-plus'></i>".(($title == '') ? msg('lbl_add_new') : $title)."</a>";

        return $html;
    }

    public static function buttonUpdate($title, $url = '', $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-success btn-addon text-capitalize $class' $extra><i class='fa fa-pencil'></i>".(($title == '') ? msg('lbl_update') : $title)."</a>";

        return $html;
    }

    public static function buttonDelete($title, $url = '', $additional='')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-danger btn-addon text-capitalize sa2_delete $class' $extra>".(($title == '') ? msg('lbl_delete') : $title)."</a>";

        return $html;
    }

    public static function buttonBack($title, $url = '', $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-default btn-addon text-capitalize $class' $extra><i class='fa fa-chevron-left'></i>".(($title == '') ? " ".msg('lbl_back') : " ".$title)."</a>";

        return $html;
    }

    public static function buttonSubmit($title = 'Submit', $url = '', $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<button type='submit' class='btn m-b-xs btn-success btn-addon text-capitalize $class' $extra>".(($title == '') ? msg('lbl_submit') : $title)."</button>";

        return $html;
    }

    public static function buttonSave($title = 'Save', $url = '', $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<button type='submit' class='btn m-b-xs btn-success btn-addon text-capitalize $class' $extra><i class='fa fa-save'></i>".(($title == '') ? msg('lbl_save') : $title)."</button>";

        return $html;
    }

    public static function buttonMore($title, $url, $additional='')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-default btn-addon text-capitalize $class' $extra>".(($title == '') ? msg('lbl_more')." " : $title." ")."<i class='fa fa-plus'></i></a>";

        return $html;
    }

    public static function buttonLink($title, $url, $additional='')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-info btn-addon text-capitalize $class' $extra>".$title."</a>";

        return $html;
    }

    public static function buttonCancel($title, $url, $additional='')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $html = "<a href='$url' class='btn m-b-xs btn-default btn-addon text-capitalize $class' $extra>".(($title == '') ? msg('lbl_cancel'):$title." ")."</a>";

        return $html;
    }

    public static function iconUpdate($url, $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        // $html = "<a href='$url' class='btn m-b-xs fa fa-pencil text-capitalize'></a>";
        $html = "<a href='$url' class='btn m-b-xs btn-success text-capitalize $class' data-tooltip='tooltip' title='" . msg('lbl_update') . "' $extra><i class='fa fa-pencil'></i></a>";

        return $html;
    }

    public static function iconDelete($url, $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        // $html = "<a href='$url' class='btn m-b-xs fa fa-trash-o text-capitalize'></a>";
        $html = "<a href='$url' class='btn m-b-xs btn-danger text-capitalize sa2_delete $class' data-tooltip='tooltip' title='" . msg('lbl_delete') . "' $extra><i class='fa fa-trash-o'></i></a>";

        return $html;
    }

    public static function icon($icon, $tooltip, $url, $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        // $html = "<a href='$url' class='btn m-b-xs fa fa-trash-o text-capitalize'></a>";
        $html = "<a href='$url' class='btn m-b-xs btn-default text-capitalize $class' title='$tooltip' data-tooltip='tooltip' $extra><i class='$icon'></i></a>";

        return $html;
    }

    public static function link($url = '#', $name = '', $tooltip = '', $additional = '')
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        // $html = "<a href='$url' class='btn m-b-xs fa fa-trash-o text-capitalize'></a>";
        $html = "<a href='$url' class='text-capitalize $class' title='$tooltip' data-tooltip='tooltip' $extra>$name</a>";

        return $html;
    }

    public static function checkBoxStatus($url, $value, $additional = '', $check = null)
    {
        $url = url($url);
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $checked = (!empty($value)) ? 'checked' : '' ;

        if (empty($check)) {
            $html = "<input $checked type='checkbox' data-action='$url' class='form-control make-switch switch-update $class' data-size='mini' data-on-text='" . msg("lbl_active") . "' data-off-text='" . msg("lbl_inactive") . "' data-success-msg='" . msg("msg_success_update") . "' data-error-msg='" . msg("msg_failed_update") . "' $extra/> ";
        } else {
            $html = "<input $checked type='checkbox' data-action='$url' class='form-control make-switch switch-update $class' data-size='mini' data-on-text='" . $check[0] . "' data-off-text='" . $check[1] . "' data-success-msg='" . msg("msg_success_update") . "' data-error-msg='" . msg("msg_failed_update") . "' $extra/> ";
        }

        return $html;
    }

    /**
     * [dateTime description]
     * @param  string $name       [description]
     * @param  string $value      [description]
     * @param  string $additional [description]
     * @param  array  $param      [
     * @param  integer $showtime     [0-3] 0 = datetime, 1 = datehour, 2 = date
     * @param  integer $disableprev    [1 = prev date allow, 0 = prev date not allow]
     * @param  integer $showmeridian [1 = will show AM/PM, 0 = will hide]
     * @param  integer $minutestep   [how many minutes for a step, if 5 minutes this minutes will be 5,10,15 and so on]
     * @param  string  $format       [default format is dd-mm-yyyy|hh:ii]
     * ]
     * @return [type]             [description]
     */
    public static function dateTime($name = 'date', $value = '', $additional = '', $param = [])
    {
        // $showtime = 0, $format = "", $disableprev = 1, $showmeridian = 1, $minutestep = 10
        $startview = 2;
        $minview = 0;
        if (!empty($param['showtime'])) {
            if ($param['showtime'] == 3) {
                $startview = 3;
                $minview = 3;
            } elseif ($param['showtime'] == 2) {
                $startview = 2;
                $minview = 2;
            } elseif ($param['showtime'] == 1) {
                $startview = 1;
                $minview = 0;
            }
        }
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];
        $date = date('Y-m-d');
        if (!empty($param['dayallow'])) {
            if (is_array($param['dayallow'])) {
                $startdate = date('Y-m-d', strtotime('-'.$param['dayallow']['startdate'].' day'));
                $enddate = date('Y-m-d', strtotime('+'.$param['dayallow']['enddate'].' day'));
            } else {
                $startdate = date('Y-m-d', strtotime('-'.$param['dayallow'].' day'));
                $enddate = date('Y-m-d', strtotime('+'.$param['dayallow'].' day'));
            }
        } else {
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d');
        }
        $data = array(
            'id' => rand(0, 50),
            'startview' => $startview,
            'minview' => $minview,
            'name' => $name,
            'value' => (!empty($value)) ? $value : '',
            'class' => $class,
            'extra' => $extra,
            'showtime' => (empty($param['showtime'])) ? 0 : $param['showtime'],
            'format' => (empty($param['format'])) ? "dd-mm-yyyy hh:ii" : $param['format'],
            'disableprev' => (empty($param['disableprev'])) ? 0 : $startdate,
            'disablefuture' => (empty($param['disablefuture'])) ? 0 : $enddate,
            'showmeridian' => (empty($param['showmeridian'])) ? false : true,
            'minutestep' => (empty($param['minutestep'])) ? 5 : $param['minutestep'],
        );
        return view('widget.form_date')->with($data)->render();
    }

    public static function panelAction($title, $url)
    {
        $url = url($url);
        $html = "<a href='$url' class='btn btn-xs btn-dark text-capitalize'>$title</a>";

        return $html;
    }

    /**
    * [dropdown description]
    * @param  string $name  [dropdown name]
    * @param  array  $option [dropdown option]
    * @param  string $value [dropdown value]
    * @return array  $additional [dropdown additional]
    */
    public static function dropdown($name = 'dropdown', $option, $value = ' ', $additional = '')
    {
        $classmsg = "form-control";
        $additional = Forms::additional($additional, $classmsg);

        // if (is_array($option)){
        //     if ($value != '' &&  !array_key_exists($value, $option))
        //     {
        //         $option[$value] = '*data is not available (use this if not intend to change)';
        //     }
        // }
        // else{
        //     if ($value != '' &&  !array_key_exists($value, $option->pluck('id')->toArray()))
        //     {
        //         $option_object = (object) array('id' => $value, 'name' => '*data is not available (use this if not intend to change)');
        //         $option->push($option_object);
        //     }
        // }

        $data = array(
            'name' => $name,
            'option' => $option,
            'value' => (!empty($value)) ? array($value) : $value,
            'extra' => $additional['extra'],
            'class' => $additional['class'],
            'type' => '',
            'select2' => 'select2-filter'
        );


        return view('widget.form_dropdown')->with($data)->render();
    }

    /**
    * [multi_dropdown description]
    * @param  string $name  [dropdown name]
    * @param  array  $option [dropdown option]
    * @param  array  $value [dropdown value]
    * @return array  $additional [dropdown additional]
    */
    public static function multiDropdown($name = 'dropdown', $option = array(), $value = array(), $additional = '')
    {
        $classmsg = "form-control";
        $additional = Forms::additional($additional, $classmsg);
        $data = array(
            'name' => $name,
            'option' => $option,
            'value' => (!empty($value) && !is_array($value)) ? array($value) : $value,
            'extra' => $additional['extra'],
            'class' => $additional['class'],
            'type' => 'multiple',
            'select2' => 'select2-filter'
        );

        return view('widget.form_dropdown')->with($data);
    }

    /**
    * [multi_dropdown description]
    * @param  string $name  [dropdown name]
    * @param  array  $option [dropdown option]
    * @param  array  $value [dropdown value]
    * @return array  $additional [dropdown additional]
    */
    public static function multiSelectDropdown($name = 'dropdown', $option = array(), $value = array(), $additional = '')
    {
        $classmsg = "form-control";
        $additional = Forms::additional($additional, $classmsg);
        $data = array(
            'name' => $name,
            'option' => $option,
            'value' => (!empty($value) && !is_array($value)) ? array($value) : $value,
            'extra' => $additional['extra'],
            'class' => $additional['class'],
            'type' => 'multiple',
            'select2' => ''
        );

        return view('widget.form_dropdown')->with($data);
    }

    public static function studentDropdown($name = 'dropdown', $value = null, $additional = '')
    {
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];

        if (empty($value)) {
            $html = "<select name='$name' class='select2 select2-student-search $class' data-ajax--url='" . url('student/find') . "' $extra ></select>";
        } else {
            $html = "<select name='$name' class='select2 select2-student-search $class' data-ajax--url='" . url('student/find') . "' $extra ><option value='" . $value->id . "' selected='selected'>" . $value->name . "</option></select>";
        }
        return $html;
    }

    public static function countryDropdown($name = 'dropdown', $value = null, $additional = '')
    {
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];

        if (empty($value)) {
            $html = "<select name='$name' class='select2 select2-country-search $class' data-ajax--url='" . url('country_state/countries') . "' $extra ></select>";
        } else {
            $html = "<select name='$name' class='select2 select2-country-search $class' data-ajax--url='" . url('country_state/countries') . "' $extra ><option value='" . $value->id . "' selected='selected'>" . $value->name . "</option></select>";
        }
        return $html;
    }

    /**
     * Input date using jquery Daterangepicker package
     *
     * @param  string   $name       Input <i>name<i/> tag
     * @param  mixed    $value      Input <i>value<i/> tag.
     *                              <br/>For single date : <b>'22/09/2017'</b> or <b>['22/09/2017']</b>
     *                              <br/>For date range : <b>['22/09/2017', '25/09/2017']</b>
     * @param  array    $option     Daterangepicker option <i>singleDatePicker<i/>, <i>showDropdowns<i/>, etc...
     *                              <br/>Example of usage <b>['showDropdowns' => true, 'format' => 'DD-MM-YYYY']</b>
     * @param  array    $additional Other HTML tags like <i>class<i/>, <i>id<i/>, etc...
     *                              <br/>Example of usage <b>['class' => 'more add', 'id' => 'date']</b>
     * @return string               HTML form of daterangepicker generated
     */
    public static function inputDate($name = 'date', $value = [], $option = [], $additional = [])
    {
        $additional = Forms::additional($additional);
        $class = $additional['class'];
        $extra = $additional['extra'];

        // Initialize value
        if (empty(self::$system_date_format)) {
            self::$system_date_format = GeneralSetting::where('field', 'system_date_format')->select(['value'])->first()->value;
        }

        if (empty(self::$system_week_first_day)) {
            self::$system_week_first_day = GeneralSetting::where('field', 'system_week_first_day')->select(['value'])->first()->value;
        }

        $date_format = (!empty(self::$system_date_format)) ? self::$system_date_format : 'd-m-Y';

        if (!empty($value)) {
            if (is_array($value)) {
                $startDate = (!empty($value[0])) ? DateUtils::format_date($value[0], $date_format) : '';

                if (count($value) > 1) {
                    $endDate = (!empty($value[1])) ? DateUtils::format_date($value[1], $date_format) : '';
                }
            } else {
                $startDate = (!empty($value)) ? DateUtils::format_date($value, $date_format) : '';
            }
        }

        // Initialize daterangepicker option
        $showDropdowns = (!empty($option) && array_key_exists('showDropdowns', $option) && !empty($option['showDropdowns'])) ? json_encode($option['showDropdowns']) : 'true';
        $singleDatePicker = (!empty($option) && array_key_exists('singleDatePicker', $option) && !empty($option['singleDatePicker'])) ? json_encode($option['singleDatePicker']) : 'false';
        $autoApply = (!empty($option) && array_key_exists('autoApply', $option) && !empty($option['autoApply'])) ? json_encode($option['autoApply']) : 'true';
        $linkedCalendars = (!empty($option) && array_key_exists('linkedCalendars', $option) && !empty($option['linkedCalendars'])) ? json_encode($option['linkedCalendars']) : 'false';
        $autoUpdateInput = (!empty($option) && array_key_exists('autoUpdateInput', $option) && !empty($option['autoUpdateInput'])) ? json_encode($option['autoUpdateInput']) : 'true';
        $format = (!empty($option) && array_key_exists('format', $option) && !empty($option['format'])) ? $option['format'] : DateUtils::date_to_momentjs($date_format);
        $firstDay = (!empty($option) && array_key_exists('firstDay', $option) && !empty($option['firstDay'])) ? $option['firstDay'] : self::$system_week_first_day - 1;
        $minDate = (!empty($option) && array_key_exists('minDate', $option) && !empty($option['minDate'])) ? 'minDate: \'' . DateUtils::format_date($option['minDate'], 'm/d/Y') . '\',' : '';
        $maxDate = (!empty($option) && array_key_exists('maxDate', $option) && !empty($option['maxDate'])) ? 'maxDate: \'' . DateUtils::format_date($option['maxDate'], 'm/d/Y') . '\',' : '';
        $startDate = (!empty($startDate)) ? "startDate: '$startDate'," : '';
        $endDate = (!empty($endDate)) ? "endDate: '$endDate'," : '';

        $html = "<div class='input-group'>
                    <input name='$name' class='form-control dr-picker $class' $extra ui-jq='daterangepicker'
                    ui-options=\"{
                        showDropdowns: $showDropdowns,
                        singleDatePicker: $singleDatePicker,
                        autoApply: $autoApply,
                        linkedCalendars: $linkedCalendars,
                        autoUpdateInput: $autoUpdateInput,
                        locale: {
                            format: '$format',
                            separator: ' - ',
                            applyLabel: '" . msg('lbl_apply') . "',
                            cancelLabel: '" . msg('lbl_cancel') . "',
                            fromLabel: '" . msg('lbl_from') . "',
                            toLabel: '" . msg('lbl_to') . "',
                            customRangeLabel: '" . msg('lbl_custom_range') . "',
                            daysOfWeek: [
                            	'" . implode('\',\'', DataUtils::days('D')) . "'
                            ],
                            monthNames: [
                            	'" . implode('\',\'', DataUtils::months()) . "'
                            ],
                            firstDay: $firstDay
                        },
                        $minDate
                        $maxDate
                        $startDate
                        $endDate
                    }, function (start, end, label) {
                        $('input[name=$name]').val(start.format('$format') + ' - ' + end.format('$format'));
                    }\"/>
                    <label class='input-group-addon' onClick=\"$(this).parent().find('input').val('');\" style=\"cursor: pointer;\">
                        <i class='fa fa-times'></i>
                    </label>
                    <label class='input-group-addon' for='$name' style=\"cursor: pointer;\">
                        <i class='glyphicon glyphicon-calendar'></i>
                    </label>
                </div>";

        return $html;
    }

    public static function required($form_id, $field)
    {
        $setting = ApplicationFormSetting::where([['form_id', $form_id], ['column', $field] ])->first();
        if (!empty($setting->mandatory)) {
            if ($setting->type == 2) {
                return $setting->mandatory;
            }
            return $setting->mandatoryName;
        } else {
            return false;
        }
    }

    public static function show($form_id, $field)
    {
        $setting = ApplicationFormSetting::where([ ['form_id', $form_id], ['column', $field] ])->first();
        if (!empty($setting->show)) {
            if ($setting->type == 2) {
                return $setting->show;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function settingValue($form_id, $field)
    {
        return ApplicationFormSetting::where([['form_id', $form_id], ['column', $field] ])->first()->value;
    }

    public static function additional($additional, $classmsg='')
    {
        $extra = "";

        if (is_array($additional)) {
            foreach ($additional as $id => $key) {
                if (preg_match('/class/', $id)) {
                    $classmsg .= " $key";
                } else {
                    $extra .= $id."='".$key."' ";
                    // $extra = str_replace("'","",$extra);
                }
            }
        } else {
            $classexp = array();
            $addexp = explode('" ', $additional);
            foreach ($addexp as $id => $key) {
                if (preg_match('/class/', $key)) {
                    $classexp = explode('"', $key);
                    if (!empty($classexp)) {
                        unset($classexp[0]);
                        foreach ($classexp as $id => $key) {
                            $classmsg .= " $key ";
                        }
                    }
                } else {
                    $exp = explode('"', $key);
                    foreach ($exp as $id => $key) {
                        $extra .= " $key ";
                    }
                }
            }
        }

        return array('extra'=>$extra, 'class' => $classmsg);
    }
}
