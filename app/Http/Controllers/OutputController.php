<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutputRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\Output;
use App\Models\RDIOutput;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, Project $project)
    {
        $this->authorize('viewAny', [Output::class]);

        $researchResult = $project->directEffects()->with('researchResult')->get()->pluck('researchResult')->flatten()->filter();

        return Inertia::render('Calls/Projects/RDI/Outputs/Index', [
            'call'          => $call,
            'project'       => $project,
            'filters'       => request()->all('search'),
            'outputs'       => Output::whereIn('research_result_id',
                                $researchResult->map(function ($researchResult) {
                                    return $researchResult->id;
                                }))->filterOutput(request()->only('search'))->paginate(200),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, Project $project)
    {
        $this->authorize('create', [Output::class]);

        $project->rdi;

        return Inertia::render('Calls/Projects/RDI/Outputs/Create', [
            'call' => $call,
            'project'  => $project,
            'researchResults' => $project->directEffects()->with('researchResult:id as value,description as label,direct_effect_id')->get()->pluck('researchResult')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutputRequest $request, Call $call, Project $project)
    {
        $this->authorize('create', [Output::class]);

        $output = new Output();
        $output->name       = $request->name;
        $output->start_date = $request->start_date;
        $output->end_date   = $request->end_date;
        $output->researchResult()->associate($request->research_result_id);
        $output->save();

        // Valida si es un producto de I+D+i
        if ($request->minciencias_subtypology_id) {
            $rdiOutput = new RDIOutput();
            $rdiOutput->output()->associate($output->id);
            $rdiOutput->mincienciasSubtypology()->associate($request->minciencias_subtypology_id);
            $rdiOutput->save();
        }

        return redirect()->route('calls.projects.outputs.index', [$call, $project])->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, Project $project, Output $output)
    {
        $this->authorize('view', [Output::class, $output]);

        return Inertia::render('Calls/Projects/RDI/Outputs/Show', [
            'call' => $call,
            'project'  => $project,
            'output' => $output
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, Project $project, Output $output)
    {
        $this->authorize('update', [Output::class, $output]);

        $project->rdi;
        $output->rdiOutput;
        $selectedResearchResult = ['value' => optional($output->researchResult)->id, 'label' => optional($output->researchResult)->description];

        return Inertia::render('Calls/Projects/RDI/Outputs/Edit', [
            'call' => $call,
            'project'  => $project,
            'output' => $output,
            'researchResults' => $project->directEffects()->with('researchResult:id as value,description as label,direct_effect_id')->get()->pluck('researchResult'),
            'selectedResearchResult' => $selectedResearchResult
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function update(OutputRequest $request, Call $call, Project $project, Output $output)
    {
        $this->authorize('update', [Output::class, $output]);

        $output->name = $request->name;
        $output->start_date = $request->start_date;
        $output->end_date = $request->end_date;
        $output->researchResult()->associate($request->research_result_id);

        if ($request->minciencias_subtypology_id) {
            $output->rdiOutput()->update(['minciencias_subtypology_id' => $request->minciencias_subtypology_id]);
        }

        $output->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, Project $project, Output $output)
    {
        $this->authorize('delete', [Output::class, $output]);

        $output->delete();

        return redirect()->route('calls.projects.outputs.index', [$call, $project])->with('success', 'The resource has been deleted successfully.');
    }
}
