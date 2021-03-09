<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'academic_centre_id'    => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:academic_centres,id'],
                'name'                  => ['required', 'max:255', 'string'],
                'email'                 => ['required', 'max:191', 'regex:/(.*)sena\.edu\.co$/i', 'email', 'unique:users,email,'.$this->route('user')->id.',id'],
                'document_type'         => ['required', 'max:2', 'string'],
                'document_number'       => ['required', 'min:0', 'max:9999999999999', 'integer', 'unique:users,document_number,'.$this->route('user')->id.',id'],
                'cellphone'             => ['required', 'min:0', 'max:9999999999', 'integer'],
                'participation_type'    => ['required', 'max:191', 'string'],
                'is_enabled'            => ['required', 'boolean'],
                // 'roles'                 => ['required'],
                // 'roles.*'               => ['required']
            ];
        } else {
            return [
                'academic_centre_id'    => ['required', 'min:0', 'max:9999999999', 'integer', 'exists:academic_centres,id'],
                'name'                  => ['required', 'max:255', 'string'],
                'email'                 => ['required', 'max:255', 'regex:/(.*)sena\.edu\.co$/i', 'unique:users,email', 'email'],
                'document_type'         => ['required', 'max:2', 'string'],
                'document_number'       => ['required', 'min:0', 'unique:users,document_number', 'max:9999999999999', 'integer'],
                'cellphone'             => ['required', 'min:0', 'max:9999999999', 'integer'],
                'participation_type'    => ['required', 'max:191', 'string'],
                'is_enabled'            => ['required', 'boolean'],
                // 'roles'                 => ['required'],
                // 'roles.*'               => ['required']
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
        if( is_array($this->document_type) ) {
            $this->merge([
                'document_type' => $this->document_type['value'],
            ]);
        }

        if( is_array($this->participation_type) ) {
            $this->merge([
                'participation_type' => $this->participation_type['value'],
            ]);
        }
    }
}
