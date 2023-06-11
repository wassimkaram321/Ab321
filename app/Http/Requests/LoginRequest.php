<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        switch ($this->getFunctionName()) {
            case 'login':
                return $this->login();
            case 'store':
                return $this->store();
            case 'update':
                return $this->store();
            case 'show':
                return $this->show();
            case 'destroy':
                return $this->show();
            case 'generateOTP':
                return $this->generateOTP();
            case 'resetPassword':
                return $this->resetPassword();
            default:
                return [];
        }
    }
    public function show()
    {
        # code...
        return [
            'id' => 'required',
        ];
    }
    public function login()
    {
        # code...
        return [
            'email' => 'sometimes|exists:users,email',
            'phone' => 'sometimes|exists:users,phone',
            'password' => 'required',
        ];
    }
    public function generateOTP()
    {
        # code...
        return [
            'phone' => 'unique:otps,phone',
        ];
    }
    public function resetPassword()
    {
        # code...
        return [
            'phone' => 'unique:otps,phone|exists:users,phone',
            'code' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }
    public function store()
    {
        # code...
        return [

        ];
    }
    public function update()
    {

        return [

        ];
    }
    public function getFunctionName(): string
    {
        $action = $this->route()->getAction();
        $controllerAction = $action['controller'];
        list($controller, $method) = explode('@', $controllerAction);
        return $method;
    }
}
