<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
        ];
        if($this->isMethod('post')){
            $rules = [
                'name'=>'sometimes',
                'name_ar'=>'sometimes',
                'description'=>'sometimes',
                'description_ar'=>'sometimes',
                'image'=>'sometimes|image',
                'distance'=>'nullable',
                'open'=>'nullable',
                'close'=>'nullable',
                'phone'=>'nullable',
                'email'=>'nullable',
                'address'=>'nullable',
                'address2'=>'nullable',
                'latitude'=>'nullable',
                'longitude'=>'nullable',
                'is_open'=>'nullable',
                'start_date'=>'sometimes',
                'expire_date'=>'sometimes',
                'category_id'=>'sometimes',
                "id"=>'sometimes',
                'is_active'=>'nullable',
                'custom_date'=>'nullable|
                ',
                'website'=>'nullable',
            ];
        }
        return $rules;
    }
}
