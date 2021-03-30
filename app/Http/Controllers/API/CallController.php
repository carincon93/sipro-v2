<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CallRequest;
use App\Http\Resources\CallResource;
use App\Models\Call;
use Illuminate\Http\Request;

class CallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CallResource::collection(Call::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CallRequest $request)
    {
        $this->authorize('create', [Call::class]);

        $call = new Call();
        $call->fieldName = $request->get('fieldName');
        $call->fieldName = $request->get('fieldName');
        $call->fieldName = $request->get('fieldName');

        $call->save();

        return new CallResource($call);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call)
    {
        $this->authorize('view', [Call::class]);

        return new CallResource($call);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function update(CallRequest $request, Call $call)
    {
        $this->authorize('update', [Call::class]);

        $call->fieldName = $request->get('fieldName');
        $call->fieldName = $request->get('fieldName');
        $call->fieldName = $request->get('fieldName');

        $call->save();

        return new CallResource($call);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Call  $call
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call)
    {
        $this->authorize('delete', [Call::class]);

        $call->delete();

        return response()->json(null, 204);
    }
}
