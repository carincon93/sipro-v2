<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnoAcademyRequest;
use App\Http\Resources\TechnoAcademyResource;
use App\Models\TechnoAcademy;
use Illuminate\Http\Request;

class TechnoAcademyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TechnoAcademyResource::collection(TechnoAcademy::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnoAcademyRequest $request)
    {
        $this->authorize('create', [TechnoAcademy::class]);

        $technoAcademy = new TechnoAcademy();
        $technoAcademy->fieldName = $request->get('fieldName');
        $technoAcademy->fieldName = $request->get('fieldName');
        $technoAcademy->fieldName = $request->get('fieldName');

        $technoAcademy->save();

        return new TechnoAcademyResource($technoAcademy);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return \Illuminate\Http\Response
     */
    public function show(TechnoAcademy $technoAcademy)
    {
        $this->authorize('view', [TechnoAcademy::class]);

        return new TechnoAcademyResource($technoAcademy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return \Illuminate\Http\Response
     */
    public function update(TechnoAcademyRequest $request, TechnoAcademy $technoAcademy)
    {
        $this->authorize('update', [TechnoAcademy::class]);

        $technoAcademy->fieldName = $request->get('fieldName');
        $technoAcademy->fieldName = $request->get('fieldName');
        $technoAcademy->fieldName = $request->get('fieldName');

        $technoAcademy->save();

        return new TechnoAcademyResource($technoAcademy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnoAcademy $technoAcademy)
    {
        $this->authorize('delete', [TechnoAcademy::class]);

        $technoAcademy->delete();

        return response()->json(null, 204);
    }
}
