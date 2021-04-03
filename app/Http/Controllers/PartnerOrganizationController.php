<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerOrganizationRequest;
use App\Models\Call;
use App\Models\RDI;
use App\Models\PartnerOrganization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartnerOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call, RDI $rdi)
    {
        $this->authorize('viewAny', [PartnerOrganization::class]);

        return Inertia::render('Calls/Projects/RDI/PartnerOrganizations/Index', [
            'call'      => $call,
            'rdi'       => $rdi,
            'filters'   => request()->all('search'),
            'partnerOrganizations' => PartnerOrganization::where('rdi_id', $rdi->id)->orderBy('name', 'ASC')
                ->filterPartnerOrganization(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call, RDI $rdi)
    {
        $this->authorize('create', [PartnerOrganization::class]);

        return Inertia::render('Calls/Projects/RDI/PartnerOrganizations/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnerOrganizationRequest $request)
    {
        $this->authorize('create', [PartnerOrganization::class]);

        $partnerOrganization = new PartnerOrganization();
        $partnerOrganization->fieldName = $request->fieldName;
        $partnerOrganization->fieldName = $request->fieldName;
        $partnerOrganization->fieldName = $request->fieldName;

        $partnerOrganization->save();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function show(PartnerOrganization $partnerOrganization)
    {
        $this->authorize('view', [PartnerOrganization::class, $partnerOrganization]);

        return Inertia::render('Calls/Projects/RDI/PartnerOrganizations/Show', [
            'partnerOrganization' => $partnerOrganization
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function edit(PartnerOrganization $partnerOrganization)
    {
        $this->authorize('update', [PartnerOrganization::class, $partnerOrganization]);

        return Inertia::render('Calls/Projects/RDI/PartnerOrganizations/Edit', [
            'partnerOrganization' => $partnerOrganization
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function update(PartnerOrganizationRequest $request, PartnerOrganization $partnerOrganization)
    {
        $this->authorize('update', [PartnerOrganization::class, $partnerOrganization]);

        $partnerOrganization->fieldName = $request->fieldName;
        $partnerOrganization->fieldName = $request->fieldName;
        $partnerOrganization->fieldName = $request->fieldName;

        $partnerOrganization->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnerOrganization $partnerOrganization)
    {
        $this->authorize('delete', [PartnerOrganization::class, $partnerOrganization]);

        $partnerOrganization->delete();

        return redirect()->route('resourceRoute.index')->with('success', 'The resource has been deleted successfully.');
    }
}
