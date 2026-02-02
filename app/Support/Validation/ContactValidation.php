<?php

namespace App\Support\Validation;

class ContactValidation
{
    public static function rules(): array
    {
        return [
            'firstname'  => 'required|string|max:45',
            'lastname'   => 'required|string|max:45',
            'email'      => 'required|email|unique:contacts,email|max:90',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}
