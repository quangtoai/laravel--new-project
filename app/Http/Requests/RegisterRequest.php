<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class RegisterRequest extends FormRequest
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
        return [
                'emp_code' => "required|unique:users|max:6|alpha_dash",["regex:r'^[a-zA-Z0-9]*$"],
                'first_name' => 'required|alpha',
                'email' => "required|email",
                'password' => "required|min:8",
                'password_confirmation' =>'required|same:password'
            ];


//        switch (Route::getCurrentRoute()->getActionMethod()) {
//            case 'register':
//                return $this->getCustomRule();
//            case 'update':
//                return $this->getCustomRule();
//            default:
//                return [];
//        }
//    }
//    public function getCustomRule()
//    {
//        if (Route::getCurrentRoute()->getActionMethod() == 'register') {
//            return [
//                'emp_code' => "required|unique:users|max:6|alpha_dash",["regex:r'^[a-zA-Z0-9]*$"],
//                'first_name' => 'required|alpha',
//                'email' => "required|email",
//                'password' => "required|min:8",
//                'password_confirmation' =>'required|same:password'
//            ];
//        }
//        if (Route::getCurrentRoute()->getActionMethod() == 'update') {
//            return [
//
//            ];
//        }
    }
}
