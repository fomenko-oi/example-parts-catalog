<?php

namespace App\Http\Requests\Admin\Order\DeliveryMethod;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:255',
            'name_ru' => 'nullable|min:3|max:255',
            'key' => 'nullable|min:1|max:255',
            'min_weight' => 'nullable|numeric',
            'max_weight' => 'nullable|numeric',
            'sort' => 'required|integer',
        ];
    }
}
