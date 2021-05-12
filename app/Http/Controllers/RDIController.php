<?php

namespace App\Http\Controllers;

use App\Http\Requests\RDIRequest;
use App\Models\Citie;
use App\Models\Project;
use App\Models\RDI;
use App\Models\Call;
use App\Models\SectorBasedCommittee;
use App\Models\TechnoAcademy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class RDIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call)
    {
        $this->authorize('viewAny', [RDI::class]);

        return Inertia::render('Calls/Projects/RDI/Index', [
            'filters'   => request()->all('search'),
            'call'      => $call,
            'rdi'       => RDI::select('rdi.id', 'rdi.title', 'rdi.start_date', 'rdi.end_date')->join('projects', 'rdi.id', 'projects.id')->where('projects.call_id', $call->id)->orderBy('title', 'ASC')
                ->filterRDI(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call)
    {
        $this->authorize('create', [RDI::class]);

        return Inertia::render('Calls/Projects/RDI/Create', [
            'call' => $call->only('id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RDIRequest $request, Call $call)
    {
        $this->authorize('create', [RDI::class]);

        $project = new Project();
        $project->academicCentre()->associate($request->academic_centre_id);
        $project->projectType()->associate($request->project_type_id);
        $project->call()->associate($call);
        $project->save();

        $rdi = new RDI();
        $rdi->title                             = $request->title;
        $rdi->start_date                        = $request->start_date;
        $rdi->end_date                          = $request->end_date;
        $rdi->video                             = null;
        $rdi->industry_4_justification          = null;
        $rdi->orange_economy_justification      = null;
        $rdi->people_disabilities_justification = null;
        $rdi->abstract                          = 'Por favor diligencie el resumen del proyecto';
        $rdi->project_background                = 'Por favor diligencie los antecedentes del proyecto';
        $rdi->conceptual_framework              = 'Por favor diligencie el marco conceptual del proyecto';
        $rdi->project_methodology               = 'Por favor diligencie la metodología del proyecto';
        $rdi->sustainability_proposal           = 'Por favor diligencie la propuesta de sotenibilidad del proyecto';
        $rdi->bibliography                      = 'Por favor diligencie la bibliografía';
        $rdi->students                          = 0;
        $rdi->cities_impact                     = 'Describa el beneficio en los municipios';
        $rdi->academic_impact                   = 'Describa el beneficio en los municipios';

        $rdi->sampling                          = null;
        $rdi->sampling_activity                 = $request->sampling == 1 ? $request->sampling_activity : null;
        $rdi->sampling_objective                = $request->sampling == 1 ? $request->sampling_objective : null;

        $rdi->researchLine()->associate($request->research_line_id);
        $rdi->knowledgeSubareaDiscipline()->associate($request->knowledge_subarea_discipline_id);
        $rdi->strategicThematic()->associate($request->strategic_thematic_id);
        $rdi->knowledgeNetwork()->associate($request->knowledge_network_id);
        $rdi->ciiuCode()->associate($request->ciiu_code_id);

        $project->rdi()->save($rdi);

        return redirect()->route('calls.rdi.edit', [$call, $rdi])->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, RDI $rdi)
    {
        $this->authorize('view', [RDI::class, $rdi]);

        $rdi->project;

        return Inertia::render('Calls/Projects/RDI/Show', [
            'call'  => $call,
            'rdi'   => $rdi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, RDI $rdi)
    {
        $this->authorize('update', [RDI::class, $rdi]);

        $rdi->project->projectType->programmaticLine;

        return Inertia::render('Calls/Projects/RDI/Edit', [
            'call'                          => $call->only('id'),
            'rdi'                           => $rdi,
            'relatedSectorBasedCommittees'  => $rdi->sectorBasedCommittees()->pluck('id'),
            'relatedTechnologicalLines'     => $rdi->technologicalLines()->pluck('id'),
            'technoAcademy'                 => $rdi->technologicalLines->first() ? $rdi->technologicalLines->first()->technoAcademy->only('id', 'name') : null,
            'sectorBasedCommittees'         => SectorBasedCommittee::select('id', 'name')->get('id'),
            'technoAcademies'               => TechnoAcademy::select('id as value', 'name as label')->get(),
            'rdiDropdownOptions'            => json_decode(Storage::get('json/rdi-dropdown-options.json'), true),
            'projectCities'                 => $rdi->project->cities()->select('cities.id as value', 'cities.name as label', 'departments.name as group')->join('departments', 'departments.id', 'cities.department_id')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function update(RDIRequest $request, Call $call, RDI $rdi)
    {
        $this->authorize('update', [RDI::class, $rdi]);

        $rdi->title                             = $request->title;
        $rdi->start_date                        = $request->start_date;
        $rdi->end_date                          = $request->end_date;
        $rdi->video                             = $request->video;
        $rdi->industry_4_justification          = $request->industry_4_justification;
        $rdi->orange_economy_justification      = $request->orange_economy_justification;
        $rdi->people_disabilities_justification = $request->people_disabilities_justification;
        $rdi->abstract                          = $request->abstract;
        $rdi->project_background                = $request->project_background;
        $rdi->conceptual_framework              = $request->conceptual_framework;
        $rdi->project_methodology               = $request->project_methodology;
        $rdi->sustainability_proposal           = $request->sustainability_proposal;
        $rdi->bibliography                      = $request->bibliography;
        $rdi->students                          = $request->students;
        $rdi->cities_impact                     = $request->cities_impact;
        $rdi->academic_impact                   = $request->academic_impact;

        $rdi->sampling                          = $request->sampling;
        $rdi->sampling_activity                 = $request->sampling == 1 ? $request->sampling_activity : null;
        $rdi->sampling_objective                = $request->sampling == 1 ? $request->sampling_objective : null;

        $rdi->researchLine()->associate($request->research_line_id);
        $rdi->knowledgeSubareaDiscipline()->associate($request->knowledge_subarea_discipline_id);
        $rdi->strategicThematic()->associate($request->strategic_thematic_id);
        $rdi->knowledgeNetwork()->associate($request->knowledge_network_id);
        $rdi->ciiuCode()->associate($request->ciiu_code_id);

        $rdi->related_with_technological_plan           = $request->related_with_technological_plan;
        $rdi->related_with_competitiveness_innovation   = $request->related_with_competitiveness_innovation;
        $rdi->related_with_sector_based_committee       = $request->related_with_sector_based_committee;
        $rdi->related_with_techno_academy               = $request->related_with_techno_academy;

        $rdi->project()->update(['project_type_id' => $request->project_type_id]);
        $rdi->project()->update(['academic_centre_id' => $request->academic_centre_id]);
        $rdi->project->cities()->sync($request->cities);

        $rdi->save();

        $request->related_with_sector_based_committee == 1 ? $rdi->sectorBasedCommittees()->sync($request->sector_based_committee_id) : $rdi->sectorBasedCommittees()->detach();
        $request->related_with_techno_academy == 1 ? $rdi->technologicalLines()->sync($request->technological_line_id) : $rdi->technologicalLines()->detach();


        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Call $call, RDI $rdi)
    {
        $this->authorize('delete', [RDI::class, $rdi]);

        if ( !Hash::check($request->password, Auth::user()->password) ) {
            return redirect()->back()
                ->withErrors(['password' => __('The password is incorrect.')]);
        }

        $rdi->delete();

        return redirect()->route('calls.rdi.index', [$call])->with('success', 'The resource has been deleted successfully.');
    }
}
