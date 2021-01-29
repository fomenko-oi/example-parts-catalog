<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth\SignUp;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'regex:/\+[0-9]{1}\([0-9]{3}\) [0-9]{3}\-[0-9]{2}\-[0-9]{2}/'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'region_id' => ['required', 'integer', 'exists:country_regions,id'],
            'city_id' => ['required', 'string', 'max:255', 'exists:country_region_cities,id'],
            'address' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:255'],
            'accepted' => ['required'],
        ];
    }
}
