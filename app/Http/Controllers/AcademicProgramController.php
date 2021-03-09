<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicProgramRequest;
use App\Models\Regional;
use App\Models\AcademicCentre;
use App\Models\AcademicProgram;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [AcademicProgram::class]);

        return Inertia::render('AcademicPrograms/Index', [
            'filters'   => request()->all('search'),
            'academicPrograms' => AcademicProgram::with(['academicCentre' => function ($query) {
                    $query->orderBy('name', 'ASC');
                }])
                ->filterAcademicProgram(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [AcademicProgram::class]);

        $studyModes = [['value' => 'presencial', 'label' => 'Presencial'], ['value' => 'virtual', 'label' => 'Virtual']];

        return Inertia::render('AcademicPrograms/Create', [
            'academicCentres'   => AcademicCentre::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
            'studyModes'        => $studyModes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademicProgramRequest $request)
    {
        $this->authorize('create', [AcademicProgram::class]);

        $academicProgram = new AcademicProgram();
        $academicProgram->name = $request->name;
        $academicProgram->code = $request->code;
        $academicProgram->study_mode = $request->study_mode;
        $academicProgram->academicCentre()->associate($request->academic_centre);

        $academicProgram->save();

        return redirect()->route('academic-programs.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicProgram $academicProgram)
    {
        $this->authorize('view', [AcademicProgram::class, $academicProgram]);

        return Inertia::render('AcademicPrograms/Show', [
            'academicProgram' => $academicProgram
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicProgram $academicProgram)
    {
        $this->authorize('update', [AcademicProgram::class, $academicProgram]);

        $selectedAcademicCentre = ['value' => optional($academicProgram->academicCentre)->id, 'label' => optional($academicProgram->academicCentre)->name];
        $studyModes = [['value' => 'presencial', 'label' => 'Presencial'], ['value' => 'virtual', 'label' => 'Virtual']];

        $selectedStudyMode = ['value' => $academicProgram->study_mode, 'label' => $academicProgram->study_mode];

        return Inertia::render('AcademicPrograms/Edit', [
            'academicProgram'           => $academicProgram->only(['id', 'name', 'code']),
            'selectedAcademicCentre'    => $selectedAcademicCentre,
            'academicCentres'           => AcademicCentre::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
            'studyModes'                => $studyModes,
            'selectedStudyMode'         => $selectedStudyMode
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return \Illuminate\Http\Response
     */
    public function update(AcademicProgramRequest $request, AcademicProgram $academicProgram)
    {
        $this->authorize('update', [AcademicProgram::class, $academicProgram]);

        $academicProgram->name = $request->name;
        $academicProgram->code = $request->code;
        $academicProgram->study_mode = $request->study_mode;
        $academicProgram->academicCentre()->associate($request->academic_centre);

        $academicProgram->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicProgram $academicProgram)
    {
        $this->authorize('delete', [AcademicProgram::class, $academicProgram]);

        $academicProgram->delete();

        return redirect()->route('academic-programs.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
