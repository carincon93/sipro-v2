<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SennovaRoleRequest;
use App\Http\Resources\SennovaRoleResource;
use App\Models\SennovaRole;
use Illuminate\Http\Request;

class SennovaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SennovaRoleResource::collection(SennovaRole::orderBy('fieldName')->get());
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
        $sennovaRole->fieldName = $request->get('fieldName');
        $sennovaRole->fieldName = $request->get('fieldName');
        $sennovaRole->fieldName = $request->get('fieldName');

        $sennovaRole->save();

        return new SennovaRoleResource($sennovaRole);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SennovaRole  $sennovaRole
     * @return \Illuminate\Http\Response
     */
    public function show(SennovaRole $sennovaRole)
    {
        $this->authorize('view', [SennovaRole::class]);

        return new SennovaRoleResource($sennovaRole);
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
        $this->authorize('update', [SennovaRole::class]);

        $sennovaRole->fieldName = $request->get('fieldName');
        $sennovaRole->fieldName = $request->get('fieldName');
        $sennovaRole->fieldName = $request->get('fieldName');

        $sennovaRole->save();

        return new SennovaRoleResource($sennovaRole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SennovaRole  $sennovaRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(SennovaRole $sennovaRole)
    {
        $this->authorize('delete', [SennovaRole::class]);

        $sennovaRole->delete();

        return response()->json(null, 204);
    }
}
