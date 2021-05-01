<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechnologicalLineRequest;
use App\Models\TechnologicalLine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TechnologicalLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [TechnologicalLine::class]);

        return Inertia::render('TechnologicalLines/Index', [
            'filters'   => request()->all('search'),
            'technologicalLines' => TechnologicalLine::orderBy('name', 'ASC')
                ->filterTechnologicalLine(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [TechnologicalLine::class]);

        return Inertia::render('TechnologicalLines/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnologicalLineRequest $request)
    {
        $this->authorize('create', [TechnologicalLine::class]);

        $technologicalLine = new TechnologicalLine();
        $technologicalLine->name = $request->name;

        $technologicalLine->save();

        return redirect()->route('technological-lines.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return \Illuminate\Http\Response
     */
    public function show(TechnologicalLine $technologicalLine)
    {
        $this->authorize('view', [TechnologicalLine::class, $technologicalLine]);

        return Inertia::render('TechnologicalLines/Show', [
            'technologicalLine' => $technologicalLine
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return \Illuminate\Http\Response
     */
    public function edit(TechnologicalLine $technologicalLine)
    {
        $this->authorize('update', [TechnologicalLine::class, $technologicalLine]);

        return Inertia::render('TechnologicalLines/Edit', [
            'technologicalLine' => $technologicalLine
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return \Illuminate\Http\Response
     */
    public function update(TechnologicalLineRequest $request, TechnologicalLine $technologicalLine)
    {
        $this->authorize('update', [TechnologicalLine::class, $technologicalLine]);

        $technologicalLine->name = $request->name;

        $technologicalLine->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnologicalLine  $technologicalLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnologicalLine $technologicalLine)
    {
        $this->authorize('delete', [TechnologicalLine::class, $technologicalLine]);

        $technologicalLine->delete();

        return redirect()->route('technological-lines.index')->with('success', 'The resource has been deleted successfully.');
    }
}
