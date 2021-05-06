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
            'productive_sector_id'   => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:productive_sectors,id'],
            'technical_committee_id' => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:technical_committees,id'],
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
        if( is_array($this->productive_sector_id) ) {
            $this->merge([
                'productive_sector_id' => $this->productive_sector_id['value'],
            ]);
        }

        if( is_array($this->technical_committee_id) ) {
            $this->merge([
                'technical_committee_id' => $this->technical_committee_id['value'],
            ]);
        }
    }
}
