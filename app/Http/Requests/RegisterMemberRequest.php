<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'first_name' => 'required|max:255',
          'last_name' => 'required|max:255',
          'email' => 'required|email|unique:users|max:255',
          'password' => 'required|confirmed|min:6',
          'gender' => 'required',
          'race_id' => 'required',
          'date_of_birth' => 'date|required',
          'place_of_birth' => 'max:255',
          'nric' => 'required|max:255',
          'nationality_id' => 'integer',
          'phone_1' => 'required|max:20',
          'phone_2' => 'max:20',
          'education_level_id' => 'required|integer',
          'sem_when_registered' => 'required|integer',
          'illness' => 'max:255',

          'address.line_1' => 'string|required|max:60',
          'address.line_1' => 'string|max:60',
          'address.post_code' => 'required|min:4|max:10|AlphaDash',
          'address.city' => 'required|string|min:3|max:60',
          'address.state' => 'string|min:3|max:60',
          'address.country' => 'required',
        ];
    }
}
