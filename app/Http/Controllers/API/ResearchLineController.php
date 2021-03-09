<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResearchLineRequest;
use App\Http\Resources\ResearchLineResource;
use App\Models\ResearchLine;
use Illuminate\Http\Request;

class ResearchLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResearchLineResource::collection(ResearchLine::orderBy('fieldName')->get());
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
        $researchLine->fieldName = $request->get('fieldName');
        $researchLine->fieldName = $request->get('fieldName');
        $researchLine->fieldName = $request->get('fieldName');

        $researchLine->save();

        return new ResearchLineResource($researchLine);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchLine  $researchLine
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchLine $researchLine)
    {
        $this->authorize('view', [ResearchLine::class]);

        return new ResearchLineResource($researchLine);
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
        $this->authorize('update', [ResearchLine::class]);

        $researchLine->fieldName = $request->get('fieldName');
        $researchLine->fieldName = $request->get('fieldName');
        $researchLine->fieldName = $request->get('fieldName');

        $researchLine->save();

        return new ResearchLineResource($researchLine);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchLine  $researchLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchLine $researchLine)
    {
        $this->authorize('delete', [ResearchLine::class]);

        $researchLine->delete();

        return response()->json(null, 204);
    }
}
