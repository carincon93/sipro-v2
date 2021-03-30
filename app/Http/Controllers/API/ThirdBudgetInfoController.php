<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ThirdBudgetInfoRequest;
use App\Http\Resources\ThirdBudgetInfoResource;
use App\Models\ThirdBudgetInfo;
use Illuminate\Http\Request;

class ThirdBudgetInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ThirdBudgetInfoResource::collection(ThirdBudgetInfo::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThirdBudgetInfoRequest $request)
    {
        $this->authorize('create', [ThirdBudgetInfo::class]);

        $thirdBudgetInfo = new ThirdBudgetInfo();
        $thirdBudgetInfo->fieldName = $request->get('fieldName');
        $thirdBudgetInfo->fieldName = $request->get('fieldName');
        $thirdBudgetInfo->fieldName = $request->get('fieldName');

        $thirdBudgetInfo->save();

        return new ThirdBudgetInfoResource($thirdBudgetInfo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ThirdBudgetInfo  $thirdBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function show(ThirdBudgetInfo $thirdBudgetInfo)
    {
        $this->authorize('view', [ThirdBudgetInfo::class]);

        return new ThirdBudgetInfoResource($thirdBudgetInfo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ThirdBudgetInfo  $thirdBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function update(ThirdBudgetInfoRequest $request, ThirdBudgetInfo $thirdBudgetInfo)
    {
        $this->authorize('update', [ThirdBudgetInfo::class]);

        $thirdBudgetInfo->fieldName = $request->get('fieldName');
        $thirdBudgetInfo->fieldName = $request->get('fieldName');
        $thirdBudgetInfo->fieldName = $request->get('fieldName');

        $thirdBudgetInfo->save();

        return new ThirdBudgetInfoResource($thirdBudgetInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ThirdBudgetInfo  $thirdBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThirdBudgetInfo $thirdBudgetInfo)
    {
        $this->authorize('delete', [ThirdBudgetInfo::class]);

        $thirdBudgetInfo->delete();

        return response()->json(null, 204);
    }
}
