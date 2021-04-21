<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectBudgetBatchRequest;
use App\Http\Resources\ProjectBudgetBatchResource;
use App\Models\ProjectBudgetBatch;
use Illuminate\Http\Request;

class ProjectBudgetBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectBudgetBatchResource::collection(ProjectBudgetBatch::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectBudgetBatchRequest $request)
    {
        $this->authorize('create', [ProjectBudgetBatch::class]);

        $projectBudgetBatch = new ProjectBudgetBatch();
        $projectBudgetBatch->fieldName = $request->get('fieldName');
        $projectBudgetBatch->fieldName = $request->get('fieldName');
        $projectBudgetBatch->fieldName = $request->get('fieldName');

        $projectBudgetBatch->save();

        return new ProjectBudgetBatchResource($projectBudgetBatch);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectBudgetBatch  $projectBudgetBatch
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('view', [ProjectBudgetBatch::class]);

        return new ProjectBudgetBatchResource($projectBudgetBatch);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectBudgetBatch  $projectBudgetBatch
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectBudgetBatchRequest $request, ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('update', [ProjectBudgetBatch::class]);

        $projectBudgetBatch->fieldName = $request->get('fieldName');
        $projectBudgetBatch->fieldName = $request->get('fieldName');
        $projectBudgetBatch->fieldName = $request->get('fieldName');

        $projectBudgetBatch->save();

        return new ProjectBudgetBatchResource($projectBudgetBatch);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectBudgetBatch  $projectBudgetBatch
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectBudgetBatch $projectBudgetBatch)
    {
        $this->authorize('delete', [ProjectBudgetBatch::class]);

        $projectBudgetBatch->delete();

        return response()->json(null, 204);
    }
}
