<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegionalRequest;
use App\Http\Resources\RegionalResource;
use App\Models\Regional;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RegionalResource::collection(Regional::orderBy('name')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionalRequest $request)
    {
        $this->authorize('create', [Regional::class]);

        $regional = new Regional();
        $regional->fieldName = $request->get('fieldName');
        $regional->fieldName = $request->get('fieldName');
        $regional->fieldName = $request->get('fieldName');

        $regional->save();

        return new RegionalResource($regional);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function show(Regional $regional)
    {
        $this->authorize('view', [Regional::class]);

        return new RegionalResource($regional);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function update(RegionalRequest $request, Regional $regional)
    {
        $this->authorize('update', [Regional::class]);

        $regional->fieldName = $request->get('fieldName');
        $regional->fieldName = $request->get('fieldName');
        $regional->fieldName = $request->get('fieldName');

        $regional->save();

        return new RegionalResource($regional);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regional $regional)
    {
        $this->authorize('delete', [Regional::class]);

        $regional->delete();

        return response()->json(null, 204);
    }
}
