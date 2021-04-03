<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchResultRequest;
use App\Models\ResearchResult;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResearchResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [ResearchResult::class]);

        return Inertia::render('ResearchResults/Index', [
            'filters'   => request()->all('search'),
            'researchResults' => ResearchResult::orderBy('', 'ASC')
                ->filterResearchResult(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [ResearchResult::class]);

        return Inertia::render('ResearchResults/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResearchResultRequest $request)
    {
        $this->authorize('create', [ResearchResult::class]);

        $researchResult = new ResearchResult();
        $researchResult->fieldName = $request->fieldName;
        $researchResult->fieldName = $request->fieldName;
        $researchResult->fieldName = $request->fieldName;

        $researchResult->save();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchResult  $researchResult
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchResult $researchResult)
    {
        $this->authorize('view', [ResearchResult::class, $researchResult]);

        return Inertia::render('ResearchResults/Show', [
            'researchResult' => $researchResult
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResearchResult  $researchResult
     * @return \Illuminate\Http\Response
     */
    public function edit(ResearchResult $researchResult)
    {
        $this->authorize('update', [ResearchResult::class, $researchResult]);

        return Inertia::render('ResearchResults/Edit', [
            'researchResult' => $researchResult
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResearchResult  $researchResult
     * @return \Illuminate\Http\Response
     */
    public function update(ResearchResultRequest $request, ResearchResult $researchResult)
    {
        $this->authorize('update', [ResearchResult::class, $researchResult]);

        $researchResult->fieldName = $request->fieldName;
        $researchResult->fieldName = $request->fieldName;
        $researchResult->fieldName = $request->fieldName;

        $researchResult->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchResult  $researchResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchResult $researchResult)
    {
        $this->authorize('delete', [ResearchResult::class, $researchResult]);

        $researchResult->delete();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been deleted successfully.');
    }
}
