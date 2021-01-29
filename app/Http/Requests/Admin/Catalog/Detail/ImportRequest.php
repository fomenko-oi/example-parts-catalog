<?php

namespace App\Http\Requests\Admin\Catalog\Detail;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => ['required', 'file'/*, 'mimes:csv,txt,xlsx'*/],
        ];
    }
}
