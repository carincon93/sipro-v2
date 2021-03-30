<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CallBudgetRequest;
use App\Http\Resources\CallBudgetResource;
use App\Models\CallBudget;
use Illuminate\Http\Request;

class CallBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CallBudgetResource::collection(CallBudget::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CallBudgetRequest $request)
    {
        $this->authorize('create', [CallBudget::class]);

        $callBudget = new CallBudget();
        $callBudget->fieldName = $request->get('fieldName');
        $callBudget->fieldName = $request->get('fieldName');
        $callBudget->fieldName = $request->get('fieldName');

        $callBudget->save();

        return new CallBudgetResource($callBudget);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CallBudget  $callBudget
     * @return \Illuminate\Http\Response
     */
    public function show(CallBudget $callBudget)
    {
        $this->authorize('view', [CallBudget::class]);

        return new CallBudgetResource($callBudget);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CallBudget  $callBudget
     * @return \Illuminate\Http\Response
     */
    public function update(CallBudgetRequest $request, CallBudget $callBudget)
    {
        $this->authorize('update', [CallBudget::class]);

        $callBudget->fieldName = $request->get('fieldName');
        $callBudget->fieldName = $request->get('fieldName');
        $callBudget->fieldName = $request->get('fieldName');

        $callBudget->save();

        return new CallBudgetResource($callBudget);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CallBudget  $callBudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(CallBudget $callBudget)
    {
        $this->authorize('delete', [CallBudget::class]);

        $callBudget->delete();

        return response()->json(null, 204);
    }
}
