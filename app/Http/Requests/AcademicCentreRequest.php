<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicCentreRequest extends FormRequest
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
            'regional_id'   => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:regional,id'],
            'name'          => ['required', 'max:255'],
            'code'          => ['required', 'integer']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->regional_id) ) {
            $this->merge([
                'regional_id' => $this->regional_id['value'],
            ]);
        }
    }
}
