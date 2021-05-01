<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechnoAcademyRequest;
use App\Models\TechnoAcademy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TechnoAcademyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [TechnoAcademy::class]);

        return Inertia::render('TechnoAcademies/Index', [
            'filters'   => request()->all('search'),
            'technoAcademies' => TechnoAcademy::orderBy('name', 'ASC')
                ->filterTechnoAcademy(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [TechnoAcademy::class]);

        return Inertia::render('TechnoAcademies/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnoAcademyRequest $request)
    {
        $this->authorize('create', [TechnoAcademy::class]);

        $technoAcademy = new TechnoAcademy();
        $technoAcademy->name = $request->name;

        $technoAcademy->save();

        return redirect()->route('techno-academies.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return \Illuminate\Http\Response
     */
    public function show(TechnoAcademy $technoAcademy)
    {
        $this->authorize('view', [TechnoAcademy::class, $technoAcademy]);

        return Inertia::render('TechnoAcademies/Show', [
            'technoAcademy' => $technoAcademy
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return \Illuminate\Http\Response
     */
    public function edit(TechnoAcademy $technoAcademy)
    {
        $this->authorize('update', [TechnoAcademy::class, $technoAcademy]);

        return Inertia::render('TechnoAcademies/Edit', [
            'technoAcademy' => $technoAcademy
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return \Illuminate\Http\Response
     */
    public function update(TechnoAcademyRequest $request, TechnoAcademy $technoAcademy)
    {
        $this->authorize('update', [TechnoAcademy::class, $technoAcademy]);

        $technoAcademy->name = $request->name;

        $technoAcademy->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnoAcademy  $technoAcademy
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnoAcademy $technoAcademy)
    {
        $this->authorize('delete', [TechnoAcademy::class, $technoAcademy]);

        $technoAcademy->delete();

        return redirect()->route('techno-academies.index')->with('success', 'The resource has been deleted successfully.');
    }
}
