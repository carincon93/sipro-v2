<?php

namespace App\Http\Controllers;

use App\Http\Requests\SennovaRoleRequest;
use App\Models\SennovaRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'sennovaRoles' => SennovaRole::selectRaw("id, CASE academic_degree
                WHEN '0' THEN	concat(name, ' - Nivel académico: Ninguno')
                WHEN '1' THEN	concat(name, ' - Nivel académico: Técnico')
                WHEN '2' THEN	concat(name, ' - Nivel académico: Tecnólogo')
                WHEN '3' THEN	concat(name, ' - Nivel académico: Pregrado')
                WHEN '4' THEN	concat(name, ' - Nivel académico: Especalización')
                WHEN '5' THEN	concat(name, ' - Nivel académico: Maestría')
                WHEN '6' THEN	concat(name, ' - Nivel académico: Doctorado')
            END as name")->orderBy('name', 'ASC')
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

        return Inertia::render('SennovaRoles/Create', [
            'academicDegrees' => json_decode(Storage::get('json/academic-degrees.json'), true)
        ]);
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
        $sennovaRole->name              = $request->name;
        $sennovaRole->description       = $request->description;
        $sennovaRole->academic_degree   = $request->academic_degree;
        $sennovaRole->programmaticLine()->associate($request->programmatic_line_id);

        $sennovaRole->save();

        return redirect()->route('sennova-roles.index')->with('success', 'The resource has been created successfully.');
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
            'sennovaRole'       => $sennovaRole,
            'academicDegrees'   => json_decode(Storage::get('json/academic-degrees.json'), true)
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

        $sennovaRole->name              = $request->name;
        $sennovaRole->description       = $request->description;
        $sennovaRole->academic_degree   = $request->academic_degree;
        $sennovaRole->programmaticLine()->associate($request->programmatic_line_id);

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

        return redirect()->route('sennova-roles.index')->with('success', 'The resource has been deleted successfully.');
    }
}
