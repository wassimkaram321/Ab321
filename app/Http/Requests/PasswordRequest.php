<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            case 'index':
                return $this->index();
            case 'store':
                return $this->store();
            case 'update':
                return $this->store();
            case 'show':
                return $this->show();
            case 'destroy':
                return $this->show();
            case 'resetPassword':
                return $this->resetPassword();
            case 'resetOtpPassword':
                return $this->resetOtpPassword();
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
    public function index()
    {
        # code...
        return [
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
    public function resetPassword()
    {

        return [
            'old_password'=>'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }
    public function resetOtpPassword()
    {

        return [
            'phone'=>'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
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
