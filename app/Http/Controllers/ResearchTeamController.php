<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchTeamRequest;
use App\Models\ResearchLine;
use App\Models\ResearchTeam;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResearchTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [ResearchTeam::class]);

        return Inertia::render('ResearchTeams/Index', [
            'filters'   => request()->all('search'),
            'researchTeams' => ResearchTeam::with('researchLine', 'researchLine.researchGroup')
                ->filterResearchTeam(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [ResearchTeam::class]);

        return Inertia::render('ResearchTeams/Create', [
            'researchLines' => ResearchLine::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResearchTeamRequest $request)
    {
        $this->authorize('create', [ResearchTeam::class]);

        $researchTeam = new ResearchTeam();
        $researchTeam->name = $request->name;
        $researchTeam->researchLine()->associate($request->research_line_id);

        $researchTeam->save();

        return redirect()->route('research-teams.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchTeam $researchTeam)
    {
        $this->authorize('view', [ResearchTeam::class, $researchTeam]);

        return Inertia::render('ResearchTeams/Show', [
            'researchTeam' => $researchTeam
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return \Illuminate\Http\Response
     */
    public function edit(ResearchTeam $researchTeam)
    {
        $this->authorize('update', [ResearchTeam::class, $researchTeam]);

        return Inertia::render('ResearchTeams/Edit', [
            'researchTeam'          => $researchTeam,
            'researchLines'         => ResearchLine::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return \Illuminate\Http\Response
     */
    public function update(ResearchTeamRequest $request, ResearchTeam $researchTeam)
    {
        $this->authorize('update', [ResearchTeam::class, $researchTeam]);

        $researchTeam->name = $request->name;
        $researchTeam->researchLine()->associate($request->research_line_id);

        $researchTeam->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchTeam $researchTeam)
    {
        $this->authorize('delete', [ResearchTeam::class, $researchTeam]);

        $researchTeam->delete();

        return redirect()->route('research-teams.index')->with('success', 'The resource has been deleted successfully.');
    }
}
