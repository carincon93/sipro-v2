<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThematicStrategyRequest;
use App\Http\Resources\ThematicStrategyResource;
use App\Models\ThematicStrategy;
use Illuminate\Http\Request;

class ThematicStrategyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ThematicStrategyResource::collection(ThematicStrategy::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThematicStrategyRequest $request)
    {
        $this->authorize('create', [ThematicStrategy::class]);

        $thematicStrategy = new ThematicStrategy();
        $thematicStrategy->fieldName = $request->get('fieldName');
        $thematicStrategy->fieldName = $request->get('fieldName');
        $thematicStrategy->fieldName = $request->get('fieldName');

        $thematicStrategy->save();

        return new ThematicStrategyResource($thematicStrategy);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThematicStrategy  $thematicStrategy
     * @return \Illuminate\Http\Response
     */
    public function show(ThematicStrategy $thematicStrategy)
    {
        $this->authorize('view', [ThematicStrategy::class]);

        return new ThematicStrategyResource($thematicStrategy);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThematicStrategy  $thematicStrategy
     * @return \Illuminate\Http\Response
     */
    public function update(ThematicStrategyRequest $request, ThematicStrategy $thematicStrategy)
    {
        $this->authorize('update', [ThematicStrategy::class]);

        $thematicStrategy->fieldName = $request->get('fieldName');
        $thematicStrategy->fieldName = $request->get('fieldName');
        $thematicStrategy->fieldName = $request->get('fieldName');

        $thematicStrategy->save();

        return new ThematicStrategyResource($thematicStrategy);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThematicStrategy  $thematicStrategy
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThematicStrategy $thematicStrategy)
    {
        $this->authorize('delete', [ThematicStrategy::class]);

        $thematicStrategy->delete();

        return response()->json(null, 204);
    }
}
