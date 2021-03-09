<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicCentreRequest;
use App\Http\Resources\AcademicCentreResource;
use App\Models\AcademicCentre;
use Illuminate\Http\Request;

class AcademicCentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AcademicCentreResource::collection(AcademicCentre::orderBy('fieldName')->get());
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
        $academicCentre->fieldName = $request->get('fieldName');
        $academicCentre->fieldName = $request->get('fieldName');
        $academicCentre->fieldName = $request->get('fieldName');

        $academicCentre->save();

        return new AcademicCentreResource($academicCentre);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicCentre $academicCentre)
    {
        $this->authorize('view', [AcademicCentre::class]);

        return new AcademicCentreResource($academicCentre);
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
        $this->authorize('update', [AcademicCentre::class]);

        $academicCentre->fieldName = $request->get('fieldName');
        $academicCentre->fieldName = $request->get('fieldName');
        $academicCentre->fieldName = $request->get('fieldName');

        $academicCentre->save();

        return new AcademicCentreResource($academicCentre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicCentre  $academicCentre
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicCentre $academicCentre)
    {
        $this->authorize('delete', [AcademicCentre::class]);

        $academicCentre->delete();

        return response()->json(null, 204);
    }
}
