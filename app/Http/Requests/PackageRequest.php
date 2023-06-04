<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
         'name'=>'required',
         'name_ar'=>'required',
         'description'=>'required',
         'description_ar'=>'required',
         'is_active'=>'nullable',
         'price'=>'nullable',
         'start_date'=>'nullable',
         'end_date'=>'nullable',
        ];
    }
    public function update()
    {

        return [
            'id'=>'required',
            'name'=>'sometimes',
            'name_ar'=>'sometimes',
            'description'=>'sometimes',
            'description_ar'=>'sometimes',
            'is_active'=>'nullable',
            'price'=>'nullable',
            'start_date'=>'nullable',
            'end_date'=>'nullable',
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
