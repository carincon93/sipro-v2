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
        $this->authorize('viewAny', ProjectSennovaBudget::class);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/Index', [
            'call'                  => $call,
            'project'               => $project,
            'filters'               => request()->all('search'),
            'projectSennovaBudgets' => ProjectSennovaBudget::where('project_id', $project->id)->filterProjectSennovaBudget(request()->only('search'))->with('callBudget.sennovaBudget.thirdBudgetInfo:id,name', 'callBudget.sennovaBudget.secondBudgetInfo:id,name', 'callBudget.sennovaBudget.budgetUsage:id,description')->paginate(),
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
        $projectSennovaBudget->value            = $request->value;
        $projectSennovaBudget->qty_items        = $request->qty_items;

        $projectSennovaBudget->project()->associate($project);
        $projectSennovaBudget->callBudget()->associate($callBudget);
        $projectSennovaBudget->save();

        return redirect()->route('calls.projects.project-sennova-budgets.market-research.index', [$call, $project, $projectSennovaBudget])->with('success', 'The resource has been created successfully.');
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

        $projectSennovaBudget->callBudget->sennovaBudget->budgetUsage;

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/Edit', [
            'call'                          => $call,
            'project'                       => $project,
            'projectSennovaBudget'          => $projectSennovaBudget,
            'projectSennovaBudgetBatches'   => $projectSennovaBudget->with('projectBudgetBatches.marketResearch')->where('id', $projectSennovaBudget->id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('update', [ProjectSennovaBudget::class, $projectSennovaBudget]);

        $callBudget = CallBudget::find($request->call_budget_id);

        $projectSennovaBudget->description      = $request->description;
        $projectSennovaBudget->justification    = $request->justification;
        $projectSennovaBudget->value            = null;
        $projectSennovaBudget->qty_items        = null;

        if (!$callBudget->sennovaBudget->requires_market_research) {
            foreach ($projectSennovaBudget->projectBudgetBatches as $projectBudgetBatch) {
                Storage::delete($projectBudgetBatch->fact_sheet);

                foreach ($projectBudgetBatch->marketResearch as $marketResearch) {
                    Storage::delete($marketResearch->price_quote_file);
                }

                $projectBudgetBatch->delete();
            }

            $projectSennovaBudget->value      = $request->value;
            $projectSennovaBudget->qty_items  = $request->qty_items;
        }

        $projectSennovaBudget->project()->associate($project);
        $projectSennovaBudget->callBudget()->associate($callBudget);
        $projectSennovaBudget->save();

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
