<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
                return $this->update();
            case 'show':
                return $this->show();
            case 'destroy':
                return $this->show();
            case 'updateStatus':
                return $this->updateStatus();
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
        return [];
    }
    public function store()
    {
        # code...
        return [
            'name'        => 'required',
            'description' => 'required',
            'vendor_id'   => 'required|exists:vendors,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
            'priority'    => 'required',
            'url'         => 'required',
            'is_active'   => 'required',
            'image'       => 'required',
        ];
    }
    public function update()
    {

        return [
            'id'          => 'required|exists:banners,id',
            'name'        => 'required',
            'description' => 'required',
            'vendor_id'   => 'required|exists:vendors,id',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date',
            'priority'    => 'required',
            'url'         => 'required',
            'is_active'   => 'required',
            // 'image'       => 'required',
        ];
    }

    public function updateStatus()
    {
        return [
            'id'          => 'required|exists:banners,id',
            'is_active'   => 'required',
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
