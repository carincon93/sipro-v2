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
        if ($this->isMethod('PUT')) {
            return [
                'academic_centre_id' => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:academic_centres,id'],
                'name'               => ['required', 'max:191'],
                'code'               => ['required', 'min:0', 'max:9999999999', 'integer', 'unique:academic_programs,code,'.$this->route('academic_program')->id.',id'],
                'study_mode'         => ['required', 'max:191'],
            ];
        } else {
            return [
                'academic_centre_id' => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:academic_centres,id'],
                'name'               => ['required', 'max:191'],
                'code'               => ['required', 'min:0', 'max:9999999999', 'integer', 'unique:academic_programs,code'],
                'study_mode'         => ['required', 'max:191'],
            ];
        }
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

        if( is_array($this->academic_centre_id) ) {
            $this->merge([
                'academic_centre_id' => $this->academic_centre_id['value'],
            ]);
        }
    }
}
