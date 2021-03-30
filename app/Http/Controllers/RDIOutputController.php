<?php

namespace App\Http\Controllers;

use App\Http\Requests\RDIOutputRequest;
use App\Models\Call;
use App\Models\RDI;
use App\Models\RDIOutput;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RDIOutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, RDI $rdi)
    {
        $this->authorize('viewAny', [RDIOutput::class]);

        $researchResult = $rdi->project->directEffects()->with('researchResult')->get()->pluck('researchResult')->flatten()->filter();

        return Inertia::render('Calls/Projects/RDI/RDIOutputs/Index', [
            'call'          => $call,
            'rdi'           => $rdi,
            'filters'       => request()->all('search'),
            'rdiOutputs'    => RDIOutput::whereIn('research_result_id',
                            $researchResult->map(function ($researchResult) {
                                return $researchResult->id;
                            }))->filterRDIOutput(request()->only('search'))->paginate(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, RDI $rdi)
    {
        $this->authorize('create', [RDIOutput::class]);

        return Inertia::render('Calls/Projects/RDI/RDIOutputs/Create', [
            'call' => $call,
            'rdi'  => $rdi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RDIOutputRequest $request, Call $call, RDI $rdi)
    {
        $this->authorize('create', [RDIOutput::class]);

        $rdiOutput = new RDIOutput();
        $rdiOutput->fieldName = $request->fieldName;
        $rdiOutput->fieldName = $request->fieldName;
        $rdiOutput->fieldName = $request->fieldName;

        $rdiOutput->save();

        return redirect()->route('calls.rdi.rdi-outputs.index', ['call', 'rdi'])->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return \Illuminate\Http\Response
     */
    public function show(RDIOutput $rdiOutput)
    {
        $this->authorize('view', [RDIOutput::class, $rdiOutput]);

        return Inertia::render('Calls/Projects/RDI/RDIOutputs/Show', [
            'call' => $call,
            'rdi'  => $rdi,
            'rdiOutput' => $rdiOutput
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return \Illuminate\Http\Response
     */
    public function edit(RDIOutput $rdiOutput)
    {
        $this->authorize('update', [RDIOutput::class, $rdiOutput]);

        return Inertia::render('Calls/Projects/RDI/RDIOutputs/Edit', [
            'call' => $call,
            'rdi'  => $rdi,
            'rdiOutput' => $rdiOutput
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return \Illuminate\Http\Response
     */
    public function update(RDIOutputRequest $request, Call $call, RDI $rdi, RDIOutput $rdiOutput)
    {
        $this->authorize('update', [RDIOutput::class, $rdiOutput]);

        $rdiOutput->fieldName = $request->fieldName;
        $rdiOutput->fieldName = $request->fieldName;
        $rdiOutput->fieldName = $request->fieldName;

        $rdiOutput->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RDIOutput  $rdiOutput
     * @return \Illuminate\Http\Response
     */
    public function destroy(RDIOutput $rdiOutput)
    {
        $this->authorize('delete', [RDIOutput::class, $rdiOutput]);

        $rdiOutput->delete();

        return redirect()->route('calls.rdi.rdi-outputs.index', ['call', 'rdi'])->with('success', __('The resource has been deleted successfully.'));
    }
}
