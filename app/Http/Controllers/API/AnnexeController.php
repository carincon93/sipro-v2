<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnexeRequest;
use App\Http\Resources\AnnexeResource;
use App\Models\Annexe;
use Illuminate\Http\Request;

class AnnexeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AnnexeResource::collection(Annexe::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnexeRequest $request)
    {
        $this->authorize('create', [Annexe::class]);

        $annexe = new Annexe();
        $annexe->fieldName = $request->get('fieldName');
        $annexe->fieldName = $request->get('fieldName');
        $annexe->fieldName = $request->get('fieldName');

        $annexe->save();

        return new AnnexeResource($annexe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function show(Annexe $annexe)
    {
        $this->authorize('view', [Annexe::class]);

        return new AnnexeResource($annexe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function update(AnnexeRequest $request, Annexe $annexe)
    {
        $this->authorize('update', [Annexe::class]);

        $annexe->fieldName = $request->get('fieldName');
        $annexe->fieldName = $request->get('fieldName');
        $annexe->fieldName = $request->get('fieldName');

        $annexe->save();

        return new AnnexeResource($annexe);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Annexe  $annexe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annexe $annexe)
    {
        $this->authorize('delete', [Annexe::class]);

        $annexe->delete();

        return response()->json(null, 204);
    }
}
