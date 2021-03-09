<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResearchGroupRequest;
use App\Http\Resources\ResearchGroupResource;
use App\Models\ResearchGroup;
use Illuminate\Http\Request;

class ResearchGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResearchGroupResource::collection(ResearchGroup::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResearchGroupRequest $request)
    {
        $this->authorize('create', [ResearchGroup::class]);

        $researchGroup = new ResearchGroup();
        $researchGroup->fieldName = $request->get('fieldName');
        $researchGroup->fieldName = $request->get('fieldName');
        $researchGroup->fieldName = $request->get('fieldName');

        $researchGroup->save();

        return new ResearchGroupResource($researchGroup);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchGroup $researchGroup)
    {
        $this->authorize('view', [ResearchGroup::class]);

        return new ResearchGroupResource($researchGroup);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return \Illuminate\Http\Response
     */
    public function update(ResearchGroupRequest $request, ResearchGroup $researchGroup)
    {
        $this->authorize('update', [ResearchGroup::class]);

        $researchGroup->fieldName = $request->get('fieldName');
        $researchGroup->fieldName = $request->get('fieldName');
        $researchGroup->fieldName = $request->get('fieldName');

        $researchGroup->save();

        return new ResearchGroupResource($researchGroup);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchGroup  $researchGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchGroup $researchGroup)
    {
        $this->authorize('delete', [ResearchGroup::class]);

        $researchGroup->delete();

        return response()->json(null, 204);
    }
}
