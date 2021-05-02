<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectResource::collection(Project::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $this->authorize('create', [Project::class]);

        $projectResult = new Project();
        $projectResult->fieldName = $request->get('fieldName');
        $projectResult->fieldName = $request->get('fieldName');
        $projectResult->fieldName = $request->get('fieldName');

        $projectResult->save();

        return new ProjectResource($projectResult);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $projectResult
     * @return \Illuminate\Http\Response
     */
    public function show(Project $projectResult)
    {
        $this->authorize('view', [Project::class]);

        return new ProjectResource($projectResult);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $projectResult
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $projectResult)
    {
        $this->authorize('update', [Project::class]);

        $projectResult->fieldName = $request->get('fieldName');
        $projectResult->fieldName = $request->get('fieldName');
        $projectResult->fieldName = $request->get('fieldName');

        $projectResult->save();

        return new ProjectResource($projectResult);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $projectResult
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $projectResult)
    {
        $this->authorize('delete', [Project::class]);

        $projectResult->delete();

        return response()->json(null, 204);
    }
}
