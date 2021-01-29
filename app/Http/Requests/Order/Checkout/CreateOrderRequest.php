<?php

namespace App\Http\Requests\Order\Checkout;

use App\Model\Order\Entity\Order\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'regex:/\+[0-9]{1}\([0-9]{3}\) [0-9]{3}\-[0-9]{2}\-[0-9]{2}/'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'region_id' => ['required', 'integer', 'exists:country_regions,id'],
            'city_id' => ['required', 'integer', 'exists:country_region_cities,id'],
            'address' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:255'],
            'delivery_type' => ['required', 'exists:delivery_methods,id'],
            'payment_type' => ['required', Rule::in(array_keys(PaymentType::getTypesList()))],
            'comment' => ['nullable', 'max:255'],
            'accepted_rules' => ['required', 'boolean']
        ];
    }
}
