<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MincienciasSubtypologyRequest;
use App\Http\Resources\MincienciasSubtypologyResource;
use App\Models\MincienciasSubtypology;
use Illuminate\Http\Request;

class MincienciasSubtypologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MincienciasSubtypologyResource::collection(MincienciasSubtypology::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MincienciasSubtypologyRequest $request)
    {
        $this->authorize('create', [MincienciasSubtypology::class]);

        $mincienciasSubtypology = new MincienciasSubtypology();
        $mincienciasSubtypology->fieldName = $request->get('fieldName');
        $mincienciasSubtypology->fieldName = $request->get('fieldName');
        $mincienciasSubtypology->fieldName = $request->get('fieldName');

        $mincienciasSubtypology->save();

        return new MincienciasSubtypologyResource($mincienciasSubtypology);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MincienciasSubtypology  $mincienciasSubtypology
     * @return \Illuminate\Http\Response
     */
    public function show(MincienciasSubtypology $mincienciasSubtypology)
    {
        $this->authorize('view', [MincienciasSubtypology::class]);

        return new MincienciasSubtypologyResource($mincienciasSubtypology);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MincienciasSubtypology  $mincienciasSubtypology
     * @return \Illuminate\Http\Response
     */
    public function update(MincienciasSubtypologyRequest $request, MincienciasSubtypology $mincienciasSubtypology)
    {
        $this->authorize('update', [MincienciasSubtypology::class]);

        $mincienciasSubtypology->fieldName = $request->get('fieldName');
        $mincienciasSubtypology->fieldName = $request->get('fieldName');
        $mincienciasSubtypology->fieldName = $request->get('fieldName');

        $mincienciasSubtypology->save();

        return new MincienciasSubtypologyResource($mincienciasSubtypology);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MincienciasSubtypology  $mincienciasSubtypology
     * @return \Illuminate\Http\Response
     */
    public function destroy(MincienciasSubtypology $mincienciasSubtypology)
    {
        $this->authorize('delete', [MincienciasSubtypology::class]);

        $mincienciasSubtypology->delete();

        return response()->json(null, 204);
    }
}
