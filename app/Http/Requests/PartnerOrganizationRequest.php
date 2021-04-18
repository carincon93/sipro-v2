<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerOrganizationRequest extends FormRequest
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
                'partner_organization_type'     => ['required', 'max:191'],
                'name'                          => ['required', 'max:255'],
                'legal_status'                  => ['required', 'max:191'],
                'company_type'                  => ['required', 'max:191'],
                'nit'                           => ['required', 'max:11'],
                'agreement_description'         => ['nullable'],
                'research_group'                => ['nullable', 'max:191'],
                'gruplac_code'                  => ['nullable', 'max:191'],
                'gruplac_link'                  => ['nullable', 'url', 'max:191'],
                'knowledge_transfer_activities' => ['required', 'max:10000'],
                'letter_of_intent'              => ['nullable', 'max:10000000', 'file', 'mimetypes:application/pdf'],
                'intellectual_property'         => ['nullable', 'max:10000000', 'file', 'mimetypes:application/pdf'],
                'in_kind'                       => ['required', 'numeric'],
                'in_kind_description'           => ['required'],
                'funds'                         => ['required', 'numeric'],
                'funds_description'             => ['required'],
            ];
        } else {
            return [
                'partner_organization_type'     => ['required', 'max:191'],
                'name'                          => ['required', 'max:255'],
                'legal_status'                  => ['required', 'max:191'],
                'company_type'                  => ['required', 'max:191'],
                'nit'                           => ['required', 'max:11'],
                'agreement_description'         => ['nullable'],
                'research_group'                => ['nullable', 'max:191'],
                'gruplac_code'                  => ['nullable', 'max:191'],
                'gruplac_link'                  => ['nullable', 'url', 'max:191'],
                'knowledge_transfer_activities' => ['required', 'max:10000'],
                'letter_of_intent'              => ['required', 'max:10000000', 'file', 'mimetypes:application/pdf'],
                'intellectual_property'         => ['required', 'max:10000000', 'file', 'mimetypes:application/pdf'],
                'in_kind'                       => ['required', 'numeric'],
                'in_kind_description'           => ['required'],
                'funds'                         => ['required', 'numeric'],
                'funds_description'             => ['required'],
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
        $partnerOrganizationType = $this->partner_organization_type;
        switch ($partnerOrganizationType) {
            case 'Empresa':
                $partnerOrganizationType = 1;
                break;
            case 'Universidad':
                $partnerOrganizationType = 2;
                break;
            case 'Entidades sin ánimo de lucro':
                $partnerOrganizationType = 3;
                break;
            case 'Centro de formación SENA':
                $partnerOrganizationType = 4;
                break;
            case 'Otra':
                $partnerOrganizationType = 5;
                break;
            default:
                break;
        }

        $this->merge([
            'partner_organization_type' => $partnerOrganizationType,
        ]);

        $legalStatus = $this->legal_status;
        switch ($legalStatus) {
            case 'Pública':
                $legalStatus = 1;
                break;
            case 'Privado':
                $legalStatus = 2;
                break;
            case 'Mixta':
                $legalStatus = 3;
                break;
            case 'ONG':
                $legalStatus = 4;
                break;
            default:
                break;
        }

        $this->merge([
            'legal_status' => $legalStatus,
        ]);

        $companyType = $this->company_type;
        switch ($companyType) {
            case 'Microempresa':
                $companyType = 1;
                break;
            case 'Pequeña':
                $companyType = 2;
                break;
            case 'Mediana':
                $companyType = 3;
                break;
            case 'Grande':
                $companyType = 4;
                break;
            default:
                break;
        }

        $this->merge([
            'company_type' => $companyType,
        ]);
    }
}
