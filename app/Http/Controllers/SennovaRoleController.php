<?php

namespace App\Http\Controllers;

use App\Http\Requests\SennovaRoleRequest;
use App\Models\SennovaRole;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SennovaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [SennovaRole::class]);

        return Inertia::render('SennovaRoles/Index', [
            'filters'   => request()->all('search'),
            'sennovaRoles' => SennovaRole::orderBy('', 'ASC')
                ->filterSennovaRole(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [SennovaRole::class]);

        return Inertia::render('SennovaRoles/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SennovaRoleRequest $request)
    {
        $this->authorize('create', [SennovaRole::class]);

        $sennovaRole = new SennovaRole();
        $sennovaRole->fieldName = $request->fieldName;
        $sennovaRole->fieldName = $request->fieldName;
        $sennovaRole->fieldName = $request->fieldName;

        $sennovaRole->save();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SennovaRole  $sennovaRole
     * @return \Illuminate\Http\Response
     */
    public function show(SennovaRole $sennovaRole)
    {
        $this->authorize('view', [SennovaRole::class, $sennovaRole]);

        return Inertia::render('SennovaRoles/Show', [
            'sennovaRole' => $sennovaRole
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SennovaRole  $sennovaRole
     * @return \Illuminate\Http\Response
     */
    public function edit(SennovaRole $sennovaRole)
    {
        $this->authorize('update', [SennovaRole::class, $sennovaRole]);

        return Inertia::render('SennovaRoles/Edit', [
            'sennovaRole' => $sennovaRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SennovaRole  $sennovaRole
     * @return \Illuminate\Http\Response
     */
    public function update(SennovaRoleRequest $request, SennovaRole $sennovaRole)
    {
        $this->authorize('update', [SennovaRole::class, $sennovaRole]);

        $sennovaRole->fieldName = $request->fieldName;
        $sennovaRole->fieldName = $request->fieldName;
        $sennovaRole->fieldName = $request->fieldName;

        $sennovaRole->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SennovaRole  $sennovaRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(SennovaRole $sennovaRole)
    {
        $this->authorize('delete', [SennovaRole::class, $sennovaRole]);

        $sennovaRole->delete();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been deleted successfully.');
    }
}
