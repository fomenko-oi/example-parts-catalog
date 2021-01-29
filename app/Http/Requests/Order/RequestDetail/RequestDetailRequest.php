<?php

namespace App\Http\Requests\Order\RequestDetail;

use App\Model\Order\Entity\Order\PaymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestDetailRequest extends FormRequest
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
            'detail_id' => ['required', 'exists:catalog_mark_details,id']
        ];
    }
}
