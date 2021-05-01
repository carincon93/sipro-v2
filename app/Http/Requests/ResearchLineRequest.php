<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchLineRequest extends FormRequest
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
            'research_group'     => ['required', 'min:0', 'max:2147483647999', 'integer', 'exists:research_groups,id'],
            'name'               => ['required', 'max:191', 'string'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->research_group) ) {
            $this->merge([
                'research_group' => $this->research_group['value'],
            ]);
        }
    }
}
