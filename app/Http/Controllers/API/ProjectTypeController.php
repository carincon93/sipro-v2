<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectTypeRequest;
use App\Http\Resources\ProjectTypeResource;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectTypeResource::collection(ProjectType::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectTypeRequest $request)
    {
        $this->authorize('create', [ProjectType::class]);

        $projectType = new ProjectType();
        $projectType->fieldName = $request->get('fieldName');
        $projectType->fieldName = $request->get('fieldName');
        $projectType->fieldName = $request->get('fieldName');

        $projectType->save();

        return new ProjectTypeResource($projectType);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectType  $projectType
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectType $projectType)
    {
        $this->authorize('view', [ProjectType::class]);

        return new ProjectTypeResource($projectType);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectType  $projectType
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectTypeRequest $request, ProjectType $projectType)
    {
        $this->authorize('update', [ProjectType::class]);

        $projectType->fieldName = $request->get('fieldName');
        $projectType->fieldName = $request->get('fieldName');
        $projectType->fieldName = $request->get('fieldName');

        $projectType->save();

        return new ProjectTypeResource($projectType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectType  $projectType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectType $projectType)
    {
        $this->authorize('delete', [ProjectType::class]);

        $projectType->delete();

        return response()->json(null, 204);
    }
}
