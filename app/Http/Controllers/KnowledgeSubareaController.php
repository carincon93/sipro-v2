<?php

namespace App\Http\Controllers;

use App\Http\Requests\KnowledgeSubareaRequest;
use App\Models\KnowledgeArea;
use App\Models\KnowledgeSubarea;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KnowledgeSubareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [KnowledgeSubarea::class]);

        return Inertia::render('KnowledgeSubareas/Index', [
            'filters'   => request()->all('search'),
            'knowledgeSubareas' => KnowledgeSubarea::with(['knowledgeArea' => function ($query) {
                $query->orderBy('name', 'ASC');
            }])
            ->filterKnowledgeSubarea(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [KnowledgeSubarea::class]);

        return Inertia::render('KnowledgeSubareas/Create', [
            'knowledgeAreas' => KnowledgeArea::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeSubareaRequest $request)
    {
        $this->authorize('create', [KnowledgeSubarea::class]);

        $knowledgeSubarea = new KnowledgeSubarea();
        $knowledgeSubarea->name = $request->name;
        $knowledgeSubarea->knowledgeArea()->associate($request->knowledge_area_id);

        $knowledgeSubarea->save();

        return redirect()->route('knowledge-subareas.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeSubarea  $knowledgeSubarea
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeSubarea $knowledgeSubarea)
    {
        $this->authorize('view', [KnowledgeSubarea::class, $knowledgeSubarea]);

        return Inertia::render('KnowledgeSubareas/Show', [
            'knowledgeSubarea' => $knowledgeSubarea
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeSubarea  $knowledgeSubarea
     * @return \Illuminate\Http\Response
     */
    public function edit(KnowledgeSubarea $knowledgeSubarea)
    {
        $this->authorize('update', [KnowledgeSubarea::class, $knowledgeSubarea]);

        return Inertia::render('KnowledgeSubareas/Edit', [
            'knowledgeSubarea'      => $knowledgeSubarea,
            'knowledgeAreas'        => KnowledgeArea::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeSubarea  $knowledgeSubarea
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeSubareaRequest $request, KnowledgeSubarea $knowledgeSubarea)
    {
        $this->authorize('update', [KnowledgeSubarea::class, $knowledgeSubarea]);

        $knowledgeSubarea->name = $request->name;
        $knowledgeSubarea->knowledgeArea()->associate($request->knowledge_area_id);

        $knowledgeSubarea->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeSubarea  $knowledgeSubarea
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeSubarea $knowledgeSubarea)
    {
        $this->authorize('delete', [KnowledgeSubarea::class, $knowledgeSubarea]);

        $knowledgeSubarea->delete();

        return redirect()->route('knowledge-subareas.index')->with('success', 'The resource has been deleted successfully.');
    }
}
