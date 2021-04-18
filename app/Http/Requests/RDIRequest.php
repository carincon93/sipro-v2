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
        return [
            'project_type_id'                       => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:project_types,id'],
            'research_line_id'                      => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:research_lines,id'],
            'knowledge_subarea_discipline_id'       => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:knowledge_subarea_disciplines,id'],
            'strategic_thematic_id'                 => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:strategic_thematics,id'],
            'knowledge_network_id'                  => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:knowledge_networks,id'],
            'ciiu_code_id'                          => ['required', 'min:0', 'max:99999999999999999', 'integer', 'exists:ciiu_codes,id'],
            'title'                                 => ['required', new MaxWords],
            'start_date'                            => ['required', 'date', 'date_format:Y-m-d', 'before:end_date', new ProjectStartDate($this->route('call'))],
            'end_date'                              => ['required', 'date', 'date_format:Y-m-d', 'after:start_date', new ProjectEndDate($this->route('call'))],
            'video'                                 => ['nullable', 'max:191', 'url'],
            'abstract'                              => ['required', 'max:2400'],
            'project_background'                    => ['required', 'max:40000'],
            'conceptual_framework'                  => ['required'],
            'project_methodology'                   => ['required'],
            'sustainability_proposal'               => ['required'],
            'sampling'                              => ['nullable', 'max:191'],
            'sampling_activity'                     => ['nullable', 'max:191'],
            'sampling_objective'                    => ['nullable', 'max:191'],
            'bibliography'                          => ['required'],
            'students'                              => ['required', 'min:0', 'max:9999', 'integer'],
            'states'                                => ['required'],
            'states_impact'                         => ['required'],
        ];
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
    }
}
