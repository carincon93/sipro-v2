<?php

namespace App\Http\Controllers;

use App\Http\Requests\CIIUCodeRequest;
use App\Models\CIIUCode;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CIIUCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [CIIUCode::class]);

        return Inertia::render('CIIUCodes/Index', [
            'filters'   => request()->all('search'),
            'cIIUCodes' => CIIUCode::orderBy('name', 'ASC')
                ->filterCIIUCode(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [CIIUCode::class]);

        return Inertia::render('CIIUCodes/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CIIUCodeRequest $request)
    {
        $this->authorize('create', [CIIUCode::class]);

        $ciiuCode = new CIIUCode();
        $ciiuCode->fieldName = $request->fieldName;
        $ciiuCode->fieldName = $request->fieldName;
        $ciiuCode->fieldName = $request->fieldName;

        $ciiuCode->save();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return \Illuminate\Http\Response
     */
    public function show(CIIUCode $ciiuCode)
    {
        $this->authorize('view', [CIIUCode::class, $ciiuCode]);

        return Inertia::render('CIIUCodes/Show', [
            'ciiuCode' => $ciiuCode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return \Illuminate\Http\Response
     */
    public function edit(CIIUCode $ciiuCode)
    {
        $this->authorize('update', [CIIUCode::class, $ciiuCode]);

        return Inertia::render('CIIUCodes/Edit', [
            'ciiuCode' => $ciiuCode
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return \Illuminate\Http\Response
     */
    public function update(CIIUCodeRequest $request, CIIUCode $ciiuCode)
    {
        $this->authorize('update', [CIIUCode::class, $ciiuCode]);

        $ciiuCode->fieldName = $request->fieldName;
        $ciiuCode->fieldName = $request->fieldName;
        $ciiuCode->fieldName = $request->fieldName;

        $ciiuCode->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CIIUCode  $ciiuCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(CIIUCode $ciiuCode)
    {
        $this->authorize('delete', [CIIUCode::class, $ciiuCode]);

        $ciiuCode->delete();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been deleted successfully.');
    }
}
