<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TechnicalCommitteeRequest;
use App\Http\Resources\TechnicalCommitteeResource;
use App\Models\TechnicalCommittee;
use Illuminate\Http\Request;

class TechnicalCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TechnicalCommitteeResource::collection(TechnicalCommittee::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnicalCommitteeRequest $request)
    {
        $this->authorize('create', [TechnicalCommittee::class]);

        $technicalCommittee = new TechnicalCommittee();
        $technicalCommittee->fieldName = $request->get('fieldName');
        $technicalCommittee->fieldName = $request->get('fieldName');
        $technicalCommittee->fieldName = $request->get('fieldName');

        $technicalCommittee->save();

        return new TechnicalCommitteeResource($technicalCommittee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnicalCommittee  $technicalCommittee
     * @return \Illuminate\Http\Response
     */
    public function show(TechnicalCommittee $technicalCommittee)
    {
        $this->authorize('view', [TechnicalCommittee::class]);

        return new TechnicalCommitteeResource($technicalCommittee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnicalCommittee  $technicalCommittee
     * @return \Illuminate\Http\Response
     */
    public function update(TechnicalCommitteeRequest $request, TechnicalCommittee $technicalCommittee)
    {
        $this->authorize('update', [TechnicalCommittee::class]);

        $technicalCommittee->fieldName = $request->get('fieldName');
        $technicalCommittee->fieldName = $request->get('fieldName');
        $technicalCommittee->fieldName = $request->get('fieldName');

        $technicalCommittee->save();

        return new TechnicalCommitteeResource($technicalCommittee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnicalCommittee  $technicalCommittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnicalCommittee $technicalCommittee)
    {
        $this->authorize('delete', [TechnicalCommittee::class]);

        $technicalCommittee->delete();

        return response()->json(null, 204);
    }
}
