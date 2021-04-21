<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectAnnexeRequest;
use App\Http\Resources\ProjectAnnexeResource;
use App\Models\ProjectAnnexe;
use Illuminate\Http\Request;

class ProjectAnnexeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectAnnexeResource::collection(ProjectAnnexe::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectAnnexeRequest $request)
    {
        $this->authorize('create', [ProjectAnnexe::class]);

        $projectAnnexe = new ProjectAnnexe();
        $projectAnnexe->fieldName = $request->get('fieldName');
        $projectAnnexe->fieldName = $request->get('fieldName');
        $projectAnnexe->fieldName = $request->get('fieldName');

        $projectAnnexe->save();

        return new ProjectAnnexeResource($projectAnnexe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectAnnexe  $projectAnnexe
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectAnnexe $projectAnnexe)
    {
        $this->authorize('view', [ProjectAnnexe::class]);

        return new ProjectAnnexeResource($projectAnnexe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectAnnexe  $projectAnnexe
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectAnnexeRequest $request, ProjectAnnexe $projectAnnexe)
    {
        $this->authorize('update', [ProjectAnnexe::class]);

        $projectAnnexe->fieldName = $request->get('fieldName');
        $projectAnnexe->fieldName = $request->get('fieldName');
        $projectAnnexe->fieldName = $request->get('fieldName');

        $projectAnnexe->save();

        return new ProjectAnnexeResource($projectAnnexe);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectAnnexe  $projectAnnexe
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectAnnexe $projectAnnexe)
    {
        $this->authorize('delete', [ProjectAnnexe::class]);

        $projectAnnexe->delete();

        return response()->json(null, 204);
    }
}
