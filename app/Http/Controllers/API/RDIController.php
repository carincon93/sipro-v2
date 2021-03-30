<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RDIRequest;
use App\Http\Resources\RDIResource;
use App\Models\RDI;
use Illuminate\Http\Request;

class RDIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RDIResource::collection(RDI::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RDIRequest $request)
    {
        $this->authorize('create', [RDI::class]);

        $rDI = new RDI();
        $rDI->fieldName = $request->get('fieldName');
        $rDI->fieldName = $request->get('fieldName');
        $rDI->fieldName = $request->get('fieldName');

        $rDI->save();

        return new RDIResource($rDI);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RDI  $rDI
     * @return \Illuminate\Http\Response
     */
    public function show(RDI $rDI)
    {
        $this->authorize('view', [RDI::class]);

        return new RDIResource($rDI);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RDI  $rDI
     * @return \Illuminate\Http\Response
     */
    public function update(RDIRequest $request, RDI $rDI)
    {
        $this->authorize('update', [RDI::class]);

        $rDI->fieldName = $request->get('fieldName');
        $rDI->fieldName = $request->get('fieldName');
        $rDI->fieldName = $request->get('fieldName');

        $rDI->save();

        return new RDIResource($rDI);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RDI  $rDI
     * @return \Illuminate\Http\Response
     */
    public function destroy(RDI $rDI)
    {
        $this->authorize('delete', [RDI::class]);

        $rDI->delete();

        return response()->json(null, 204);
    }
}
