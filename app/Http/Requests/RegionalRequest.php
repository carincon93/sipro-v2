<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegionalRequest extends FormRequest
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
            'region_id'             => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:regions,id'],
            'regional_director_id'  => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:users,id'],
            'name'                  => ['required', 'max:255', 'string'],
            'code'                  => ['required', 'max:255']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->region_id) ) {
            $this->merge([
                'region_id' => $this->region_id['value'],
            ]);
        }

        if( is_array($this->regional_director_id) ) {
            $this->merge([
                'regional_director_id' => $this->regional_director_id['value'],
            ]);
        }
    }
}
