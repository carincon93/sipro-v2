<?php

namespace App\Http\Controllers;

use App\Http\Requests\DirectCauseRequest;
use App\Models\Project;
use App\Models\DirectCause;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DirectCauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $this->authorize('viewAny', [DirectCause::class]);

        return Inertia::render('DirectCauses/Index', [
            'filters'   => request()->all('search'),
            'directCauses' => DirectCause::orderBy('description', 'ASC')
                ->filterDirectCause(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $this->authorize('create', [DirectCause::class]);

        return Inertia::render('DirectCauses/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectCauseRequest $request, Project $project)
    {
        $this->authorize('create', [DirectCause::class]);

        $directCause = new DirectCause();
        $directCause->fieldName = $request->fieldName;
        $directCause->fieldName = $request->fieldName;
        $directCause->fieldName = $request->fieldName;

        $directCause->save();

        return redirect()->route('projects.direct-causes.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectCause  $directCause
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, DirectCause $directCause)
    {
        $this->authorize('view', [DirectCause::class, $directCause]);

        return Inertia::render('DirectCauses/Show', [
            'directCause' => $directCause
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DirectCause  $directCause
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, DirectCause $directCause)
    {
        $this->authorize('update', [DirectCause::class, $directCause]);

        return Inertia::render('DirectCauses/Edit', [
            'directCause' => $directCause
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirectCause  $directCause
     * @return \Illuminate\Http\Response
     */
    public function update(DirectCauseRequest $request, Project $project, DirectCause $directCause)
    {
        $this->authorize('update', [DirectCause::class, $directCause]);

        $directCause->fieldName = $request->fieldName;
        $directCause->fieldName = $request->fieldName;
        $directCause->fieldName = $request->fieldName;

        $directCause->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectCause  $directCause
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, DirectCause $directCause)
    {
        $this->authorize('delete', [DirectCause::class, $directCause]);

        $directCause->delete();

        return redirect()->route('projects.direct-causes.index')->with('success', 'The resource has been deleted successfully.');
    }
}
