<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SennovaRoleRequest extends FormRequest
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
            'programmatic_line_id'  => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:programmatic_lines,id'],
            'name'                  => ['required', 'max:191'],
            'description'           => ['required', 'string'],
            'academic_degree'       => ['required', 'integer']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->academic_degree) ) {
            $this->merge([
                'academic_degree' => $this->academic_degree['value'],
            ]);
        }
    }
}
