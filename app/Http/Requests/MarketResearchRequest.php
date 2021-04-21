<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarketResearchRequest extends FormRequest
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
                'price_quote'       => ['required', 'numeric', 'min:0'],
                'company_name'      => ['required', 'max:255'],
                'price_quote_file'  => ['nullable', 'max:10000000', 'file', 'mimetypes:application/pdf'],
            ];
        } else {
            return [
                'price_quote'       => ['required', 'numeric', 'min:0'],
                'company_name'      => ['required', 'max:255'],
                'price_quote_file'  => ['required', 'max:10000000', 'file', 'mimetypes:application/pdf'],
            ];
        }
    }
}
