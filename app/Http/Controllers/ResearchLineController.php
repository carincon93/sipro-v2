<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchLineRequest;
use App\Models\ResearchGroup;
use App\Models\ResearchLine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResearchLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [ResearchLine::class]);

        return Inertia::render('ResearchLines/Index', [
            'filters'   => request()->all('search'),
            'researchLines' => ResearchLine::with('researchGroup', 'researchGroup.academicCentre')
                ->filterResearchLine(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [ResearchLine::class]);

        return Inertia::render('ResearchLines/Create',[
            'researchGroups' => ResearchGroup::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResearchLineRequest $request)
    {
        $this->authorize('create', [ResearchLine::class]);

        $researchLine = new ResearchLine();
        $researchLine->name         = $request->name;
        $researchLine->researchGroup()->associate($request->research_group);

        $researchLine->save();

        return redirect()->route('research-lines.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchLine  $researchLine
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchLine $researchLine)
    {
        $this->authorize('view', [ResearchLine::class, $researchLine]);

        return Inertia::render('ResearchLines/Show', [
            'researchLine' => $researchLine
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResearchLine  $researchLine
     * @return \Illuminate\Http\Response
     */
    public function edit(ResearchLine $researchLine)
    {
        $this->authorize('update', [ResearchLine::class, $researchLine]);

        $selectedResearchGroup = ['value' => optional($researchLine->researchGroup)->id, 'label' => optional($researchLine->researchGroup)->name];

        return Inertia::render('ResearchLines/Edit', [
            'researchLine'          => $researchLine,
            'researchGroups'        => ResearchGroup::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
            'selectedResearchGroup' => $selectedResearchGroup

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResearchLine  $researchLine
     * @return \Illuminate\Http\Response
     */
    public function update(ResearchLineRequest $request, ResearchLine $researchLine)
    {
        $this->authorize('update', [ResearchLine::class, $researchLine]);

        $researchLine->name         = $request->name;
        $researchLine->researchGroup()->associate($request->research_group);

        $researchLine->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchLine  $researchLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchLine $researchLine)
    {
        $this->authorize('delete', [ResearchLine::class, $researchLine]);

        $researchLine->delete();

        return redirect()->route('research-lines.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
