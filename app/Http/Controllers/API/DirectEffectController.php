<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DirectEffectRequest;
use App\Http\Resources\DirectEffectResource;
use App\Models\DirectEffect;
use Illuminate\Http\Request;

class DirectEffectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DirectEffectResource::collection(DirectEffect::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectEffectRequest $request)
    {
        $this->authorize('create', [DirectEffect::class]);

        $directEffect = new DirectEffect();
        $directEffect->fieldName = $request->get('fieldName');
        $directEffect->fieldName = $request->get('fieldName');
        $directEffect->fieldName = $request->get('fieldName');

        $directEffect->save();

        return new DirectEffectResource($directEffect);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DirectEffect  $directEffect
     * @return \Illuminate\Http\Response
     */
    public function show(DirectEffect $directEffect)
    {
        $this->authorize('view', [DirectEffect::class]);

        return new DirectEffectResource($directEffect);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DirectEffect  $directEffect
     * @return \Illuminate\Http\Response
     */
    public function update(DirectEffectRequest $request, DirectEffect $directEffect)
    {
        $this->authorize('update', [DirectEffect::class]);

        $directEffect->fieldName = $request->get('fieldName');
        $directEffect->fieldName = $request->get('fieldName');
        $directEffect->fieldName = $request->get('fieldName');

        $directEffect->save();

        return new DirectEffectResource($directEffect);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DirectEffect  $directEffect
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectEffect $directEffect)
    {
        $this->authorize('delete', [DirectEffect::class]);

        $directEffect->delete();

        return response()->json(null, 204);
    }
}
