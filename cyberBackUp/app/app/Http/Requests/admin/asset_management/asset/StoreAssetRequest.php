<?php

namespace App\Http\Requests\admin\asset_management\asset;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssetRequest extends FormRequest
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
            'ip' => ['nullable', 'ip', 'max:15'],
            'name' => ['required', 'max:200', 'unique:assets,name,'.$this->asset],
            'location_id' => ['nullable', 'exists:locations,id'], // the location that asset belongs to 
        ];
    }
}
