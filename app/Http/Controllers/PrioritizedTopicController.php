<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrioritizedTopicRequest;
use App\Models\ProductiveSector;
use App\Models\TechnicalCommittee;
use App\Models\PrioritizedTopic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrioritizedTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [PrioritizedTopic::class]);

        return Inertia::render('PrioritizedTopics/Index', [
            'filters'   => request()->all('search'),
            'prioritizedTopics' => PrioritizedTopic::with(['productiveSector', 'technicalCommittee'])
                ->filterPrioritizedTopic(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [PrioritizedTopic::class]);

        return Inertia::render('PrioritizedTopics/Create', [
            'productiveSectors'     => ProductiveSector::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
            'technicalCommittees'   =>  TechnicalCommittee::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get()
        ]);
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
        $prioritizedTopic->name = $request->name;
        $prioritizedTopic->productiveSector()->associate($request->productive_sector_id);
        $prioritizedTopic->technicalCommittee()->associate($request->technical_committee_id);

        $prioritizedTopic->save();

        return redirect()->route('prioritized-topics.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return \Illuminate\Http\Response
     */
    public function show(PrioritizedTopic $prioritizedTopic)
    {
        $this->authorize('view', [PrioritizedTopic::class, $prioritizedTopic]);

        return Inertia::render('PrioritizedTopics/Show', [
            'prioritizedTopic' => $prioritizedTopic
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(PrioritizedTopic $prioritizedTopic)
    {
        $this->authorize('update', [PrioritizedTopic::class, $prioritizedTopic]);

        return Inertia::render('PrioritizedTopics/Edit', [
            'prioritizedTopic'    => $prioritizedTopic,
            'productiveSectors'   => ProductiveSector::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
            'technicalCommittees' => TechnicalCommittee::orderBy('name', 'ASC')->select(['id as value', 'name as label'])->get(),
        ]);
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
        $this->authorize('update', [PrioritizedTopic::class, $prioritizedTopic]);

        $prioritizedTopic->name = $request->name;
        $prioritizedTopic->productiveSector()->associate($request->productive_sector_id);
        $prioritizedTopic->technicalCommittee()->associate($request->technical_committee_id);

        $prioritizedTopic->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PrioritizedTopic  $prioritizedTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrioritizedTopic $prioritizedTopic)
    {
        $this->authorize('delete', [PrioritizedTopic::class, $prioritizedTopic]);

        $prioritizedTopic->delete();

        return redirect()->route('prioritized-topics.index')->with('success', 'The resource has been deleted successfully.');
    }
}
