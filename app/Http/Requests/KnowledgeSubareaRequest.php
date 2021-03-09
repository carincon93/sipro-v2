<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KnowledgeSubareaRequest extends FormRequest
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
            'knowledge_area' => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:knowledge_areas,id'],
            'name'           => ['required', 'max:191'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->knowledge_area) ) {
            $this->merge([
                'knowledge_area' => $this->knowledge_area['value'],
            ]);
        }
    }
}
