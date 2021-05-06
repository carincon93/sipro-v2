<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgrammaticLineRequest;
use App\Models\ProgrammaticLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProgrammaticLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [ProgrammaticLine::class]);

        return Inertia::render('ProgrammaticLines/Index', [
            'filters'   => request()->all('search'),
            'programmaticLines' => ProgrammaticLine::orderBy('name', 'ASC')
                ->filterProgrammaticLine(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [ProgrammaticLine::class]);

        return Inertia::render('ProgrammaticLines/Create', [
            'projectCategories' => json_decode(Storage::get('json/project-categories.json'), true),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgrammaticLineRequest $request)
    {
        $this->authorize('create', [ProgrammaticLine::class]);

        $programmaticLine = new ProgrammaticLine();
        $programmaticLine->name             = $request->name;
        $programmaticLine->code             = $request->code;
        $programmaticLine->project_category = $request->project_category;
        $programmaticLine->description      = $request->description;

        $programmaticLine->save();

        return redirect()->route('programmatic-lines.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return \Illuminate\Http\Response
     */
    public function show(ProgrammaticLine $programmaticLine)
    {
        $this->authorize('view', [ProgrammaticLine::class, $programmaticLine]);

        return Inertia::render('ProgrammaticLines/Show', [
            'programmaticLine' => $programmaticLine
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgrammaticLine $programmaticLine)
    {
        $this->authorize('update', [ProgrammaticLine::class, $programmaticLine]);

        return Inertia::render('ProgrammaticLines/Edit', [
            'programmaticLine'          => $programmaticLine->only('id', 'name', 'description', 'code', 'project_category', 'description'),
            'projectCategories'         => json_decode(Storage::get('json/project-categories.json'), true),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return \Illuminate\Http\Response
     */
    public function update(ProgrammaticLineRequest $request, ProgrammaticLine $programmaticLine)
    {
        $this->authorize('update', [ProgrammaticLine::class, $programmaticLine]);

        $programmaticLine->name             = $request->name;
        $programmaticLine->code             = $request->code;
        $programmaticLine->project_category = $request->project_category;
        $programmaticLine->description      = $request->description;

        $programmaticLine->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgrammaticLine  $programmaticLine
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgrammaticLine $programmaticLine)
    {
        $this->authorize('delete', [ProgrammaticLine::class, $programmaticLine]);

        $programmaticLine->delete();

        return redirect()->route('programmatic-lines.index')->with('success', 'The resource has been deleted successfully.');
    }
}
