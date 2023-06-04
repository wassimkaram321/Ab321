<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules = [
            "id"=>'sometimes',
            'name'=>'sometimes',
            'name_ar'=>'sometimes',
            'description'=>'sometimes',
            'description_ar'=>'sometimes',
        ];
        if($this->isMethod('post')){
            $rules = [
                'name'=>'required',
                'name_ar'=>'required',
                'description'=>'required',
                'description_ar'=>'required',
                "id"=>'sometimes',
                "is_active"=>'sometimes',
                'image'=>'nullable|image',
                'thumbnail'=>'nullable|image',
            ];
        }
        return $rules;
    }
}
