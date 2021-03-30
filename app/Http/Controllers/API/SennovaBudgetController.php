<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SennovaBudgetRequest;
use App\Http\Resources\SennovaBudgetResource;
use App\Models\SennovaBudget;
use Illuminate\Http\Request;

class SennovaBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SennovaBudgetResource::collection(SennovaBudget::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SennovaBudgetRequest $request)
    {
        $this->authorize('create', [SennovaBudget::class]);

        $sennovaBudget = new SennovaBudget();
        $sennovaBudget->fieldName = $request->get('fieldName');
        $sennovaBudget->fieldName = $request->get('fieldName');
        $sennovaBudget->fieldName = $request->get('fieldName');

        $sennovaBudget->save();

        return new SennovaBudgetResource($sennovaBudget);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SennovaBudget  $sennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function show(SennovaBudget $sennovaBudget)
    {
        $this->authorize('view', [SennovaBudget::class]);

        return new SennovaBudgetResource($sennovaBudget);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SennovaBudget  $sennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function update(SennovaBudgetRequest $request, SennovaBudget $sennovaBudget)
    {
        $this->authorize('update', [SennovaBudget::class]);

        $sennovaBudget->fieldName = $request->get('fieldName');
        $sennovaBudget->fieldName = $request->get('fieldName');
        $sennovaBudget->fieldName = $request->get('fieldName');

        $sennovaBudget->save();

        return new SennovaBudgetResource($sennovaBudget);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SennovaBudget  $sennovaBudget
     * @return \Illuminate\Http\Response
     */
    public function destroy(SennovaBudget $sennovaBudget)
    {
        $this->authorize('delete', [SennovaBudget::class]);

        $sennovaBudget->delete();

        return response()->json(null, 204);
    }
}
