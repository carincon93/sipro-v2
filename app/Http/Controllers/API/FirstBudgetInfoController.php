<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\FirstBudgetInfoRequest;
use App\Http\Resources\FirstBudgetInfoResource;
use App\Models\FirstBudgetInfo;
use Illuminate\Http\Request;

class FirstBudgetInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FirstBudgetInfoResource::collection(FirstBudgetInfo::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FirstBudgetInfoRequest $request)
    {
        $this->authorize('create', [FirstBudgetInfo::class]);

        $firstBudgetInfo = new FirstBudgetInfo();
        $firstBudgetInfo->fieldName = $request->get('fieldName');
        $firstBudgetInfo->fieldName = $request->get('fieldName');
        $firstBudgetInfo->fieldName = $request->get('fieldName');

        $firstBudgetInfo->save();

        return new FirstBudgetInfoResource($firstBudgetInfo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FirstBudgetInfo  $firstBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function show(FirstBudgetInfo $firstBudgetInfo)
    {
        $this->authorize('view', [FirstBudgetInfo::class]);

        return new FirstBudgetInfoResource($firstBudgetInfo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FirstBudgetInfo  $firstBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function update(FirstBudgetInfoRequest $request, FirstBudgetInfo $firstBudgetInfo)
    {
        $this->authorize('update', [FirstBudgetInfo::class]);

        $firstBudgetInfo->fieldName = $request->get('fieldName');
        $firstBudgetInfo->fieldName = $request->get('fieldName');
        $firstBudgetInfo->fieldName = $request->get('fieldName');

        $firstBudgetInfo->save();

        return new FirstBudgetInfoResource($firstBudgetInfo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FirstBudgetInfo  $firstBudgetInfo
     * @return \Illuminate\Http\Response
     */
    public function destroy(FirstBudgetInfo $firstBudgetInfo)
    {
        $this->authorize('delete', [FirstBudgetInfo::class]);

        $firstBudgetInfo->delete();

        return response()->json(null, 204);
    }
}
