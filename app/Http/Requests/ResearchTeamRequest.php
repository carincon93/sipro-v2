<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchTeamRequest extends FormRequest
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
            'research_line' => ['required', 'min:0', 'max:2147483647999', 'integer', 'exists:research_lines,id'],
            'name'          => ['required', 'max:191'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->research_line) ) {
            $this->merge([
                'research_line' => $this->research_line['value'],
            ]);
        }
    }
}
