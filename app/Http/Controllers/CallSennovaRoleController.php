<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallSennovaRoleRequest;
use App\Models\CallSennovaRole;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CallSennovaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [CallSennovaRole::class]);

        return Inertia::render('CallSennovaRoles/Index', [
            'filters'   => request()->all('search'),
            'callSennovaRoles' => CallSennovaRole::orderBy('', 'ASC')
                ->filterCallSennovaRole(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [CallSennovaRole::class]);

        return Inertia::render('CallSennovaRoles/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CallSennovaRoleRequest $request)
    {
        $this->authorize('create', [CallSennovaRole::class]);

        $callSennovaRole = new CallSennovaRole();
        $callSennovaRole->fieldName = $request->fieldName;
        $callSennovaRole->fieldName = $request->fieldName;
        $callSennovaRole->fieldName = $request->fieldName;

        $callSennovaRole->save();

        return redirect()->route('resourceRoute.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CallSennovaRole  $callSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function show(CallSennovaRole $callSennovaRole)
    {
        $this->authorize('view', [CallSennovaRole::class, $callSennovaRole]);

        return Inertia::render('CallSennovaRoles/Show', [
            'callSennovaRole' => $callSennovaRole
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CallSennovaRole  $callSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function edit(CallSennovaRole $callSennovaRole)
    {
        $this->authorize('update', [CallSennovaRole::class, $callSennovaRole]);

        return Inertia::render('CallSennovaRoles/Edit', [
            'callSennovaRole' => $callSennovaRole
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CallSennovaRole  $callSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function update(CallSennovaRoleRequest $request, CallSennovaRole $callSennovaRole)
    {
        $this->authorize('update', [CallSennovaRole::class, $callSennovaRole]);

        $callSennovaRole->fieldName = $request->fieldName;
        $callSennovaRole->fieldName = $request->fieldName;
        $callSennovaRole->fieldName = $request->fieldName;

        $callSennovaRole->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CallSennovaRole  $callSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(CallSennovaRole $callSennovaRole)
    {
        $this->authorize('delete', [CallSennovaRole::class, $callSennovaRole]);

        $callSennovaRole->delete();

        return redirect()->route('resourceRoute.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
