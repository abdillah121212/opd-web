<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NameVerificationRequest extends FormRequest
{
    public function authorize()
    {
        return hash_equals(
            (string) $this->route('id'),
            (string) $this->user()->getKey()
        ) && hash_equals(
            (string) $this->route('hash'),
            sha1($this->user()->getEmailForVerification())
        );
    }

    public function rules()
    {
        return [];
    }
}