<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicCentreRequest;
use App\Models\Regional;
use App\Models\AcademicCentre;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicCentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [AcademicCentre::class]);

        return Inertia::render('AcademicCentres/Index', [
            'filters'   => request()->all('search'),
            'academicCentres' => AcademicCentre::with(['regional' => function ($query) {
                $query->orderBy('name', 'ASC');
            }])
                ->filterAcademicCentre(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [AcademicCentre::class]);

        return Inertia::render('AcademicCentres/Create', [
            'regional' => Regional::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AcademicCentreRequest $request)
    {
        $this->authorize('create', [AcademicCentre::class]);

        $academicCentre = new AcademicCentre();
        $academicCentre->name = $request->name;
        $academicCentre->code = $request->code;
        $academicCentre->regional()->associate($request->regional);

        $academicCentre->save();

        return redirect()->route('academic-centres.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicCentre $academicCentre)
    {
        $this->authorize('view', [AcademicCentre::class, $academicCentre]);

        return Inertia::render('AcademicCentres/Show', [
            'academicCentre' => $academicCentre,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicCentre $academicCentre)
    {
        $this->authorize('update', [AcademicCentre::class, $academicCentre]);

        $selectedRegionalValue = ['value' => optional($academicCentre->regional)->id, 'label' => optional($academicCentre->regional)->name];

        return Inertia::render('AcademicCentres/Edit', [
            'academicCentre'        => $academicCentre->only(['id', 'name', 'code']),
            'selectedRegionalValue' => $selectedRegionalValue,
            'regional'              => Regional::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return \Illuminate\Http\Response
     */
    public function update(AcademicCentreRequest $request, AcademicCentre $academicCentre)
    {
        $this->authorize('update', [AcademicCentre::class, $academicCentre]);

        $academicCentre->name = $request->name;
        $academicCentre->code = $request->code;
        $academicCentre->regional()->associate($request->regional);

        $academicCentre->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicCentre $academicCentre)
    {
        $this->authorize('delete', [AcademicCentre::class, $academicCentre]);

        $academicCentre->delete();

        return redirect()->route('academic-centres.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
