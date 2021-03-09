<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StrategicThematicRequest;
use App\Http\Resources\StrategicThematicResource;
use App\Models\StrategicThematic;
use Illuminate\Http\Request;

class StrategicThematicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StrategicThematicResource::collection(StrategicThematic::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StrategicThematicRequest $request)
    {
        $this->authorize('create', [StrategicThematic::class]);

        $strategicThematic = new StrategicThematic();
        $strategicThematic->fieldName = $request->get('fieldName');
        $strategicThematic->fieldName = $request->get('fieldName');
        $strategicThematic->fieldName = $request->get('fieldName');

        $strategicThematic->save();

        return new StrategicThematicResource($strategicThematic);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return \Illuminate\Http\Response
     */
    public function show(StrategicThematic $strategicThematic)
    {
        $this->authorize('view', [StrategicThematic::class]);

        return new StrategicThematicResource($strategicThematic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return \Illuminate\Http\Response
     */
    public function update(StrategicThematicRequest $request, StrategicThematic $strategicThematic)
    {
        $this->authorize('update', [StrategicThematic::class]);

        $strategicThematic->fieldName = $request->get('fieldName');
        $strategicThematic->fieldName = $request->get('fieldName');
        $strategicThematic->fieldName = $request->get('fieldName');

        $strategicThematic->save();

        return new StrategicThematicResource($strategicThematic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StrategicThematic  $strategicThematic
     * @return \Illuminate\Http\Response
     */
    public function destroy(StrategicThematic $strategicThematic)
    {
        $this->authorize('delete', [StrategicThematic::class]);

        $strategicThematic->delete();

        return response()->json(null, 204);
    }
}
