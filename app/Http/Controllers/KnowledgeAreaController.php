<?php

namespace App\Http\Controllers;

use App\Http\Requests\KnowledgeAreaRequest;
use App\Models\KnowledgeArea;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KnowledgeAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [KnowledgeArea::class]);

        return Inertia::render('KnowledgeAreas/Index', [
            'filters'   => request()->all('search'),
            'knowledgeAreas' => KnowledgeArea::orderBy('name', 'ASC')
                ->filterKnowledgeArea(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [KnowledgeArea::class]);

        return Inertia::render('KnowledgeAreas/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeAreaRequest $request)
    {
        $this->authorize('create', [KnowledgeArea::class]);

        $knowledgeArea          = new KnowledgeArea();
        $knowledgeArea->name    = $request->name;

        $knowledgeArea->save();

        return redirect()->route('knowledge-areas.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeArea $knowledgeArea)
    {
        $this->authorize('view', [KnowledgeArea::class, $knowledgeArea]);

        return Inertia::render('KnowledgeAreas/Show', [
            'knowledgeArea' => $knowledgeArea
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return \Illuminate\Http\Response
     */
    public function edit(KnowledgeArea $knowledgeArea)
    {
        $this->authorize('update', [KnowledgeArea::class, $knowledgeArea]);

        return Inertia::render('KnowledgeAreas/Edit', [
            'knowledgeArea' => $knowledgeArea
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeAreaRequest $request, KnowledgeArea $knowledgeArea)
    {
        $this->authorize('update', [KnowledgeArea::class, $knowledgeArea]);

        $knowledgeArea->name = $request->name;

        $knowledgeArea->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeArea  $knowledgeArea
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeArea $knowledgeArea)
    {
        $this->authorize('delete', [KnowledgeArea::class, $knowledgeArea]);

        $knowledgeArea->delete();

        return redirect()->route('knowledge-areas.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
