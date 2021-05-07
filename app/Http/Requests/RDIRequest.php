<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxWords;
use App\Rules\ProjectStartDate;
use App\Rules\ProjectEndDate;

class RDIRequest extends FormRequest
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
                'academic_centre_id'                        => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:academic_centres,id'],
                'project_type_id'                           => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:project_types,id'],
                'research_line_id'                          => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:research_lines,id'],
                'knowledge_subarea_discipline_id'           => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:knowledge_subarea_disciplines,id'],
                'strategic_thematic_id'                     => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:strategic_thematics,id'],
                'knowledge_network_id'                      => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:knowledge_networks,id'],
                'ciiu_code_id'                              => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:ciiu_codes,id'],
                'title'                                     => ['required', new MaxWords],
                'start_date'                                => ['required', 'date', 'date_format:Y-m-d', 'before:end_date', new ProjectStartDate($this->route('call'))],
                'end_date'                                  => ['required', 'date', 'date_format:Y-m-d', 'after:start_date', new ProjectEndDate($this->route('call'))],
                'video'                                     => ['nullable', 'max:191', 'url'],
                'abstract'                                  => ['required', 'max:2400', 'string'],
                'project_background'                        => ['required', 'max:40000', 'string'],
                'conceptual_framework'                      => ['required', 'string'],
                'project_methodology'                       => ['required', 'string'],
                'sustainability_proposal'                   => ['required', 'string'],
                'industry_4_justification'                  => ['nullable', 'string'],
                'orange_economy_justification'              => ['nullable', 'string'],
                'people_disabilities_justification'         => ['nullable', 'string'],
                'sampling'                                  => ['nullable', 'max:191'],
                'sampling_activity'                         => ['nullable', 'max:191'],
                'sampling_objective'                        => ['nullable', 'max:191'],
                'bibliography'                              => ['required', 'string'],
                'students'                                  => ['required', 'min:0', 'max:9999', 'integer'],
                'cities'                                    => ['required', 'array'],
                'cities.*'                                  => ['required', 'exists:cities,id', 'integer'],
                'cities_impact'                             => ['required', 'string'],
                'academic_impact'                           => ['required', 'string'],
                'related_with_technological_plan'           => ['required', 'min:0', 'max:3', 'integer'],
                'related_with_competitiveness_innovation'   => ['required', 'min:0', 'max:3', 'integer'],
                'related_with_sector_based_committee'       => ['required', 'min:0', 'max:3', 'integer'],
                'related_with_techno_academy'               => ['required', 'min:0', 'max:3', 'integer'],
                'sector_based_committee_id*'                => ['required_if:related_with_sector_based_committee,1', 'min:0', 'max:2147483647', 'integer', 'exists:sector_based_committees,id'],
                'technological_line_id*'                    => ['required_if:related_with_techno_academy,1', 'min:0', 'max:2147483647', 'integer', 'exists:technological_lines,id']
            ];
        } else {
            return [
                'academic_centre_id'                    => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:academic_centres,id'],
                'project_type_id'                       => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:project_types,id'],
                'research_line_id'                      => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:research_lines,id'],
                'knowledge_subarea_discipline_id'       => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:knowledge_subarea_disciplines,id'],
                'strategic_thematic_id'                 => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:strategic_thematics,id'],
                'knowledge_network_id'                  => ['required', 'min:0', 'max:2147483647', 'integer', 'exists:knowledge_networks,id'],
                'title'                                 => ['required', new MaxWords],
                'start_date'                            => ['required', 'date', 'date_format:Y-m-d', 'before:end_date', new ProjectStartDate($this->route('call'))],
                'end_date'                              => ['required', 'date', 'date_format:Y-m-d', 'after:start_date', new ProjectEndDate($this->route('call'))],
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
        if( is_string($this->title) ) {
            $this->merge([
                'title' => ucfirst(mb_strtolower($this->title)),
            ]);
        }

        if( is_array($this->academic_centre_id) ) {
            $this->merge([
                'academic_centre_id' => $this->academic_centre_id['value'],
            ]);
        }

        if( is_array($this->related_with_technological_plan) ) {
            $this->merge([
                'related_with_technological_plan' => $this->related_with_technological_plan['value'],
            ]);
        }

        if( is_array($this->related_with_competitiveness_innovation) ) {
            $this->merge([
                'related_with_competitiveness_innovation' => $this->related_with_competitiveness_innovation['value'],
            ]);
        }

        if( is_array($this->related_with_sector_based_committee) ) {
            $this->merge([
                'related_with_sector_based_committee' => $this->related_with_sector_based_committee['value'],
            ]);
        }

        if( is_array($this->related_with_techno_academy) ) {
            $this->merge([
                'related_with_techno_academy' => $this->related_with_techno_academy['value'],
            ]);
        }

        if( is_array($this->cities) ) {
            if(isset($this->cities['value']) && is_numeric($this->cities['value']) ) {
                $this->merge([
                    'cities' => $this->cities['value'],
                ]);
            }else{
                $cities = [];
                foreach ($this->cities as $index => $state) {
                    if( is_array($state) ) {
                        array_push($cities, $state['value']);
                    }
                }
                $this->merge(['cities' => $cities]);
            }
        }
    }
}
