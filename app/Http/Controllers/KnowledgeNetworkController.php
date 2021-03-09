<?php

namespace App\Http\Controllers;

use App\Http\Requests\KnowledgeNetworkRequest;
use App\Models\KnowledgeNetwork;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KnowledgeNetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [KnowledgeNetwork::class]);

        return Inertia::render('KnowledgeNetworks/Index', [
            'filters'   => request()->all('search'),
            'knowledgeNetworks' => KnowledgeNetwork::orderBy('name', 'ASC')
                ->filterKnowledgeNetwork(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [KnowledgeNetwork::class]);

        return Inertia::render('KnowledgeNetworks/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KnowledgeNetworkRequest $request)
    {
        $this->authorize('create', [KnowledgeNetwork::class]);

        $knowledgeNetwork = new KnowledgeNetwork();
        $knowledgeNetwork->name = $request->name;

        $knowledgeNetwork->save();

        return redirect()->route('knowledge-networks.index')->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return \Illuminate\Http\Response
     */
    public function show(KnowledgeNetwork $knowledgeNetwork)
    {
        $this->authorize('view', [KnowledgeNetwork::class, $knowledgeNetwork]);

        return Inertia::render('KnowledgeNetworks/Show', [
            'knowledgeNetwork' => $knowledgeNetwork
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return \Illuminate\Http\Response
     */
    public function edit(KnowledgeNetwork $knowledgeNetwork)
    {
        $this->authorize('update', [KnowledgeNetwork::class, $knowledgeNetwork]);

        return Inertia::render('KnowledgeNetworks/Edit', [
            'knowledgeNetwork' => $knowledgeNetwork
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return \Illuminate\Http\Response
     */
    public function update(KnowledgeNetworkRequest $request, KnowledgeNetwork $knowledgeNetwork)
    {
        $this->authorize('update', [KnowledgeNetwork::class, $knowledgeNetwork]);

        $knowledgeNetwork->name = $request->name;

        $knowledgeNetwork->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KnowledgeNetwork  $knowledgeNetwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(KnowledgeNetwork $knowledgeNetwork)
    {
        $this->authorize('delete', [KnowledgeNetwork::class, $knowledgeNetwork]);

        $knowledgeNetwork->delete();

        return redirect()->route('knowledge-networks.index')->with('success', __('The resource has been deleted successfully.'));
    }
}
