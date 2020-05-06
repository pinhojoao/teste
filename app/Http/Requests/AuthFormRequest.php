<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthFormRequest extends FormRequest
{
    const SIGNUP = 'signup';
    const LOGIN = 'login';

    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        switch (request()->route()->getActionMethod()) {
            case self::SIGNUP:
                return $this->onSignup();
                break;
            case self::LOGIN:
                return $this->onLogin();
                break;
            default:
                return $this->onDefault();
                break;
        }
    }

    public function onSignup(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ];
    }

    public function onLogin(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ];
    }

    public function onDefault(): array
    {
        return [];
    }
}
