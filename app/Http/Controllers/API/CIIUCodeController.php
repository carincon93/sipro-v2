<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CIIUCodeRequest;
use App\Http\Resources\CIIUCodeResource;
use App\Models\CIIUCode;
use Illuminate\Http\Request;

class CIIUCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CIIUCodeResource::collection(CIIUCode::orderBy('fieldName')->get());
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

        $cIIUCode = new CIIUCode();
        $cIIUCode->fieldName = $request->get('fieldName');
        $cIIUCode->fieldName = $request->get('fieldName');
        $cIIUCode->fieldName = $request->get('fieldName');

        $cIIUCode->save();

        return new CIIUCodeResource($cIIUCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CIIUCode  $cIIUCode
     * @return \Illuminate\Http\Response
     */
    public function show(CIIUCode $cIIUCode)
    {
        $this->authorize('view', [CIIUCode::class]);

        return new CIIUCodeResource($cIIUCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CIIUCode  $cIIUCode
     * @return \Illuminate\Http\Response
     */
    public function update(CIIUCodeRequest $request, CIIUCode $cIIUCode)
    {
        $this->authorize('update', [CIIUCode::class]);

        $cIIUCode->fieldName = $request->get('fieldName');
        $cIIUCode->fieldName = $request->get('fieldName');
        $cIIUCode->fieldName = $request->get('fieldName');

        $cIIUCode->save();

        return new CIIUCodeResource($cIIUCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CIIUCode  $cIIUCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(CIIUCode $cIIUCode)
    {
        $this->authorize('delete', [CIIUCode::class]);

        $cIIUCode->delete();

        return response()->json(null, 204);
    }
}
