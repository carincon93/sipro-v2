<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResearchTeamRequest;
use App\Http\Resources\ResearchTeamResource;
use App\Models\ResearchTeam;
use Illuminate\Http\Request;

class ResearchTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ResearchTeamResource::collection(ResearchTeam::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResearchTeamRequest $request)
    {
        $this->authorize('create', [ResearchTeam::class]);

        $researchTeam = new ResearchTeam();
        $researchTeam->fieldName = $request->get('fieldName');
        $researchTeam->fieldName = $request->get('fieldName');
        $researchTeam->fieldName = $request->get('fieldName');

        $researchTeam->save();

        return new ResearchTeamResource($researchTeam);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return \Illuminate\Http\Response
     */
    public function show(ResearchTeam $researchTeam)
    {
        $this->authorize('view', [ResearchTeam::class]);

        return new ResearchTeamResource($researchTeam);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return \Illuminate\Http\Response
     */
    public function update(ResearchTeamRequest $request, ResearchTeam $researchTeam)
    {
        $this->authorize('update', [ResearchTeam::class]);

        $researchTeam->fieldName = $request->get('fieldName');
        $researchTeam->fieldName = $request->get('fieldName');
        $researchTeam->fieldName = $request->get('fieldName');

        $researchTeam->save();

        return new ResearchTeamResource($researchTeam);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ResearchTeam  $researchTeam
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResearchTeam $researchTeam)
    {
        $this->authorize('delete', [ResearchTeam::class]);

        $researchTeam->delete();

        return response()->json(null, 204);
    }
}
