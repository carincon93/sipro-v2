<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetProgrammaticLineRequest;
use App\Http\Resources\BudgetProgrammaticLineResource;
use App\Models\BudgetProgrammaticLine;
use Illuminate\Http\Request;

class BudgetProgrammaticLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BudgetProgrammaticLineResource::collection(BudgetProgrammaticLine::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BudgetProgrammaticLineRequest $request)
    {
        $this->authorize('create', [BudgetProgrammaticLine::class]);

        $budgetProgrammaticLine = new BudgetProgrammaticLine();
        $budgetProgrammaticLine->fieldName = $request->get('fieldName');
        $budgetProgrammaticLine->fieldName = $request->get('fieldName');
        $budgetProgrammaticLine->fieldName = $request->get('fieldName');

        $budgetProgrammaticLine->save();

        return new BudgetProgrammaticLineResource($budgetProgrammaticLine);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        $this->authorize('view', [BudgetProgrammaticLine::class]);

        return new BudgetProgrammaticLineResource($budgetProgrammaticLine);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return \Illuminate\Http\Response
     */
    public function update(BudgetProgrammaticLineRequest $request, BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        $this->authorize('update', [BudgetProgrammaticLine::class]);

        $budgetProgrammaticLine->fieldName = $request->get('fieldName');
        $budgetProgrammaticLine->fieldName = $request->get('fieldName');
        $budgetProgrammaticLine->fieldName = $request->get('fieldName');

        $budgetProgrammaticLine->save();

        return new BudgetProgrammaticLineResource($budgetProgrammaticLine);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        $this->authorize('delete', [BudgetProgrammaticLine::class]);

        $budgetProgrammaticLine->delete();

        return response()->json(null, 204);
    }
}
