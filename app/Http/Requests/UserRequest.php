<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (Route::getCurrentRoute()->getActionMethod()) {
            case 'updateone':
                return $this->getCustomRule();
            case 'changePassword':
                return $this->getCustomRule();
            default:
                return [];
        }
    }

    public function getCustomRule()
    {
        if (Route::getCurrentRoute()->getActionMethod() == 'updateone') {
            return [
                'email' => 'required_without:proxy_email|email|unique:users',
                'proxy_email' => 'required_without:email|email|unique:users',
                'password' => "required|min:8"
            ];
        }
        if (Route::getCurrentRoute()->getActionMethod() == 'changePassword') {
            return [
                'password' => "required|min:8"
            ];
        }
    }
}
