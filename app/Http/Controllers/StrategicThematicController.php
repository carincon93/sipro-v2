<?php

namespace App\Http\Controllers;

use App\Http\Requests\StrategicThematicRequest;
use App\Models\StrategicThematic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StrategicThematicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [StrategicThematic::class]);

        return Inertia::render('StrategicThematics/Index', [
            'filters'   => request()->all('search'),
            'strategicThematics' => StrategicThematic::orderBy('name', 'ASC')
                ->filterStrategicThematic(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [StrategicThematic::class]);

        return Inertia::render('StrategicThematics/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StrategicThematicRequest $request)
    {
        $this->authorize('create', [StrategicThematic::class]);

        $strategicThematic = new StrategicThematic();
        $strategicThematic->name = $request->name;

        $strategicThematic->save();

        return redirect()->route('strategic-thematics.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return \Illuminate\Http\Response
     */
    public function show(StrategicThematic $strategicThematic)
    {
        $this->authorize('view', [StrategicThematic::class, $strategicThematic]);

        return Inertia::render('StrategicThematics/Show', [
            'strategicThematic' => $strategicThematic
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return \Illuminate\Http\Response
     */
    public function edit(StrategicThematic $strategicThematic)
    {
        $this->authorize('update', [StrategicThematic::class, $strategicThematic]);

        return Inertia::render('StrategicThematics/Edit', [
            'strategicThematic' => $strategicThematic
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return \Illuminate\Http\Response
     */
    public function update(StrategicThematicRequest $request, StrategicThematic $strategicThematic)
    {
        $this->authorize('update', [StrategicThematic::class, $strategicThematic]);

        $strategicThematic->name = $request->name;

        $strategicThematic->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return \Illuminate\Http\Response
     */
    public function destroy(StrategicThematic $strategicThematic)
    {
        $this->authorize('delete', [StrategicThematic::class, $strategicThematic]);

        $strategicThematic->delete();

        return redirect()->route('strategic-thematics.index')->with('success', 'The resource has been deleted successfully.');
    }
}
