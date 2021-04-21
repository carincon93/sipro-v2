<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetUsageRequest;
use App\Http\Resources\BudgetUsageResource;
use App\Models\BudgetUsage;
use Illuminate\Http\Request;

class BudgetUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BudgetUsageResource::collection(BudgetUsage::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BudgetUsageRequest $request)
    {
        $this->authorize('create', [BudgetUsage::class]);

        $budgetUsage = new BudgetUsage();
        $budgetUsage->fieldName = $request->get('fieldName');
        $budgetUsage->fieldName = $request->get('fieldName');
        $budgetUsage->fieldName = $request->get('fieldName');

        $budgetUsage->save();

        return new BudgetUsageResource($budgetUsage);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetUsage  $budgetUsage
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetUsage $budgetUsage)
    {
        $this->authorize('view', [BudgetUsage::class]);

        return new BudgetUsageResource($budgetUsage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetUsage  $budgetUsage
     * @return \Illuminate\Http\Response
     */
    public function update(BudgetUsageRequest $request, BudgetUsage $budgetUsage)
    {
        $this->authorize('update', [BudgetUsage::class]);

        $budgetUsage->fieldName = $request->get('fieldName');
        $budgetUsage->fieldName = $request->get('fieldName');
        $budgetUsage->fieldName = $request->get('fieldName');

        $budgetUsage->save();

        return new BudgetUsageResource($budgetUsage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetUsage  $budgetUsage
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetUsage $budgetUsage)
    {
        $this->authorize('delete', [BudgetUsage::class]);

        $budgetUsage->delete();

        return response()->json(null, 204);
    }
}
