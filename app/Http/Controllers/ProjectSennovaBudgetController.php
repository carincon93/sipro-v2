<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectSennovaBudgetRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\ProjectSennovaBudget;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectSennovaBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, Project $project)
    {
        $this->authorize('viewAny', [ProjectSennovaBudget::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/Index', [
            'call'                  => $call,
            'project'               => $project,
            'filters'               => request()->all('search'),
            'projectSennovaBudgets' => ProjectSennovaBudget::where('project_id', $project->id)->filterProjectSennovaBudget(request()->only('search'))->with('callBudget.budgetProgrammaticLine.sennovaBudget.thirdBudgetInfo')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, Project $project)
    {
        $this->authorize('create', [ProjectSennovaBudget::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectSennovaBudgetRequest $request, Call $call, Project $project)
    {
        $this->authorize('create', [ProjectSennovaBudget::class]);

        $projectSennovaBudget = new ProjectSennovaBudget();
        $projectSennovaBudget->fieldName = $request->fieldName;
        $projectSennovaBudget->fieldName = $request->fieldName;
        $projectSennovaBudget->fieldName = $request->fieldName;

        $projectSennovaBudget->save();

        return redirect()->route('resourceRoute.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('view', [ProjectSennovaBudget::class, $projectSennovaBudget]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/Show', [
            'projectSennovaBudget' => $projectSennovaBudget
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('update', [ProjectSennovaBudget::class, $projectSennovaBudget]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/Edit', [
            'projectSennovaBudget' => $projectSennovaBudget
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectSennovaBudgetRequest $request, Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('update', [ProjectSennovaBudget::class, $projectSennovaBudget]);

        $projectSennovaBudget->fieldName = $request->fieldName;
        $projectSennovaBudget->fieldName = $request->fieldName;
        $projectSennovaBudget->fieldName = $request->fieldName;

        $projectSennovaBudget->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('delete', [ProjectSennovaBudget::class, $projectSennovaBudget]);

        $projectSennovaBudget->delete();

        return redirect()->route('resourceRoute.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
