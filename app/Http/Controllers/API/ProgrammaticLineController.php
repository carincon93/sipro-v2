<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProgrammaticLineRequest;
use App\Http\Resources\ProgrammaticLineResource;
use App\Models\ProgrammaticLine;
use Illuminate\Http\Request;

class ProgrammaticLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProgrammaticLineResource::collection(ProgrammaticLine::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgrammaticLineRequest $request)
    {
        $this->authorize('create', [ProgrammaticLine::class]);

        $programmaticLine = new ProgrammaticLine();
        $programmaticLine->fieldName = $request->get('fieldName');
        $programmaticLine->fieldName = $request->get('fieldName');
        $programmaticLine->fieldName = $request->get('fieldName');

        $programmaticLine->save();

        return new ProgrammaticLineResource($programmaticLine);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return \Illuminate\Http\Response
     */
    public function show(ProgrammaticLine $programmaticLine)
    {
        $this->authorize('view', [ProgrammaticLine::class]);

        return new ProgrammaticLineResource($programmaticLine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return \Illuminate\Http\Response
     */
    public function update(ProgrammaticLineRequest $request, ProgrammaticLine $programmaticLine)
    {
        $this->authorize('update', [ProgrammaticLine::class]);

        $programmaticLine->fieldName = $request->get('fieldName');
        $programmaticLine->fieldName = $request->get('fieldName');
        $programmaticLine->fieldName = $request->get('fieldName');

        $programmaticLine->save();

        return new ProgrammaticLineResource($programmaticLine);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgrammaticLine $programmaticLine)
    {
        $this->authorize('delete', [ProgrammaticLine::class]);

        $programmaticLine->delete();

        return response()->json(null, 204);
    }
}
