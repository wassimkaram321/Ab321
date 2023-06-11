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
            "id" => 'sometimes',
        ];
        if ($this->isMethod('post')) {
            $rules = [
                'name'            => 'sometimes',
                'name_ar'         => 'sometimes',
                'description'     => 'sometimes',
                'description_ar'  => 'sometimes',
                'image'           => 'sometimes|image',
                'distance'        => 'nullable',
                'phone'           => 'nullable',
                'email'           => 'nullable',
                'address'         => 'nullable',
                'address2'        => 'nullable',
                'latitude'        => 'nullable',
                'longitude'       => 'nullable',
                'is_open'         => 'nullable',
                'start_date'      => 'sometimes',
                'expire_date'     => 'sometimes',
                'category_id'     => 'sometimes',
                "id"              => 'sometimes',
                'is_active'       => 'nullable',
                'custom_date'     => 'nullable|date',
                'website'         => 'nullable',
                'days'            => 'required|array',
                'days.*.day_id'   => 'required|exists:days,id',
                'days.*.open_at'  => 'required',
                'days.*.close_at' => 'required|after:days.*.open_at',
                'social_media'    => 'array',
                'social_media_.*.id'   => 'exists:social_media,id',
                'social_media_.*.link' => 'nullable',

            ];
        }
        return $rules;
    }
}
