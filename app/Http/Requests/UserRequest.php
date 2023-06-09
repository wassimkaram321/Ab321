<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            case 'addVendorToFavorite':
                return $this->vendorToFavorite();
            case 'removeVendorToFavorite':
                return $this->vendorToFavorite();
            case 'nerabyVendors':
                return $this->nerabyVendors();
            case 'changeEnableNotification':
                return $this->changeEnableNotification();
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
    public function vendorToFavorite()
    {
        return [
            'vendor_id' => 'required|exists:vendors,id',
        ];
    }
    public function nerabyVendors()
    {
        return [
            'latitude'  => 'required',
            'longitude' => 'required',
            'unit'      => 'required',
        ];
    }
    public function changeEnableNotification()
    {
        return [
            'enable_notification' => 'required|boolean',
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
