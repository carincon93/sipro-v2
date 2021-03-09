<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectTypeRequest extends FormRequest
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
            'programmatic_line' => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:programmatic_lines,id'],
            'name'              => ['required', 'max:191'],
            'maximum_value'     => ['required', 'min:0', 'max:9999999999', 'integer'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->programmatic_line) ) {
            $this->merge([
                'programmatic_line' => $this->programmatic_line['value'],
            ]);
        }
    }
}
