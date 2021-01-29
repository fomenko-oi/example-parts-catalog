<?php

namespace App\Http\Requests\Admin\User\User;

use App\Model\Auth\Entity\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:1',
            'phone' => 'required|min:1',
            'email' => 'required|email',
            'balance' => 'required|numeric',
            'role' => 'required|' .  Rule::in(array_keys(Role::getRoles())),
        ];
    }
}
