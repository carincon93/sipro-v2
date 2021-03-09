<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\KnowledgeNetworkRequest;
use App\Http\Resources\KnowledgeNetworkResource;
use App\Models\KnowledgeNetwork;
use Illuminate\Http\Request;

class KnowledgeNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return KnowledgeNetworkResource::collection(KnowledgeNetwork::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeNetworkRequest $request)
    {
        $this->authorize('create', [KnowledgeNetwork::class]);

        $knowledgeNetwork = new KnowledgeNetwork();
        $knowledgeNetwork->fieldName = $request->get('fieldName');
        $knowledgeNetwork->fieldName = $request->get('fieldName');
        $knowledgeNetwork->fieldName = $request->get('fieldName');

        $knowledgeNetwork->save();

        return new KnowledgeNetworkResource($knowledgeNetwork);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeNetwork $knowledgeNetwork)
    {
        $this->authorize('view', [KnowledgeNetwork::class]);

        return new KnowledgeNetworkResource($knowledgeNetwork);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeNetworkRequest $request, KnowledgeNetwork $knowledgeNetwork)
    {
        $this->authorize('update', [KnowledgeNetwork::class]);

        $knowledgeNetwork->fieldName = $request->get('fieldName');
        $knowledgeNetwork->fieldName = $request->get('fieldName');
        $knowledgeNetwork->fieldName = $request->get('fieldName');

        $knowledgeNetwork->save();

        return new KnowledgeNetworkResource($knowledgeNetwork);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeNetwork $knowledgeNetwork)
    {
        $this->authorize('delete', [KnowledgeNetwork::class]);

        $knowledgeNetwork->delete();

        return response()->json(null, 204);
    }
}
