<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnexeRequest;
use App\Models\Call;
use App\Models\Project;
use App\Models\Annexe;
use App\Models\ProgrammaticLine;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AnnexeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [Annexe::class]);

        return Inertia::render('Annexes/Index', [
            'filters'   => request()->all('search'),
            'annexes'   => Annexe::orderBy('name', 'ASC')
                ->filterAnnexe(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [Annexe::class]);

        return Inertia::render('Annexes/Create', [
            'programmaticLines' => ProgrammaticLine::orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnexeRequest $request)
    {
        $this->authorize('create', [Annexe::class]);

        $annexe = new Annexe();
        $annexe->name           = $request->name;
        $annexe->description    = $request->description;

        $annexe->save();

        $annexe->programmaticLines()->attach($request->programmatic_line_id);


        return redirect()->route('annexes.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function show(Annexe $annexe)
    {
        $this->authorize('view', [Annexe::class, $annexe]);

        return Inertia::render('Annexes/Show', [
            'annexe' => $annexe
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function edit(Annexe $annexe)
    {
        $this->authorize('update', [Annexe::class, $annexe]);

        return Inertia::render('Annexes/Edit', [
            'annexe'                    => $annexe,
            'programmaticLines'         => ProgrammaticLine::orderBy('name', 'ASC')->get(),
            'annexeProgrammaticLines'   => $annexe->programmaticLines()->pluck('id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function update(AnnexeRequest $request, Annexe $annexe)
    {
        $this->authorize('update', [Annexe::class, $annexe]);

        $annexe->name           = $request->name;
        $annexe->description    = $request->description;
        $annexe->programmaticLines()->sync($request->programmatic_line_id);

        $annexe->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annexe $annexe)
    {
        $this->authorize('delete', [Annexe::class, $annexe]);

        $annexe->delete();

        return redirect()->route('annexes.index')->with('success', 'The resource has been deleted successfully.');
    }
}
