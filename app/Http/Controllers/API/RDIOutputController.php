<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RDIOutputRequest;
use App\Http\Resources\RDIOutputResource;
use App\Models\RDIOutput;
use Illuminate\Http\Request;

class RDIOutputController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RDIOutputResource::collection(RDIOutput::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RDIOutputRequest $request)
    {
        $this->authorize('create', [RDIOutput::class]);

        $rDIOutput = new RDIOutput();
        $rDIOutput->fieldName = $request->get('fieldName');
        $rDIOutput->fieldName = $request->get('fieldName');
        $rDIOutput->fieldName = $request->get('fieldName');

        $rDIOutput->save();

        return new RDIOutputResource($rDIOutput);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RDIOutput  $rDIOutput
     * @return \Illuminate\Http\Response
     */
    public function show(RDIOutput $rDIOutput)
    {
        $this->authorize('view', [RDIOutput::class]);

        return new RDIOutputResource($rDIOutput);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RDIOutput  $rDIOutput
     * @return \Illuminate\Http\Response
     */
    public function update(RDIOutputRequest $request, RDIOutput $rDIOutput)
    {
        $this->authorize('update', [RDIOutput::class]);

        $rDIOutput->fieldName = $request->get('fieldName');
        $rDIOutput->fieldName = $request->get('fieldName');
        $rDIOutput->fieldName = $request->get('fieldName');

        $rDIOutput->save();

        return new RDIOutputResource($rDIOutput);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RDIOutput  $rDIOutput
     * @return \Illuminate\Http\Response
     */
    public function destroy(RDIOutput $rDIOutput)
    {
        $this->authorize('delete', [RDIOutput::class]);

        $rDIOutput->delete();

        return response()->json(null, 204);
    }
}
