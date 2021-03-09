<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeSubareaRequest;
use App\Http\Resources\KnowledgeSubareaResource;
use App\Models\KnowledgeSubarea;
use Illuminate\Http\Request;

class KnowledgeSubareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KnowledgeSubareaResource::collection(KnowledgeSubarea::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeSubareaRequest $request)
    {
        $this->authorize('create', [KnowledgeSubarea::class]);

        $knowledgeSubarea = new KnowledgeSubarea();
        $knowledgeSubarea->fieldName = $request->get('fieldName');
        $knowledgeSubarea->fieldName = $request->get('fieldName');
        $knowledgeSubarea->fieldName = $request->get('fieldName');

        $knowledgeSubarea->save();

        return new KnowledgeSubareaResource($knowledgeSubarea);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeSubarea  $knowledgeSubarea
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeSubarea $knowledgeSubarea)
    {
        $this->authorize('view', [KnowledgeSubarea::class]);

        return new KnowledgeSubareaResource($knowledgeSubarea);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeSubarea  $knowledgeSubarea
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeSubareaRequest $request, KnowledgeSubarea $knowledgeSubarea)
    {
        $this->authorize('update', [KnowledgeSubarea::class]);

        $knowledgeSubarea->fieldName = $request->get('fieldName');
        $knowledgeSubarea->fieldName = $request->get('fieldName');
        $knowledgeSubarea->fieldName = $request->get('fieldName');

        $knowledgeSubarea->save();

        return new KnowledgeSubareaResource($knowledgeSubarea);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeSubarea  $knowledgeSubarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeSubarea $knowledgeSubarea)
    {
        $this->authorize('delete', [KnowledgeSubarea::class]);

        $knowledgeSubarea->delete();

        return response()->json(null, 204);
    }
}
