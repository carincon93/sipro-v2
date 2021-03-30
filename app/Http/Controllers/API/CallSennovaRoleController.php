<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CallSennovaRoleRequest;
use App\Http\Resources\CallSennovaRoleResource;
use App\Models\CallSennovaRole;
use Illuminate\Http\Request;

class CallSennovaRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CallSennovaRoleResource::collection(CallSennovaRole::orderBy('fieldName')->get());
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
        $callSennovaRole->fieldName = $request->get('fieldName');
        $callSennovaRole->fieldName = $request->get('fieldName');
        $callSennovaRole->fieldName = $request->get('fieldName');

        $callSennovaRole->save();

        return new CallSennovaRoleResource($callSennovaRole);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CallSennovaRole  $callSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function show(CallSennovaRole $callSennovaRole)
    {
        $this->authorize('view', [CallSennovaRole::class]);

        return new CallSennovaRoleResource($callSennovaRole);
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
        $this->authorize('update', [CallSennovaRole::class]);

        $callSennovaRole->fieldName = $request->get('fieldName');
        $callSennovaRole->fieldName = $request->get('fieldName');
        $callSennovaRole->fieldName = $request->get('fieldName');

        $callSennovaRole->save();

        return new CallSennovaRoleResource($callSennovaRole);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CallSennovaRole  $callSennovaRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(CallSennovaRole $callSennovaRole)
    {
        $this->authorize('delete', [CallSennovaRole::class]);

        $callSennovaRole->delete();

        return response()->json(null, 204);
    }
}
