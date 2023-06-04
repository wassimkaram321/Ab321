<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'image'=>'sometimes|image',
            'thumbnail'=>'sometimes|image',
        ];
        if($this->isMethod('post')){
            $rules = [
                'name'=>'required',
                'name_ar'=>'required',
                'image'=>'required|image',
                'thumbnail'=>'required|image',
                "id"=>'sometimes',
                'image'=>'nullable|image',
                'thumbnail'=>'nullable|image',
            ];
        }
        return $rules;
    }
}
