<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectBudgetBatchRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\ProjectSennovaBudget;
use App\Models\ProjectBudgetBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProjectBudgetBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('viewAny', [ProjectBudgetBatch::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/Index', [
            'filters'   => request()->all('search'),
            'projectBudgetBatchs' => ProjectBudgetBatch::orderBy('qty_items', 'ASC')
                ->filterProjectBudgetBatch(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('create', [ProjectBudgetBatch::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/Create', [
            'call'                  => $call,
            'project'               => $project,
            'projectSennovaBudget'  => $projectSennovaBudget,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectBudgetBatchRequest $request, Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('create', [ProjectBudgetBatch::class]);

        $projectBudgetBatch = new ProjectBudgetBatch();
        $projectBudgetBatch->qty_items = $request->qty_items;

        $endDate       = date('Y', strtotime($project->rdi->end_date));
        $secondBudgetInfoName   = Str::slug(substr($projectSennovaBudget->callBudget->sennovaBudget->secondBudgetInfo->name, 0, 30), '-');

        $factSheet = $request->fact_sheet;

        $factSheetFileName = ($project->rdi->id + 8000)."-SGPS-$endDate-ficha-tecnica-$secondBudgetInfoName.".$factSheet->extension();
        $factSheetFile = $factSheet->storeAs(
            'fact-sheets', $factSheetFileName
        );
        $projectBudgetBatch->fact_sheet = $factSheetFile;

        $projectBudgetBatch->projectSennovaBudget()->associate($projectSennovaBudget);
        $projectBudgetBatch->save();

        return redirect()->route('calls.projects.project-sennova-budgets.index', [$call, $project, $projectSennovaBudget])->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectBudgetBatch  $projectBudgetBatch
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('view', [ProjectBudgetBatch::class, $projectBudgetBatch]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/Show', [
            'projectBudgetBatch' => $projectBudgetBatch
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectBudgetBatch  $projectBudgetBatch
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('update', [ProjectBudgetBatch::class, $projectBudgetBatch]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/Edit', [
            'call'                  => $call,
            'project'               => $project,
            'projectSennovaBudget'  => $projectSennovaBudget,
            'projectBudgetBatch'    => $projectBudgetBatch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectBudgetBatch  $projectBudgetBatch
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectBudgetBatchRequest $request, Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('update', [ProjectBudgetBatch::class, $projectBudgetBatch]);

        $projectBudgetBatch->qty_items = $request->qty_items;

        if ($request->hasFile('fact_sheet')) {
            Storage::delete($projectBudgetBatch->fact_sheet);

            $endDate       = date('Y', strtotime($project->rdi->end_date));
            $secondBudgetInfoName   = Str::slug(substr($projectSennovaBudget->callBudget->sennovaBudget->secondBudgetInfo->name, 0, 30), '-');

            $factSheet = $request->fact_sheet;

            $factSheetFileName = ($project->rdi->id + 8000)."-SGPS-$endDate-ficha-tecnica-$secondBudgetInfoName.".$factSheet->extension();
            $factSheetFile = $factSheet->storeAs(
                'fact-sheets', $factSheetFileName
            );
            $projectBudgetBatch->fact_sheet = $factSheetFile;

            $projectBudgetBatch->projectSennovaBudget()->associate($projectSennovaBudget);
            $projectBudgetBatch->save();
        }

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectBudgetBatch  $projectBudgetBatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('delete', [ProjectBudgetBatch::class, $projectBudgetBatch]);

        $projectBudgetBatch->delete();

        return redirect()->route('calls.projects.project-sennova-budgets.index', [$call, $project, $projectSennovaBudget])->with('success', 'The resource has been deleted successfully.');
    }
}
