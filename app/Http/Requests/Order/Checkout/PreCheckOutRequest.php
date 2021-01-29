<?php

namespace App\Http\Requests\Order\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class PreCheckOutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'delivery_type' => 'required|exists:delivery_methods,id',
            'comment' => 'nullable|max:255',
        ];
    }
}
