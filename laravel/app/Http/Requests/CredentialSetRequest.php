<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CredentialSetRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|max:250',
            'credentials' => 'required|max:4000',
        ];
    }
}
