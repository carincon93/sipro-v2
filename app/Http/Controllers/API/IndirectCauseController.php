<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndirectCauseRequest;
use App\Http\Resources\IndirectCauseResource;
use App\Models\IndirectCause;
use Illuminate\Http\Request;

class IndirectCauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IndirectCauseResource::collection(IndirectCause::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndirectCauseRequest $request)
    {
        $this->authorize('create', [IndirectCause::class]);

        $indirectCause = new IndirectCause();
        $indirectCause->fieldName = $request->get('fieldName');
        $indirectCause->fieldName = $request->get('fieldName');
        $indirectCause->fieldName = $request->get('fieldName');

        $indirectCause->save();

        return new IndirectCauseResource($indirectCause);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return \Illuminate\Http\Response
     */
    public function show(IndirectCause $indirectCause)
    {
        $this->authorize('view', [IndirectCause::class]);

        return new IndirectCauseResource($indirectCause);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return \Illuminate\Http\Response
     */
    public function update(IndirectCauseRequest $request, IndirectCause $indirectCause)
    {
        $this->authorize('update', [IndirectCause::class]);

        $indirectCause->fieldName = $request->get('fieldName');
        $indirectCause->fieldName = $request->get('fieldName');
        $indirectCause->fieldName = $request->get('fieldName');

        $indirectCause->save();

        return new IndirectCauseResource($indirectCause);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return \Illuminate\Http\Response
     */
    public function destroy(IndirectCause $indirectCause)
    {
        $this->authorize('delete', [IndirectCause::class]);

        $indirectCause->delete();

        return response()->json(null, 204);
    }
}
