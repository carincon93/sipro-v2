<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpecificObjectiveRequest;
use App\Http\Resources\SpecificObjectiveResource;
use App\Models\SpecificObjective;
use Illuminate\Http\Request;

class SpecificObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SpecificObjectiveResource::collection(SpecificObjective::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecificObjectiveRequest $request)
    {
        $this->authorize('create', [SpecificObjective::class]);

        $specificObjective = new SpecificObjective();
        $specificObjective->fieldName = $request->get('fieldName');
        $specificObjective->fieldName = $request->get('fieldName');
        $specificObjective->fieldName = $request->get('fieldName');

        $specificObjective->save();

        return new SpecificObjectiveResource($specificObjective);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecificObjective  $specificObjective
     * @return \Illuminate\Http\Response
     */
    public function show(SpecificObjective $specificObjective)
    {
        $this->authorize('view', [SpecificObjective::class]);

        return new SpecificObjectiveResource($specificObjective);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SpecificObjective  $specificObjective
     * @return \Illuminate\Http\Response
     */
    public function update(SpecificObjectiveRequest $request, SpecificObjective $specificObjective)
    {
        $this->authorize('update', [SpecificObjective::class]);

        $specificObjective->fieldName = $request->get('fieldName');
        $specificObjective->fieldName = $request->get('fieldName');
        $specificObjective->fieldName = $request->get('fieldName');

        $specificObjective->save();

        return new SpecificObjectiveResource($specificObjective);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SpecificObjective  $specificObjective
     * @return \Illuminate\Http\Response
     */
    public function destroy(SpecificObjective $specificObjective)
    {
        $this->authorize('delete', [SpecificObjective::class]);

        $specificObjective->delete();

        return response()->json(null, 204);
    }
}
