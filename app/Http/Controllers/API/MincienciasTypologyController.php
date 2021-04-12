<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MincienciasTypologyRequest;
use App\Http\Resources\MincienciasTypologyResource;
use App\Models\MincienciasTypology;
use Illuminate\Http\Request;

class MincienciasTypologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MincienciasTypologyResource::collection(MincienciasTypology::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MincienciasTypologyRequest $request)
    {
        $this->authorize('create', [MincienciasTypology::class]);

        $mincienciasTypology = new MincienciasTypology();
        $mincienciasTypology->fieldName = $request->get('fieldName');
        $mincienciasTypology->fieldName = $request->get('fieldName');
        $mincienciasTypology->fieldName = $request->get('fieldName');

        $mincienciasTypology->save();

        return new MincienciasTypologyResource($mincienciasTypology);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MincienciasTypology  $mincienciasTypology
     * @return \Illuminate\Http\Response
     */
    public function show(MincienciasTypology $mincienciasTypology)
    {
        $this->authorize('view', [MincienciasTypology::class]);

        return new MincienciasTypologyResource($mincienciasTypology);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MincienciasTypology  $mincienciasTypology
     * @return \Illuminate\Http\Response
     */
    public function update(MincienciasTypologyRequest $request, MincienciasTypology $mincienciasTypology)
    {
        $this->authorize('update', [MincienciasTypology::class]);

        $mincienciasTypology->fieldName = $request->get('fieldName');
        $mincienciasTypology->fieldName = $request->get('fieldName');
        $mincienciasTypology->fieldName = $request->get('fieldName');

        $mincienciasTypology->save();

        return new MincienciasTypologyResource($mincienciasTypology);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MincienciasTypology  $mincienciasTypology
     * @return \Illuminate\Http\Response
     */
    public function destroy(MincienciasTypology $mincienciasTypology)
    {
        $this->authorize('delete', [MincienciasTypology::class]);

        $mincienciasTypology->delete();

        return response()->json(null, 204);
    }
}
