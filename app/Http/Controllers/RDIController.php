<?php

namespace App\Http\Controllers;

use App\Http\Requests\RDIRequest;
use App\Models\RDI;
use App\Models\Call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
            'rdi'       => $call->rdi()->select('id', 'title', 'start_date')->orderBy('title', 'ASC')
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
            'call' => $call
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

        $rdi = new RDI();
        $rdi->fieldName = $request->fieldName;
        $rdi->fieldName = $request->fieldName;
        $rdi->fieldName = $request->fieldName;

        $rdi->save();

        return redirect()->route('calls.rdi.index', [$call])->with('success', 'The resource has been created successfully.');
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

        $rdi->project;

        return Inertia::render('Calls/Projects/RDI/Edit', [
            'call'  => $call,
            'rdi'   => $rdi,
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
        $rdi->states                            = $request->states;
        $rdi->states_impact                     = $request->states_impact;

        $rdi->sampling                          = $request->sampling;
        $rdi->sampling_activity                 = $request->sampling == 1 ? $request->sampling_activity : null;
        $rdi->sampling_objective                = $request->sampling == 1 ? $request->sampling_objective : null;

        $rdi->project->projectType()->associate($request->project_type_id);

        $rdi->researchLine()->associate($request->research_line_id);
        $rdi->knowledgeSubareaDiscipline()->associate($request->knowledge_subarea_discipline_id);
        $rdi->strategicThematic()->associate($request->strategic_thematic_id);
        $rdi->knowledgeNetwork()->associate($request->knowledge_network_id);
        $rdi->ciiuCode()->associate($request->ciiu_code_id);

        $rdi->save();

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
        $message = 'The resource has been deleted successfully.';
        $status = 'success';

        return redirect()->route('calls.rdi.index', [$call])->with('success', 'The resource has been deleted successfully.');
    }
}
