<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrioritizedTopicRequest;
use App\Http\Resources\PrioritizedTopicResource;
use App\Models\PrioritizedTopic;
use Illuminate\Http\Request;

class PrioritizedTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PrioritizedTopicResource::collection(PrioritizedTopic::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrioritizedTopicRequest $request)
    {
        $this->authorize('create', [PrioritizedTopic::class]);

        $prioritizedTopic = new PrioritizedTopic();
        $prioritizedTopic->fieldName = $request->get('fieldName');
        $prioritizedTopic->fieldName = $request->get('fieldName');
        $prioritizedTopic->fieldName = $request->get('fieldName');

        $prioritizedTopic->save();

        return new PrioritizedTopicResource($prioritizedTopic);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return \Illuminate\Http\Response
     */
    public function show(PrioritizedTopic $prioritizedTopic)
    {
        $this->authorize('view', [PrioritizedTopic::class]);

        return new PrioritizedTopicResource($prioritizedTopic);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return \Illuminate\Http\Response
     */
    public function update(PrioritizedTopicRequest $request, PrioritizedTopic $prioritizedTopic)
    {
        $this->authorize('update', [PrioritizedTopic::class]);

        $prioritizedTopic->fieldName = $request->get('fieldName');
        $prioritizedTopic->fieldName = $request->get('fieldName');
        $prioritizedTopic->fieldName = $request->get('fieldName');

        $prioritizedTopic->save();

        return new PrioritizedTopicResource($prioritizedTopic);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrioritizedTopic $prioritizedTopic)
    {
        $this->authorize('delete', [PrioritizedTopic::class]);

        $prioritizedTopic->delete();

        return response()->json(null, 204);
    }
}
