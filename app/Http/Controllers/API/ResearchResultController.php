<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResearchResultRequest;
use App\Http\Resources\ResearchResultResource;
use App\Models\ResearchResult;
use Illuminate\Http\Request;

class ResearchResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResearchResultResource::collection(ResearchResult::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResearchResultRequest $request)
    {
        $this->authorize('create', [ResearchResult::class]);

        $researchResult = new ResearchResult();
        $researchResult->fieldName = $request->get('fieldName');
        $researchResult->fieldName = $request->get('fieldName');
        $researchResult->fieldName = $request->get('fieldName');

        $researchResult->save();

        return new ResearchResultResource($researchResult);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchResult  $researchResult
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchResult $researchResult)
    {
        $this->authorize('view', [ResearchResult::class]);

        return new ResearchResultResource($researchResult);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResearchResult  $researchResult
     * @return \Illuminate\Http\Response
     */
    public function update(ResearchResultRequest $request, ResearchResult $researchResult)
    {
        $this->authorize('update', [ResearchResult::class]);

        $researchResult->fieldName = $request->get('fieldName');
        $researchResult->fieldName = $request->get('fieldName');
        $researchResult->fieldName = $request->get('fieldName');

        $researchResult->save();

        return new ResearchResultResource($researchResult);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchResult  $researchResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchResult $researchResult)
    {
        $this->authorize('delete', [ResearchResult::class]);

        $researchResult->delete();

        return response()->json(null, 204);
    }
}
