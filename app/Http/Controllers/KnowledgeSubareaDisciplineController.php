<?php

namespace App\Http\Controllers;

use App\Http\Requests\KnowledgeSubareaDisciplineRequest;
use App\Models\KnowledgeSubarea;
use App\Models\KnowledgeSubareaDiscipline;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KnowledgeSubareaDisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [KnowledgeSubareaDiscipline::class]);

        return Inertia::render('KnowledgeSubareaDisciplines/Index', [
            'filters'   => request()->all('search'),
            'knowledgeSubareaDisciplines' => KnowledgeSubareaDiscipline::with(['knowledgeSubarea' => function ($query) {
                $query->orderBy('name', 'ASC');
            }])
                ->filterKnowledgeSubareaDiscipline(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [KnowledgeSubareaDiscipline::class]);

        return Inertia::render('KnowledgeSubareaDisciplines/Create', [
            'knowledgeSubareas' => KnowledgeSubarea::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeSubareaDisciplineRequest $request)
    {
        $this->authorize('create', [KnowledgeSubareaDiscipline::class]);

        $knowledgeSubareaDiscipline = new KnowledgeSubareaDiscipline();
        $knowledgeSubareaDiscipline->name = $request->name;
        $knowledgeSubareaDiscipline->knowledgeSubarea()->associate($request->knowledge_subarea);

        $knowledgeSubareaDiscipline->save();

        return redirect()->route('knowledge-subarea-disciplines.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeSubareaDiscipline  $knowledgeSubareaDiscipline
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeSubareaDiscipline $knowledgeSubareaDiscipline)
    {
        $this->authorize('view', [KnowledgeSubareaDiscipline::class, $knowledgeSubareaDiscipline]);

        return Inertia::render('KnowledgeSubareaDisciplines/Show', [
            'knowledgeSubareaDiscipline' => $knowledgeSubareaDiscipline
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeSubareaDiscipline  $knowledgeSubareaDiscipline
     * @return \Illuminate\Http\Response
     */
    public function edit(KnowledgeSubareaDiscipline $knowledgeSubareaDiscipline)
    {
        $this->authorize('update', [KnowledgeSubareaDiscipline::class, $knowledgeSubareaDiscipline]);

        $selectedKnowledgeSubarea = ['value' => optional($knowledgeSubareaDiscipline->knowledgeSubarea)->id, 'label' => optional($knowledgeSubareaDiscipline->knowledgeSubarea)->name];

        return Inertia::render('KnowledgeSubareaDisciplines/Edit', [
            'knowledgeSubareaDiscipline'    => $knowledgeSubareaDiscipline,
            'knowledgeSubareas'             => KnowledgeSubarea::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
            'selectedKnowledgeSubarea'      => $selectedKnowledgeSubarea
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeSubareaDiscipline  $knowledgeSubareaDiscipline
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeSubareaDisciplineRequest $request, KnowledgeSubareaDiscipline $knowledgeSubareaDiscipline)
    {
        $this->authorize('update', [KnowledgeSubareaDiscipline::class, $knowledgeSubareaDiscipline]);

        $knowledgeSubareaDiscipline->name = $request->name;
        $knowledgeSubareaDiscipline->knowledgeSubarea()->associate($request->knowledge_subarea);

        $knowledgeSubareaDiscipline->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeSubareaDiscipline  $knowledgeSubareaDiscipline
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeSubareaDiscipline $knowledgeSubareaDiscipline)
    {
        $this->authorize('delete', [KnowledgeSubareaDiscipline::class, $knowledgeSubareaDiscipline]);

        $knowledgeSubareaDiscipline->delete();

        return redirect()->route('knowledge-subarea-disciplines.index')->with('success', 'The resource has been deleted successfully.');
    }
}
