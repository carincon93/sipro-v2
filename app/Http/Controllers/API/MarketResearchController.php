<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketResearchRequest;
use App\Http\Resources\MarketResearchResource;
use App\Models\MarketResearch;
use Illuminate\Http\Request;

class MarketResearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return MarketResearchResource::collection(MarketResearch::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MarketResearchRequest $request)
    {
        $this->authorize('create', [MarketResearch::class]);

        $marketResearch = new MarketResearch();
        $marketResearch->fieldName = $request->get('fieldName');
        $marketResearch->fieldName = $request->get('fieldName');
        $marketResearch->fieldName = $request->get('fieldName');

        $marketResearch->save();

        return new MarketResearchResource($marketResearch);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return \Illuminate\Http\Response
     */
    public function show(MarketResearch $marketResearch)
    {
        $this->authorize('view', [MarketResearch::class]);

        return new MarketResearchResource($marketResearch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return \Illuminate\Http\Response
     */
    public function update(MarketResearchRequest $request, MarketResearch $marketResearch)
    {
        $this->authorize('update', [MarketResearch::class]);

        $marketResearch->fieldName = $request->get('fieldName');
        $marketResearch->fieldName = $request->get('fieldName');
        $marketResearch->fieldName = $request->get('fieldName');

        $marketResearch->save();

        return new MarketResearchResource($marketResearch);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MarketResearch  $marketResearch
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarketResearch $marketResearch)
    {
        $this->authorize('delete', [MarketResearch::class]);

        $marketResearch->delete();

        return response()->json(null, 204);
    }
}
