<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectorBasedCommitteeRequest;
use App\Http\Resources\SectorBasedCommitteeResource;
use App\Models\SectorBasedCommittee;
use Illuminate\Http\Request;

class SectorBasedCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SectorBasedCommitteeResource::collection(SectorBasedCommittee::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectorBasedCommitteeRequest $request)
    {
        $this->authorize('create', [SectorBasedCommittee::class]);

        $sectorBasedCommittee = new SectorBasedCommittee();
        $sectorBasedCommittee->fieldName = $request->get('fieldName');
        $sectorBasedCommittee->fieldName = $request->get('fieldName');
        $sectorBasedCommittee->fieldName = $request->get('fieldName');

        $sectorBasedCommittee->save();

        return new SectorBasedCommitteeResource($sectorBasedCommittee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return \Illuminate\Http\Response
     */
    public function show(SectorBasedCommittee $sectorBasedCommittee)
    {
        $this->authorize('view', [SectorBasedCommittee::class]);

        return new SectorBasedCommitteeResource($sectorBasedCommittee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return \Illuminate\Http\Response
     */
    public function update(SectorBasedCommitteeRequest $request, SectorBasedCommittee $sectorBasedCommittee)
    {
        $this->authorize('update', [SectorBasedCommittee::class]);

        $sectorBasedCommittee->fieldName = $request->get('fieldName');
        $sectorBasedCommittee->fieldName = $request->get('fieldName');
        $sectorBasedCommittee->fieldName = $request->get('fieldName');

        $sectorBasedCommittee->save();

        return new SectorBasedCommitteeResource($sectorBasedCommittee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SectorBasedCommittee  $sectorBasedCommittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(SectorBasedCommittee $sectorBasedCommittee)
    {
        $this->authorize('delete', [SectorBasedCommittee::class]);

        $sectorBasedCommittee->delete();

        return response()->json(null, 204);
    }
}
