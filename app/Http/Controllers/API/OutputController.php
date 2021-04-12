<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OutputRequest;
use App\Http\Resources\OutputResource;
use App\Models\Output;
use Illuminate\Http\Request;

class OutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OutputResource::collection(Output::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OutputRequest $request)
    {
        $this->authorize('create', [Output::class]);

        $output = new Output();
        $output->fieldName = $request->get('fieldName');
        $output->fieldName = $request->get('fieldName');
        $output->fieldName = $request->get('fieldName');

        $output->save();

        return new OutputResource($output);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function show(Output $output)
    {
        $this->authorize('view', [Output::class]);

        return new OutputResource($output);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function update(OutputRequest $request, Output $output)
    {
        $this->authorize('update', [Output::class]);

        $output->fieldName = $request->get('fieldName');
        $output->fieldName = $request->get('fieldName');
        $output->fieldName = $request->get('fieldName');

        $output->save();

        return new OutputResource($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Output  $output
     * @return \Illuminate\Http\Response
     */
    public function destroy(Output $output)
    {
        $this->authorize('delete', [Output::class]);

        $output->delete();

        return response()->json(null, 204);
    }
}
