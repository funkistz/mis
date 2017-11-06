<?php

namespace app\Helpers;

use Illuminate\Http\Request;

class ArrayUtils {

    /**
     * Construct array use for dropdown option from collection
     *
     * @param  Illuminate\Support\Collection $collection
     * @param  array  $keys     Option value
     * @param  array  $values   Option label
     * @param  array  $sorts    Sort key
     * @return array
     */
    public static function dropdown($collection, $keys = array('id'), $values = array('name' ), $sorts = array()) {
        if (!empty($collection)) {
            $plucked = $collection->mapWithKeys(function($object, $key) use ($keys, $values){
                $option_key = '';
                $option_value = '';

                foreach ($keys as $key_item) {
                    if (!empty($object->$key_item)) {
                        $option_key .= $object->$key_item . ' - ';
                    }
                }

                foreach ($values as $value_item) {

                    if( is_array($value_item)) {
                      $key = key($values);
                      $column = $object->$key;

                      foreach ($value_item as $value_item_item) {

                        if (!empty($column->$value_item_item)) {
                          $option_value .= $column->$value_item_item;
                        }
                      }

                    }else{
                      if (!empty($object->$value_item)) {
                        $option_value .= $object->$value_item . ' - ';
                      }
                    }

                }

                $option_key = substr($option_key, 0, strlen($option_key) - strlen(' - '));
                $option_value = substr($option_value, 0, strlen($option_value) - strlen(' - '));

                return [$option_key => $option_value];
            });

            return (!empty($sorts)) ? $plucked->sortBy($sorts)->all() : $plucked->sort()->all();
        }

        return NULL;
    }



}
