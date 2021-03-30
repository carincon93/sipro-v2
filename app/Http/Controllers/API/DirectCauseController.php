<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DirectCauseRequest;
use App\Http\Resources\DirectCauseResource;
use App\Models\DirectCause;
use Illuminate\Http\Request;

class DirectCauseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DirectCauseResource::collection(DirectCause::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectCauseRequest $request)
    {
        $this->authorize('create', [DirectCause::class]);

        $directCause = new DirectCause();
        $directCause->fieldName = $request->get('fieldName');
        $directCause->fieldName = $request->get('fieldName');
        $directCause->fieldName = $request->get('fieldName');

        $directCause->save();

        return new DirectCauseResource($directCause);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectCause  $directCause
     * @return \Illuminate\Http\Response
     */
    public function show(DirectCause $directCause)
    {
        $this->authorize('view', [DirectCause::class]);

        return new DirectCauseResource($directCause);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirectCause  $directCause
     * @return \Illuminate\Http\Response
     */
    public function update(DirectCauseRequest $request, DirectCause $directCause)
    {
        $this->authorize('update', [DirectCause::class]);

        $directCause->fieldName = $request->get('fieldName');
        $directCause->fieldName = $request->get('fieldName');
        $directCause->fieldName = $request->get('fieldName');

        $directCause->save();

        return new DirectCauseResource($directCause);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectCause  $directCause
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectCause $directCause)
    {
        $this->authorize('delete', [DirectCause::class]);

        $directCause->delete();

        return response()->json(null, 204);
    }
}
