<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetProgrammaticLineRequest;
use App\Models\BudgetProgrammaticLine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BudgetProgrammaticLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [BudgetProgrammaticLine::class]);

        return Inertia::render('Budgets/BudgetProgrammaticLines/Index', [
            'filters'   => request()->all('search'),
            'budgetsProgrammaticLines' => BudgetProgrammaticLine::orderBy('', 'ASC')
                ->filterBudgetProgrammaticLine(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [BudgetProgrammaticLine::class]);

        return Inertia::render('Budgets/BudgetProgrammaticLines/Create');
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
        $budgetProgrammaticLine->fieldName = $request->fieldName;
        $budgetProgrammaticLine->fieldName = $request->fieldName;
        $budgetProgrammaticLine->fieldName = $request->fieldName;

        $budgetProgrammaticLine->save();

        return redirect()->route('budgets-programmatic-lines.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return \Illuminate\Http\Response
     */
    public function show(BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        $this->authorize('view', [BudgetProgrammaticLine::class, $budgetProgrammaticLine]);

        return Inertia::render('Budgets/BudgetProgrammaticLines/Show', [
            'budgetProgrammaticLine' => $budgetProgrammaticLine
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        $this->authorize('update', [BudgetProgrammaticLine::class, $budgetProgrammaticLine]);

        return Inertia::render('Budgets/BudgetProgrammaticLines/Edit', [
            'budgetProgrammaticLine' => $budgetProgrammaticLine
        ]);
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
        $this->authorize('update', [BudgetProgrammaticLine::class, $budgetProgrammaticLine]);

        $budgetProgrammaticLine->fieldName = $request->fieldName;
        $budgetProgrammaticLine->fieldName = $request->fieldName;
        $budgetProgrammaticLine->fieldName = $request->fieldName;

        $budgetProgrammaticLine->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BudgetProgrammaticLine  $budgetProgrammaticLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(BudgetProgrammaticLine $budgetProgrammaticLine)
    {
        $this->authorize('delete', [BudgetProgrammaticLine::class, $budgetProgrammaticLine]);

        $budgetProgrammaticLine->delete();

        return redirect()->route('budgets-programmatic-lines.index')->with('success', 'The resource has been deleted successfully.');
    }
}
