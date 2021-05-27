<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantRequest extends FormRequest
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
            'is_author' => ['required', 'boolean'],
            'qty_hours' => ['required', 'numeric', 'min:1', 'max:11.5'],
            'qty_months' => ['required', 'numeric'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if( is_array($this->is_author) ) {
            $this->merge([
                'is_author' => $this->is_author['value'],
            ]);
        }
    }
}
