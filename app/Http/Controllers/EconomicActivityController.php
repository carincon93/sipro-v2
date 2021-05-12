<?php

namespace App\Http\Controllers;

use App\Http\Requests\EconomicActivityRequest;
use App\Models\EconomicActivity;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EconomicActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [EconomicActivity::class]);

        return Inertia::render('EconomicActivities/Index', [
            'filters'               => request()->all('search'),
            'economicActivities'    => EconomicActivity::orderBy('name', 'ASC')
                ->filterEconomicActivity(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [EconomicActivity::class]);

        return Inertia::render('EconomicActivities/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EconomicActivityRequest $request)
    {
        $this->authorize('create', [EconomicActivity::class]);

        $economicActivity = new EconomicActivity();
        $economicActivity->fieldName = $request->fieldName;
        $economicActivity->fieldName = $request->fieldName;
        $economicActivity->fieldName = $request->fieldName;

        $economicActivity->save();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return \Illuminate\Http\Response
     */
    public function show(EconomicActivity $economicActivity)
    {
        $this->authorize('view', [EconomicActivity::class, $economicActivity]);

        return Inertia::render('EconomicActivities/Show', [
            'economicActivity' => $economicActivity
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(EconomicActivity $economicActivity)
    {
        $this->authorize('update', [EconomicActivity::class, $economicActivity]);

        return Inertia::render('EconomicActivities/Edit', [
            'economicActivity' => $economicActivity
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return \Illuminate\Http\Response
     */
    public function update(EconomicActivityRequest $request, EconomicActivity $economicActivity)
    {
        $this->authorize('update', [EconomicActivity::class, $economicActivity]);

        $economicActivity->fieldName = $request->fieldName;
        $economicActivity->fieldName = $request->fieldName;
        $economicActivity->fieldName = $request->fieldName;

        $economicActivity->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EconomicActivity  $economicActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(EconomicActivity $economicActivity)
    {
        $this->authorize('delete', [EconomicActivity::class, $economicActivity]);

        $economicActivity->delete();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been deleted successfully.');
    }
}
