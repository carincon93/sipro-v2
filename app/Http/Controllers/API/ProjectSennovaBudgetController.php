<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectSennovaBudgetRequest;
use App\Http\Resources\ProjectSennovaBudgetResource;
use App\Models\ProjectSennovaBudget;
use Illuminate\Http\Request;

class ProjectSennovaBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectSennovaBudgetResource::collection(ProjectSennovaBudget::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectSennovaBudgetRequest $request)
    {
        $this->authorize('create', [ProjectSennovaBudget::class]);

        $projectSennovaBudget = new ProjectSennovaBudget();
        $projectSennovaBudget->fieldName = $request->get('fieldName');
        $projectSennovaBudget->fieldName = $request->get('fieldName');
        $projectSennovaBudget->fieldName = $request->get('fieldName');

        $projectSennovaBudget->save();

        return new ProjectSennovaBudgetResource($projectSennovaBudget);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('view', [ProjectSennovaBudget::class]);

        return new ProjectSennovaBudgetResource($projectSennovaBudget);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectSennovaBudgetRequest $request, ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('update', [ProjectSennovaBudget::class]);

        $projectSennovaBudget->fieldName = $request->get('fieldName');
        $projectSennovaBudget->fieldName = $request->get('fieldName');
        $projectSennovaBudget->fieldName = $request->get('fieldName');

        $projectSennovaBudget->save();

        return new ProjectSennovaBudgetResource($projectSennovaBudget);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectSennovaBudget  $projectSennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectSennovaBudget $projectSennovaBudget)
    {
        $this->authorize('delete', [ProjectSennovaBudget::class]);

        $projectSennovaBudget->delete();

        return response()->json(null, 204);
    }
}
