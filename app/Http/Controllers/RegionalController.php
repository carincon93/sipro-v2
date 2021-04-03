<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegionalRequest;
use App\Models\Regional;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RegionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [Regional::class]);

        return Inertia::render('Regional/Index', [
            'filters'   => request()->all('search'),
            'regional'  => Regional::orderBy('name', 'ASC')
                ->filterRegional(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [Regional::class]);

        return Inertia::render('Regional/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionalRequest $request)
    {
        $this->authorize('create', [Regional::class]);

        $regional = new Regional();
        $regional->name = $request->name;
        $regional->code = $request->code;

        $regional->save();

        return redirect()->route('regional.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function show(Regional $regional)
    {
        $this->authorize('view', [Regional::class, $regional]);

        return Inertia::render('Regional/Show', [
            'regional' => $regional
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function edit(Regional $regional)
    {
        $this->authorize('update', [Regional::class, $regional]);

        return Inertia::render('Regional/Edit', [
            'regional' => $regional
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function update(RegionalRequest $request, Regional $regional)
    {
        $this->authorize('update', [Regional::class, $regional]);

        $regional->name = $request->name;
        $regional->code = $request->code;

        $regional->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Regional  $regional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Regional $regional)
    {
        $this->authorize('delete', [Regional::class, $regional]);

        $regional->delete();

        return redirect()->route('regional.index')->with('success', 'The resource has been deleted successfully.');
    }
}
