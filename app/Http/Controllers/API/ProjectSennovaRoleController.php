<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectSennovaRoleRequest;
use App\Http\Resources\ProjectSennovaRoleResource;
use App\Models\ProjectSennovaRole;
use Illuminate\Http\Request;

class ProjectSennovaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectSennovaRoleResource::collection(ProjectSennovaRole::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectSennovaRoleRequest $request)
    {
        $this->authorize('create', [ProjectSennovaRole::class]);

        $projectSennovaRole = new ProjectSennovaRole();
        $projectSennovaRole->fieldName = $request->get('fieldName');
        $projectSennovaRole->fieldName = $request->get('fieldName');
        $projectSennovaRole->fieldName = $request->get('fieldName');

        $projectSennovaRole->save();

        return new ProjectSennovaRoleResource($projectSennovaRole);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectSennovaRole  $projectSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectSennovaRole $projectSennovaRole)
    {
        $this->authorize('view', [ProjectSennovaRole::class]);

        return new ProjectSennovaRoleResource($projectSennovaRole);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectSennovaRole  $projectSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectSennovaRoleRequest $request, ProjectSennovaRole $projectSennovaRole)
    {
        $this->authorize('update', [ProjectSennovaRole::class]);

        $projectSennovaRole->fieldName = $request->get('fieldName');
        $projectSennovaRole->fieldName = $request->get('fieldName');
        $projectSennovaRole->fieldName = $request->get('fieldName');

        $projectSennovaRole->save();

        return new ProjectSennovaRoleResource($projectSennovaRole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectSennovaRole  $projectSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectSennovaRole $projectSennovaRole)
    {
        $this->authorize('delete', [ProjectSennovaRole::class]);

        $projectSennovaRole->delete();

        return response()->json(null, 204);
    }
}
