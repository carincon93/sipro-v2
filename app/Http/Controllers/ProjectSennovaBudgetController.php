<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectSennovaBudgetRequest;
use App\Models\Call;
use App\Models\CallBudget;
use App\Models\Project;
use App\Models\ProjectSennovaBudget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'projectSennovaBudgets' => ProjectSennovaBudget::where('project_id', $project->id)->filterProjectSennovaBudget(request()->only('search'))->with('callBudget.sennovaBudget.thirdBudgetInfo')->paginate(),
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

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/Create', [
            'call'      => $call,
            'project'   => $project
        ]);
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

        $callBudget = CallBudget::find($request->call_budget_id);

        $projectSennovaBudget = new ProjectSennovaBudget();
        $projectSennovaBudget->description      = $request->description;
        $projectSennovaBudget->justification    = $request->justification;

        $projectSennovaBudget->project()->associate($project);
        $projectSennovaBudget->callBudget()->associate($callBudget);
        $projectSennovaBudget->save();

        $endDate                = date('Y', strtotime($project->rdi->end_date));
        $secondBudgetInfoName   = Str::slug(substr($callBudget->sennovaBudget->secondBudgetInfo->name, 0, 30), '-');

        $factSheet = $request->fact_sheet;

        $factSheetFileName = ($project->rdi->id + 8000)."-SGPS-$endDate-ficha-tecnica-$secondBudgetInfoName.".$factSheet->extension();
        $factSheetFile = $factSheet->storeAs(
            'fact-sheets', $factSheetFileName
        );

        $projectBudgetBatches = $projectSennovaBudget->projectBudgetBatches()->create([
            'qty_items'  => $request->qty_items,
            'fact_sheet' => $factSheetFile
        ]);

        return response()->json(['projectSennovaBudget' => $projectSennovaBudget->only('id'), 'projectBudgetBatch' => $projectBudgetBatches->only('id')]);
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
            'call'                  =>  $call,
            'project'               => $project,
            'projectSennovaBudget'  => $projectSennovaBudget,
            'projectBudgetBatch'    => $projectSennovaBudget->projectBudgetBatches()
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

        $callBudget = CallBudget::find($request->call_budget_id);

        $projectSennovaBudget = new ProjectSennovaBudget();
        $projectSennovaBudget->description      = $request->description;
        $projectSennovaBudget->justification    = $request->justification;


        $projectSennovaBudget->project()->associate($project);
        $projectSennovaBudget->callBudget()->associate($callBudget);
        $projectSennovaBudget->save();

        if ($request->hasFile('fact_sheet')) {
            Storage::delete($projectSennovaBudget->projectBudgetBatches()->first()->fact_sheet);
            $endDate                = date('Y', strtotime($project->rdi->end_date));
            $secondBudgetInfoName   = Str::slug(substr($callBudget->sennovaBudget->secondBudgetInfo->name, 0, 30), '-');

            $factSheet = $request->fact_sheet;

            $factSheetFileName = ($project->rdi->id + 8000)."-SGPS-$endDate-ficha-tecnica-$secondBudgetInfoName.".$factSheet->extension();
            $factSheetFile = $factSheet->storeAs(
                'fact-sheets', $factSheetFileName
            );

            $projectSennovaBudget->projectBudgetBatches()->update([
                'qty_items'  => $request->qty_items,
                'fact_sheet' => $factSheetFile
            ]);
        }

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
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

        return redirect()->route('calls.projects.project-sennova-budgets.index', [$call, $project])->with('success', 'The resource has been deleted successfully.');
    }
}
