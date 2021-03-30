<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnexeRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\Annexe;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnnexeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, Project $project)
    {
        $this->authorize('viewAny', [Annexe::class]);

        return Inertia::render('Calls/Projects/Annexes/Index', [
            'call'      => $call,
            'project'   => $project,
            'filters'   => request()->all('search'),
            'annexes'   => Annexe::where('project_id', $project->id)->orderBy('name', 'ASC')
                ->filterAnnexe(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, Project $project)
    {
        $this->authorize('create', [Annexe::class]);

        return Inertia::render('Calls/Projects/Annexes/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnexeRequest $request, Call $call, Project $project)
    {
        $this->authorize('create', [Annexe::class]);

        $annexe = new Annexe();
        $annexe->fieldName = $request->fieldName;
        $annexe->fieldName = $request->fieldName;
        $annexe->fieldName = $request->fieldName;

        $annexe->save();

        return redirect()->route('resourceRoute.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, Project $project, Annexe $annexe)
    {
        $this->authorize('view', [Annexe::class, $annexe]);

        return Inertia::render('Calls/Projects/Annexes/Show', [
            'annexe' => $annexe
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, Project $project, Annexe $annexe)
    {
        $this->authorize('update', [Annexe::class, $annexe]);

        return Inertia::render('Calls/Projects/Annexes/Edit', [
            'annexe' => $annexe
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function update(AnnexeRequest $request, Call $call, Project $project, Annexe $annexe)
    {
        $this->authorize('update', [Annexe::class, $annexe]);

        $annexe->fieldName = $request->fieldName;
        $annexe->fieldName = $request->fieldName;
        $annexe->fieldName = $request->fieldName;

        $annexe->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, Project $project, Annexe $annexe)
    {
        $this->authorize('delete', [Annexe::class, $annexe]);

        $annexe->delete();

        return redirect()->route('resourceRoute.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
