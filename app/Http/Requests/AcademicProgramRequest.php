<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AcademicProgramRequest extends FormRequest
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
            'academic_centre'    => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:academic_centres,id'],
            'name'               => ['required', 'max:191'],
            'code'               => ['required', 'min:0', 'max:9999999999', 'integer'],
            'study_mode'         => ['required', 'max:191'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->study_mode) ) {
            $this->merge([
                'study_mode' => $this->study_mode['value'],
            ]);
        }

        if( is_array($this->academic_centre) ) {
            $this->merge([
                'academic_centre' => $this->academic_centre['value'],
            ]);
        }
    }
}
