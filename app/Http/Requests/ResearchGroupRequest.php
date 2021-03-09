<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchGroupRequest extends FormRequest
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
                'academic_centre'       => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:academic_centres,id'],
                'name'                  => ['required', 'max:191', 'string'],
                'acronym'               => ['required', 'max:191'],
                'email'                 => ['required', 'max:191', 'email', 'unique:research_groups,email,'.$this->route('research_group')->id.',id'],
                'gruplac_link'          => ['required', 'url', 'max:191'],
                'minciencias_code'      => ['required', 'max:10', 'string', 'unique:research_groups,minciencias_code,'.$this->route('research_group')->id.',id'],
                'minciencias_category'  => ['required', 'max:16'],
            ];
        } else {
            return [
                'academic_centre'       => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:academic_centres,id'],
                'name'                  => ['required', 'max:191', 'string'],
                'acronym'               => ['required', 'max:191'],
                'email'                 => ['required', 'max:191', 'email', 'unique:research_groups,email'],
                'gruplac_link'          => ['required', 'url', 'max:191'],
                'minciencias_code'      => ['required', 'max:10', 'string', 'unique:research_groups,minciencias_code'],
                'minciencias_category'  => ['required', 'max:16'],
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
        if( is_array($this->academic_centre) ) {
            $this->merge([
                'academic_centre' => $this->academic_centre['value'],
            ]);
        }

        if( is_array($this->minciencias_category) ) {
            $this->merge([
                'minciencias_category' => $this->minciencias_category['value'],
            ]);
        }
    }
}
