<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResearchResultRequest extends FormRequest
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
            'specific_objective_id' => ['required', 'exists:specific_objectives,id'],
            'description' => ['required', 'string', 'max:200'],
            'type' => ['required', 'string'],
            'trl' => ['required', 'digits_between:1,9'],
            'indicator' => ['required', 'string', 'max:200'],
            'means_of_verification' => ['required', 'string', 'max:200'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if(is_array($this->specific_objective_id)) {
            $this->merge([
                'specific_objective_id' => $this->specific_objective_id['value'],
            ]);
        }
        if( is_array($this->type) ) {
            $this->merge([
                'type' => $this->type['value'],
            ]);
        }
    }
}
