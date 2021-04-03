<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResearchGroupRequest;
use App\Models\ResearchGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResearchGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [ResearchGroup::class]);

        return Inertia::render('ResearchGroups/Index', [
            'filters'   => request()->all('search'),
            'researchGroups' => ResearchGroup::with('academicCentre.regional')
                ->filterResearchGroup(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [ResearchGroup::class]);

        $mincienciasCategories = [
            ['value' => 'A', 'label' => 'A'],
            ['value' => 'A1', 'label' => 'A1'],
            ['value' => 'B', 'label' => 'B'],
            ['value' => 'C', 'label' => 'C'],
            ['value' => 'Reconocido', 'label' => 'Reconocido'],
            ['value' => 'No reconocido', 'label' => 'No reconocido']
        ];

        return Inertia::render('ResearchGroups/Create', [
            'mincienciasCategories'  => $mincienciasCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResearchGroupRequest $request)
    {
        $this->authorize('create', [ResearchGroup::class]);

        $researchGroup = new ResearchGroup();
        $researchGroup->name                  = $request->name;
        $researchGroup->acronym               = $request->acronym;
        $researchGroup->email                 = $request->email;
        $researchGroup->gruplac_link          = $request->gruplac_link;
        $researchGroup->minciencias_code      = $request->minciencias_code;
        $researchGroup->minciencias_category  = $request->minciencias_category;
        $researchGroup->academicCentre()->associate($request->academic_centre);

        $researchGroup->save();

        return redirect()->route('research-groups.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchGroup $researchGroup)
    {
        $this->authorize('view', [ResearchGroup::class, $researchGroup]);

        return Inertia::render('ResearchGroups/Show', [
            'researchGroup' => $researchGroup
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ResearchGroup $researchGroup)
    {
        $this->authorize('update', [ResearchGroup::class, $researchGroup]);

        $mincienciasCategories = [
            ['value' => 'A', 'label' => 'A'],
            ['value' => 'A1', 'label' => 'A1'],
            ['value' => 'B', 'label' => 'B'],
            ['value' => 'C', 'label' => 'C'],
            ['value' => 'Reconocido', 'label' => 'Reconocido'],
            ['value' => 'No reconocido', 'label' => 'No reconocido']
        ];

        $selectedMincienciasCategory    = ['value' => $researchGroup->minciencias_category, 'label' => $researchGroup->minciencias_category];

        return Inertia::render('ResearchGroups/Edit', [
            'researchGroup'                 => $researchGroup,
            'mincienciasCategories'         => $mincienciasCategories,
            'selectedMincienciasCategory'   => $selectedMincienciasCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return \Illuminate\Http\Response
     */
    public function update(ResearchGroupRequest $request, ResearchGroup $researchGroup)
    {
        $this->authorize('update', [ResearchGroup::class, $researchGroup]);

        $researchGroup->name                  = $request->name;
        $researchGroup->acronym               = $request->acronym;
        $researchGroup->email                 = $request->email;
        $researchGroup->gruplac_link          = $request->gruplac_link;
        $researchGroup->minciencias_code      = $request->minciencias_code;
        $researchGroup->minciencias_category  = $request->minciencias_category;
        $researchGroup->academicCentre()->associate($request->academic_centre);

        $researchGroup->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchGroup $researchGroup)
    {
        $this->authorize('delete', [ResearchGroup::class, $researchGroup]);

        $researchGroup->delete();

        return redirect()->route('research-groups.index')->with('success', 'The resource has been deleted successfully.');
    }
}
