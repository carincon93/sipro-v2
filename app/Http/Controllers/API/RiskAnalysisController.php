<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RiskAnalysisRequest;
use App\Http\Resources\RiskAnalysisResource;
use App\Models\RiskAnalysis;
use Illuminate\Http\Request;

class RiskAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RiskAnalysisResource::collection(RiskAnalysis::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RiskAnalysisRequest $request)
    {
        $this->authorize('create', [RiskAnalysis::class]);

        $riskAnalysis = new RiskAnalysis();
        $riskAnalysis->fieldName = $request->get('fieldName');
        $riskAnalysis->fieldName = $request->get('fieldName');
        $riskAnalysis->fieldName = $request->get('fieldName');

        $riskAnalysis->save();

        return new RiskAnalysisResource($riskAnalysis);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RiskAnalysis  $riskAnalysis
     * @return \Illuminate\Http\Response
     */
    public function show(RiskAnalysis $riskAnalysis)
    {
        $this->authorize('view', [RiskAnalysis::class]);

        return new RiskAnalysisResource($riskAnalysis);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RiskAnalysis  $riskAnalysis
     * @return \Illuminate\Http\Response
     */
    public function update(RiskAnalysisRequest $request, RiskAnalysis $riskAnalysis)
    {
        $this->authorize('update', [RiskAnalysis::class]);

        $riskAnalysis->fieldName = $request->get('fieldName');
        $riskAnalysis->fieldName = $request->get('fieldName');
        $riskAnalysis->fieldName = $request->get('fieldName');

        $riskAnalysis->save();

        return new RiskAnalysisResource($riskAnalysis);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RiskAnalysis  $riskAnalysis
     * @return \Illuminate\Http\Response
     */
    public function destroy(RiskAnalysis $riskAnalysis)
    {
        $this->authorize('delete', [RiskAnalysis::class]);

        $riskAnalysis->delete();

        return response()->json(null, 204);
    }
}
