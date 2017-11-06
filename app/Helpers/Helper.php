<?php

use App\Repositories\General\GeneralSettingRepository;
use Illuminate\Support\Facades\Storage;
use App\Helpers\DateUtils;
use App\Helpers\MapPlaceHolder;
use Illuminate\Support\Facades\Hash;

/**
* Get system current locale.
* 1. Set to \Illuminate\Support\Facades\Session::has('app_locale') if exist
* 2. Otherwise, set \Illuminate\Support\Facades\Config::get('app.fallback_locale')
*
* @return string
*/
function locale()
{
    $locale = \Illuminate\Support\Facades\Config::get('app.fallback_locale');

    if (\Illuminate\Support\Facades\Session::has('app_locale') AND array_key_exists(\Illuminate\Support\Facades\Session::get('app_locale'), \Illuminate\Support\Facades\Config::get('locales'))) {
        $locale = \Illuminate\Support\Facades\Session::get('app_locale');
    }

    return $locale;
}

/**
* Translate key given into respective label as define in:
* - resources/lang/[locale]/message.php
* - resources/lang/[locale]/organizations/message_[code].php
*
* @param  string $key      Translation key define in <i>/resource/lang/[locale][/organizations]/message[_code].php</i>
* @param  array $param     Value of parameter define in the translation (if requires)
* @param  boolean $plural  Get plural translation <b><i>IF ONLY AND ONLY</i></b> the locale = <b>EN<b>.<br/><b><i>true</i></b> | <b><i>false</i></b> (Default : <b><i>false</i></b>)
* @param  boolean $custom  Get translation <b><i>ONLY</i><b> in <i>/resource/lang/[locale]/organizations/message.php</i>.<br/><b><i>true</i></b> | <b><i>false</i></b> (Default : <b><i>true</i></b>)
* @return string           Return translation message
*/
function msg($key, $param = array(), $plural = false, $custom = true)
{
    $message = $key;
    $locale = locale();
    $code = 'demo';

    if (str_is('message.*', $key)) {
        if ($custom && (\Illuminate\Support\Facades\Lang::has('organizations/' . str_replace('.', "_$code.", $key), $locale))) {
            $message = __('organizations/' . str_replace('.', "_$code.", $key), $param);
        } else {
            $message = __($key, $param);
        }
    } else {
        if ($custom && (\Illuminate\Support\Facades\Lang::has("organizations/message_$code.$key", $locale))) {
            $message = __("organizations/message_$code.$key", $param);
        } else {
            $message = __('message.' . $key, $param);
        }
    }

    // Pluralization
    if (($plural && $locale == 'en') && !empty($message)) {
        $message =  str_plural($message);
    }

    return $message;
}

/**
* Clean string contain special character and space.
* @param  string   $string
* @return string
*/
function clean($string) {
    // Replaces all spaces with hyphens.
    $string = str_replace(' ', '-', $string);

    // Removes special chars.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
}

/**
* Get module icon based-on permission name.
* @param  string   $name
* @return string
*/
function icon($name) {
    // Get module record
    $permission = \App\Models\Permission::where('name', '=', $name)->first();

    return (!empty($permission->module->icon)) ? '<i class="m-r-xs text-muted ' . $permission->module->icon . '"></i>' : '';
}

/**
* Get image.
* @param  string   $path
* @param  string   $size
* @return string
*/
function avatar($path, $size = 88, $name, $shape = 'circle', $attr ='')
{

    if(!empty($path)){
        $image_path = storage_url($path.'_'.$size.'.jpg');
    } else {
        $font_size = (!empty($size)) ? (int)($size * 0.48) : 48;

        $image_path = Laravolt\Avatar\Facade::create($name)
        ->setDimension($size)
        ->setShape($shape)
        ->setFontSize($font_size)
        ->toBase64();
    }

    return '<img src="' . $image_path . '" alt="image not found" class="image-responsive" width="100%" '.$attr.'>';

}

function format_date($date, $format = '')
{
    return DateUtils::format_date($date, $format = '');
}

function sql_date($date, $format = '')
{
    return DateUtils::sql_date($date);
}

/**
 * [general_info description]
 * @param  [string] $field [field name]
 * @return [string]       [field value]
 */
function general_info($field){

    $general_setting = new GeneralSettingRepository(app());
    return $general_setting->findBy('field', $field)->first()->value;
}

/**
 * [organization_info description]
 * @param  [string] $field [field name]
 * @return [string]       [field value]
 */
function organization_info($field){

    $general_setting = new GeneralSettingRepository(app());
    return $general_setting->findBy('field', $field)->first()->value;
}

/**
 * [storage_path description]
 * @param  string $path [description]
 * @return [type]       [description]
 */
function storage_url($path ='')
{
    return Storage::disk('azure')->url($path);
}

function storage_file_path($path ='')
{
    $host = explode('.', @$_SERVER['HTTP_HOST'])[0];

    $path_url = config('b3.'.$path);

    return $host.'/'.$path_url;
}

function form_required($boolean){
    if(!empty($boolean)){
      return 'required';
    }else{
      return null;
    }
}

function map_place_holder($student_id, $template)
{
    return MapPlaceHolder::getPlaceholder($student_id, $template);
}

function generate_hash($token){
    return Hash::make($token);
}

function verify_hash($token, $hashed_token){
    return Hash::check($token, $hashed_token);
}
