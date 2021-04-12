<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ProjectStartDate;
use App\Rules\ProjectEndDate;

class ActivityRequest extends FormRequest
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
            'indirect_cause_id'     => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:indirect_causes,id'],
            'specific_objective_id' => ['nullable', 'min:0', 'max:99999999999999999', 'integer', 'exists:specific_objectives,id'],
            'description'           => ['required'],
            'start_date'            => ['required', 'date', 'date_format:Y-m-d', 'before:end_date', new ProjectStartDate($this->route('call'))],
            'end_date'              => ['required', 'date', 'date_format:Y-m-d', 'after:start_date', new ProjectEndDate($this->route('call'))],
        ];
    }
}
