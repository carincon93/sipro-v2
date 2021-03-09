<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeAreaRequest;
use App\Http\Resources\KnowledgeAreaResource;
use App\Models\KnowledgeArea;
use Illuminate\Http\Request;

class KnowledgeAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KnowledgeAreaResource::collection(KnowledgeArea::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeAreaRequest $request)
    {
        $this->authorize('create', [KnowledgeArea::class]);

        $knowledgeArea = new KnowledgeArea();
        $knowledgeArea->fieldName = $request->get('fieldName');
        $knowledgeArea->fieldName = $request->get('fieldName');
        $knowledgeArea->fieldName = $request->get('fieldName');

        $knowledgeArea->save();

        return new KnowledgeAreaResource($knowledgeArea);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeArea $knowledgeArea)
    {
        $this->authorize('view', [KnowledgeArea::class]);

        return new KnowledgeAreaResource($knowledgeArea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeAreaRequest $request, KnowledgeArea $knowledgeArea)
    {
        $this->authorize('update', [KnowledgeArea::class]);

        $knowledgeArea->fieldName = $request->get('fieldName');
        $knowledgeArea->fieldName = $request->get('fieldName');
        $knowledgeArea->fieldName = $request->get('fieldName');

        $knowledgeArea->save();

        return new KnowledgeAreaResource($knowledgeArea);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeArea $knowledgeArea)
    {
        $this->authorize('delete', [KnowledgeArea::class]);

        $knowledgeArea->delete();

        return response()->json(null, 204);
    }
}
