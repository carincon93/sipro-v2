<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectSennovaRoleRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\ProjectSennovaRole;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectSennovaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, Project $project)
    {
        $this->authorize('viewAny', [ProjectSennovaRole::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaRoles/Index', [
            'call'      => $call,
            'project'   => $project,
            'filters'   => request()->all('search'),
            'projectSennovaRoles' => ProjectSennovaRole::where('project_id', $project->id)->filterProjectSennovaRole(request()->only('search'))->with('callSennovaRole.sennovaRole')->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, Project $project)
    {
        $this->authorize('create', [ProjectSennovaRole::class]);

        return Inertia::render('Calls/Projects/ProjectSennovaRoles/Create');
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
        $projectSennovaRole->fieldName = $request->fieldName;
        $projectSennovaRole->fieldName = $request->fieldName;
        $projectSennovaRole->fieldName = $request->fieldName;

        $projectSennovaRole->save();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectSennovaRole  $projectSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, Project $project, ProjectSennovaRole $projectSennovaRole)
    {
        $this->authorize('view', [ProjectSennovaRole::class, $projectSennovaRole]);

        return Inertia::render('Calls/Projects/ProjectSennovaRoles/Show', [
            'projectSennovaRole' => $projectSennovaRole
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectSennovaRole  $projectSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, Project $project, ProjectSennovaRole $projectSennovaRole)
    {
        $this->authorize('update', [ProjectSennovaRole::class, $projectSennovaRole]);

        return Inertia::render('Calls/Projects/ProjectSennovaRoles/Edit', [
            'projectSennovaRole' => $projectSennovaRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectSennovaRole  $projectSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectSennovaRoleRequest $request, Call $call, Project $project, ProjectSennovaRole $projectSennovaRole)
    {
        $this->authorize('update', [ProjectSennovaRole::class, $projectSennovaRole]);

        $projectSennovaRole->fieldName = $request->fieldName;
        $projectSennovaRole->fieldName = $request->fieldName;
        $projectSennovaRole->fieldName = $request->fieldName;

        $projectSennovaRole->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectSennovaRole  $projectSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, Project $project, ProjectSennovaRole $projectSennovaRole)
    {
        $this->authorize('delete', [ProjectSennovaRole::class, $projectSennovaRole]);

        $projectSennovaRole->delete();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been deleted successfully.');
    }
}
