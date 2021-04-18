<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarketResearchRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\ProjectSennovaBudget;
use App\Models\ProjectBudgetBatch;
use App\Models\MarketResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MarketResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('viewAny', [MarketResearch::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/MarketResearch/Index', [
            'filters'   => request()->all('search'),
            'marketResearchs' => MarketResearch::orderBy('company_name', 'ASC')
                ->filterMarketResearch(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create( Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('create', [MarketResearch::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/MarketResearch/Create', [
            'call'                 => $call,
            'project'              => $project,
            'projectSennovaBudget' => $projectSennovaBudget,
            'projectBudgetBatch'   => $projectBudgetBatch
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarketResearchRequest $request, Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('create', [MarketResearch::class]);

        $marketResearch = new MarketResearch();

        $marketResearch->price_quote    = $request->price_quote;
        $marketResearch->company_name   = $request->company_name;

        $endDate       = date('Y', strtotime($project->rdi->end_date));
        $companyName   = Str::slug(substr($request->company_name, 0, 30), '-');

        $factSheet = $request->price_quote_file;

        $priceQuoteFileName = ($project->rdi->id + 8000)."-SGPS-$endDate-estudio-de-mercado-$companyName.".$factSheet->extension();
        $pruceQuoteFile = $factSheet->storeAs(
            'market-research', $priceQuoteFileName
        );
        $marketResearch->price_quote_file = $pruceQuoteFile;

        $marketResearch->projectBudgetBatch()->associate($projectBudgetBatch);
        $marketResearch->save();

        return redirect()->back()->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch, MarketResearch $marketResearch)
    {
        $this->authorize('view', [MarketResearch::class, $marketResearch]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/MarketResearch/Show', [
            'marketResearch' => $marketResearch
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch, MarketResearch $marketResearch)
    {
        $this->authorize('update', [MarketResearch::class, $marketResearch]);

        return Inertia::render('Calls/Projects/ProjectSennovaBudgets/ProjectBudgetBatches/MarketResearch/Edit', [
            'call'                 => $call,
            'project'              => $project,
            'projectSennovaBudget' => $projectSennovaBudget,
            'projectBudgetBatch'   => $projectBudgetBatch,
            'marketResearch'       => $marketResearch
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return \Illuminate\Http\Response
     */
    public function update(MarketResearchRequest $request, Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch, MarketResearch $marketResearch)
    {
        $this->authorize('update', [MarketResearch::class, $marketResearch]);

        $marketResearch->price_quote    = $request->price_quote;
        $marketResearch->company_name   = $request->company_name;

        if ($request->hasFile('price_quote_file')) {
            Storage::delete($marketResearch->price_quote_file);
            $endDate       = date('Y', strtotime($project->rdi->end_date));
            $companyName   = Str::slug(substr($request->company_name, 0, 30), '-');

            $factSheet = $request->price_quote_file;

            $priceQuoteFileName = ($project->rdi->id + 8000)."-SGPS-$endDate-estudio-de-mercado-$companyName.".$factSheet->extension();
            $pruceQuoteFile = $factSheet->storeAs(
                'market-research', $priceQuoteFileName
            );
            $marketResearch->price_quote_file = $pruceQuoteFile;
        }

        $marketResearch->projectBudgetBatch()->associate($projectBudgetBatch);
        $marketResearch->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, Project $project, ProjectSennovaBudget $projectSennovaBudget, ProjectBudgetBatch $projectBudgetBatch, MarketResearch $marketResearch)
    {
        $this->authorize('delete', [MarketResearch::class, $marketResearch]);

        $marketResearch->delete();

        return redirect()->route('calls.projects.project-sennova-budgets.project-budget-batches.index', [$call, $project, $projectSennovaBudget, $projectBudgetBatch])->with('success', 'The resource has been deleted successfully.');
    }
}
