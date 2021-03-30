<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectEffectRequest;
use App\Models\Project;
use App\Models\DirectEffect;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DirectEffectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $this->authorize('viewAny', [DirectEffect::class]);

        return Inertia::render('DirectEffects/Index', [
            'filters'   => request()->all('search'),
            'directEffects' => DirectEffect::orderBy('description', 'ASC')
                ->filterDirectEffect(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $this->authorize('create', [DirectEffect::class]);

        return Inertia::render('DirectEffects/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectEffectRequest $request, Project $project)
    {
        $this->authorize('create', [DirectEffect::class]);

        $directEffect = new DirectEffect();
        $directEffect->fieldName = $request->fieldName;
        $directEffect->fieldName = $request->fieldName;
        $directEffect->fieldName = $request->fieldName;

        $directEffect->save();

        return redirect()->route('projects.direct-effects.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectEffect  $directEffect
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, DirectEffect $directEffect)
    {
        $this->authorize('view', [DirectEffect::class, $directEffect]);

        return Inertia::render('DirectEffects/Show', [
            'directEffect' => $directEffect
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectEffect  $directEffect
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, DirectEffect $directEffect)
    {
        $this->authorize('update', [DirectEffect::class, $directEffect]);

        return Inertia::render('DirectEffects/Edit', [
            'directEffect' => $directEffect
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirectEffect  $directEffect
     * @return \Illuminate\Http\Response
     */
    public function update(DirectEffectRequest $request, Project $project, DirectEffect $directEffect)
    {
        $this->authorize('update', [DirectEffect::class, $directEffect]);

        $directEffect->fieldName = $request->fieldName;
        $directEffect->fieldName = $request->fieldName;
        $directEffect->fieldName = $request->fieldName;

        $directEffect->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectEffect  $directEffect
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, DirectEffect $directEffect)
    {
        $this->authorize('delete', [DirectEffect::class, $directEffect]);

        $directEffect->delete();

        return redirect()->route('projects.direct-effects.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
