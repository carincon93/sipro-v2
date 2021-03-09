<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrioritizedTopicRequest extends FormRequest
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
            'productive_sector'      => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:productive_sectors,id'],
            'technical_committee' => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:technical_committees,id'],
            'name'                   => ['required', 'max:191'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->productive_sector) ) {
            $this->merge([
                'productive_sector' => $this->productive_sector['value'],
            ]);
        }

        if( is_array($this->technical_committee) ) {
            $this->merge([
                'technical_committee' => $this->technical_committee['value'],
            ]);
        }
    }
}
