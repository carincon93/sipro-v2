<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecondBudgetInfoRequest;
use App\Http\Resources\SecondBudgetInfoResource;
use App\Models\SecondBudgetInfo;
use Illuminate\Http\Request;

class SecondBudgetInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SecondBudgetInfoResource::collection(SecondBudgetInfo::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SecondBudgetInfoRequest $request)
    {
        $this->authorize('create', [SecondBudgetInfo::class]);

        $secondBudgetInfo = new SecondBudgetInfo();
        $secondBudgetInfo->fieldName = $request->get('fieldName');
        $secondBudgetInfo->fieldName = $request->get('fieldName');
        $secondBudgetInfo->fieldName = $request->get('fieldName');

        $secondBudgetInfo->save();

        return new SecondBudgetInfoResource($secondBudgetInfo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SecondBudgetInfo  $secondBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function show(SecondBudgetInfo $secondBudgetInfo)
    {
        $this->authorize('view', [SecondBudgetInfo::class]);

        return new SecondBudgetInfoResource($secondBudgetInfo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SecondBudgetInfo  $secondBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function update(SecondBudgetInfoRequest $request, SecondBudgetInfo $secondBudgetInfo)
    {
        $this->authorize('update', [SecondBudgetInfo::class]);

        $secondBudgetInfo->fieldName = $request->get('fieldName');
        $secondBudgetInfo->fieldName = $request->get('fieldName');
        $secondBudgetInfo->fieldName = $request->get('fieldName');

        $secondBudgetInfo->save();

        return new SecondBudgetInfoResource($secondBudgetInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SecondBudgetInfo  $secondBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(SecondBudgetInfo $secondBudgetInfo)
    {
        $this->authorize('delete', [SecondBudgetInfo::class]);

        $secondBudgetInfo->delete();

        return response()->json(null, 204);
    }
}
