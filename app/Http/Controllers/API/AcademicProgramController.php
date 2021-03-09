<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicProgramRequest;
use App\Http\Resources\AcademicProgramResource;
use App\Models\AcademicProgram;
use Illuminate\Http\Request;

class AcademicProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AcademicProgramResource::collection(AcademicProgram::orderBy('fieldName')->get());
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
        $academicProgram->fieldName = $request->get('fieldName');
        $academicProgram->fieldName = $request->get('fieldName');
        $academicProgram->fieldName = $request->get('fieldName');

        $academicProgram->save();

        return new AcademicProgramResource($academicProgram);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicProgram $academicProgram)
    {
        $this->authorize('view', [AcademicProgram::class]);

        return new AcademicProgramResource($academicProgram);
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
        $this->authorize('update', [AcademicProgram::class]);

        $academicProgram->fieldName = $request->get('fieldName');
        $academicProgram->fieldName = $request->get('fieldName');
        $academicProgram->fieldName = $request->get('fieldName');

        $academicProgram->save();

        return new AcademicProgramResource($academicProgram);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicProgram  $academicProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(AcademicProgram $academicProgram)
    {
        $this->authorize('delete', [AcademicProgram::class]);

        $academicProgram->delete();

        return response()->json(null, 204);
    }
}
