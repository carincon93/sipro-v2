<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeSubareaDisciplineRequest;
use App\Http\Resources\KnowledgeSubareaDisciplineResource;
use App\Models\KnowledgeSubareaDiscipline;
use Illuminate\Http\Request;

class KnowledgeSubareaDisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KnowledgeSubareaDisciplineResource::collection(KnowledgeSubareaDiscipline::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeSubareaDisciplineRequest $request)
    {
        $this->authorize('create', [KnowledgeSubareaDiscipline::class]);

        $knowledgeSubareaDiscipline = new KnowledgeSubareaDiscipline();
        $knowledgeSubareaDiscipline->fieldName = $request->get('fieldName');
        $knowledgeSubareaDiscipline->fieldName = $request->get('fieldName');
        $knowledgeSubareaDiscipline->fieldName = $request->get('fieldName');

        $knowledgeSubareaDiscipline->save();

        return new KnowledgeSubareaDisciplineResource($knowledgeSubareaDiscipline);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeSubareaDiscipline  $knowledgeSubareaDiscipline
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeSubareaDiscipline $knowledgeSubareaDiscipline)
    {
        $this->authorize('view', [KnowledgeSubareaDiscipline::class]);

        return new KnowledgeSubareaDisciplineResource($knowledgeSubareaDiscipline);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeSubareaDiscipline  $knowledgeSubareaDiscipline
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeSubareaDisciplineRequest $request, KnowledgeSubareaDiscipline $knowledgeSubareaDiscipline)
    {
        $this->authorize('update', [KnowledgeSubareaDiscipline::class]);

        $knowledgeSubareaDiscipline->fieldName = $request->get('fieldName');
        $knowledgeSubareaDiscipline->fieldName = $request->get('fieldName');
        $knowledgeSubareaDiscipline->fieldName = $request->get('fieldName');

        $knowledgeSubareaDiscipline->save();

        return new KnowledgeSubareaDisciplineResource($knowledgeSubareaDiscipline);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeSubareaDiscipline  $knowledgeSubareaDiscipline
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeSubareaDiscipline $knowledgeSubareaDiscipline)
    {
        $this->authorize('delete', [KnowledgeSubareaDiscipline::class]);

        $knowledgeSubareaDiscipline->delete();

        return response()->json(null, 204);
    }
}
