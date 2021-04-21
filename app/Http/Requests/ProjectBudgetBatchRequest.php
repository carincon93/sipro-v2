<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectBudgetBatchRequest extends FormRequest
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
                'qty_items'     => ['required', 'numeric', 'min:1'],
                'fact_sheet'    => ['nullable', 'max:10000000', 'file', 'mimetypes:application/pdf'],
            ];
        } else {
            return [
                'qty_items'     => ['required', 'numeric', 'min:1'],
                'fact_sheet'    => ['required', 'max:10000000', 'file', 'mimetypes:application/pdf'],
            ];
        }
    }
}
