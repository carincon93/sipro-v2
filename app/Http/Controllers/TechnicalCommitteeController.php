<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechnicalCommitteeRequest;
use App\Models\TechnicalCommittee;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TechnicalCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [TechnicalCommittee::class]);

        return Inertia::render('TechnicalCommittees/Index', [
            'filters'   => request()->all('search'),
            'technicalCommittees' => TechnicalCommittee::orderBy('name', 'ASC')
                ->filterTechnicalCommittee(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [TechnicalCommittee::class]);

        return Inertia::render('TechnicalCommittees/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TechnicalCommitteeRequest $request)
    {
        $this->authorize('create', [TechnicalCommittee::class]);

        $technicalCommittee = new TechnicalCommittee();
        $technicalCommittee->name = $request->name;

        $technicalCommittee->save();

        return redirect()->route('technical-committees.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TechnicalCommittee  $technicalCommittee
     * @return \Illuminate\Http\Response
     */
    public function show(TechnicalCommittee $technicalCommittee)
    {
        $this->authorize('view', [TechnicalCommittee::class, $technicalCommittee]);

        return Inertia::render('TechnicalCommittees/Show', [
            'technicalCommittee' => $technicalCommittee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TechnicalCommittee  $technicalCommittee
     * @return \Illuminate\Http\Response
     */
    public function edit(TechnicalCommittee $technicalCommittee)
    {
        $this->authorize('update', [TechnicalCommittee::class, $technicalCommittee]);

        return Inertia::render('TechnicalCommittees/Edit', [
            'technicalCommittee' => $technicalCommittee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TechnicalCommittee  $technicalCommittee
     * @return \Illuminate\Http\Response
     */
    public function update(TechnicalCommitteeRequest $request, TechnicalCommittee $technicalCommittee)
    {
        $this->authorize('update', [TechnicalCommittee::class, $technicalCommittee]);

        $technicalCommittee->name = $request->name;

        $technicalCommittee->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TechnicalCommittee  $technicalCommittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(TechnicalCommittee $technicalCommittee)
    {
        $this->authorize('delete', [TechnicalCommittee::class, $technicalCommittee]);

        $technicalCommittee->delete();

        return redirect()->route('technical-committees.index')->with('success', 'The resource has been deleted successfully.');
    }
}
