<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnologicalLineRequest;
use App\Http\Resources\TechnologicalLineResource;
use App\Models\TechnologicalLine;
use Illuminate\Http\Request;

class TechnologicalLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TechnologicalLineResource::collection(TechnologicalLine::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnologicalLineRequest $request)
    {
        $this->authorize('create', [TechnologicalLine::class]);

        $technologicalLine = new TechnologicalLine();
        $technologicalLine->fieldName = $request->get('fieldName');
        $technologicalLine->fieldName = $request->get('fieldName');
        $technologicalLine->fieldName = $request->get('fieldName');

        $technologicalLine->save();

        return new TechnologicalLineResource($technologicalLine);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return \Illuminate\Http\Response
     */
    public function show(TechnologicalLine $technologicalLine)
    {
        $this->authorize('view', [TechnologicalLine::class]);

        return new TechnologicalLineResource($technologicalLine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return \Illuminate\Http\Response
     */
    public function update(TechnologicalLineRequest $request, TechnologicalLine $technologicalLine)
    {
        $this->authorize('update', [TechnologicalLine::class]);

        $technologicalLine->fieldName = $request->get('fieldName');
        $technologicalLine->fieldName = $request->get('fieldName');
        $technologicalLine->fieldName = $request->get('fieldName');

        $technologicalLine->save();

        return new TechnologicalLineResource($technologicalLine);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnologicalLine $technologicalLine)
    {
        $this->authorize('delete', [TechnologicalLine::class]);

        $technologicalLine->delete();

        return response()->json(null, 204);
    }
}
