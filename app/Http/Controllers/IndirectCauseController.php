<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndirectCauseRequest;
use App\Models\DirectCause;
use App\Models\IndirectCause;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndirectCauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DirectCause $directCause)
    {
        $this->authorize('viewAny', [IndirectCause::class]);

        return Inertia::render('IndirectCauses/Index', [
            'filters'   => request()->all('search'),
            'indirectCauses' => IndirectCause::orderBy('description', 'ASC')
                ->filterIndirectCause(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DirectCause $directCause)
    {
        $this->authorize('create', [IndirectCause::class]);

        return Inertia::render('IndirectCauses/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IndirectCauseRequest $request, DirectCause $directCause)
    {
        $this->authorize('create', [IndirectCause::class]);

        $indirectCause = new IndirectCause();
        $indirectCause->fieldName = $request->fieldName;
        $indirectCause->fieldName = $request->fieldName;
        $indirectCause->fieldName = $request->fieldName;

        $indirectCause->save();

        return redirect()->route('projects.indirect-causes.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return \Illuminate\Http\Response
     */
    public function show(DirectCause $directCause, IndirectCause $indirectCause)
    {
        $this->authorize('view', [IndirectCause::class, $indirectCause]);

        return Inertia::render('IndirectCauses/Show', [
            'indirectCause' => $indirectCause
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return \Illuminate\Http\Response
     */
    public function edit(DirectCause $directCause, IndirectCause $indirectCause)
    {
        $this->authorize('update', [IndirectCause::class, $indirectCause]);

        return Inertia::render('IndirectCauses/Edit', [
            'indirectCause' => $indirectCause
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return \Illuminate\Http\Response
     */
    public function update(IndirectCauseRequest $request, DirectCause $directCause, IndirectCause $indirectCause)
    {
        $this->authorize('update', [IndirectCause::class, $indirectCause]);

        $indirectCause->fieldName = $request->fieldName;
        $indirectCause->fieldName = $request->fieldName;
        $indirectCause->fieldName = $request->fieldName;

        $indirectCause->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IndirectCause  $indirectCause
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectCause $directCause, IndirectCause $indirectCause)
    {
        $this->authorize('delete', [IndirectCause::class, $indirectCause]);

        $indirectCause->delete();

        return redirect()->route('projects.indirect-causes.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
