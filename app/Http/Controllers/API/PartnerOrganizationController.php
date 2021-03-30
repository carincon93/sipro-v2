<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerOrganizationRequest;
use App\Http\Resources\PartnerOrganizationResource;
use App\Models\PartnerOrganization;
use Illuminate\Http\Request;

class PartnerOrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PartnerOrganizationResource::collection(PartnerOrganization::orderBy('fieldName')->get());
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
        $partnerOrganization->fieldName = $request->get('fieldName');
        $partnerOrganization->fieldName = $request->get('fieldName');
        $partnerOrganization->fieldName = $request->get('fieldName');

        $partnerOrganization->save();

        return new PartnerOrganizationResource($partnerOrganization);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function show(PartnerOrganization $partnerOrganization)
    {
        $this->authorize('view', [PartnerOrganization::class]);

        return new PartnerOrganizationResource($partnerOrganization);
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
        $this->authorize('update', [PartnerOrganization::class]);

        $partnerOrganization->fieldName = $request->get('fieldName');
        $partnerOrganization->fieldName = $request->get('fieldName');
        $partnerOrganization->fieldName = $request->get('fieldName');

        $partnerOrganization->save();

        return new PartnerOrganizationResource($partnerOrganization);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnerOrganization $partnerOrganization)
    {
        $this->authorize('delete', [PartnerOrganization::class]);

        $partnerOrganization->delete();

        return response()->json(null, 204);
    }
}
