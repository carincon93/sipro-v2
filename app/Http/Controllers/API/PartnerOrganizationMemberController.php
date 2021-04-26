<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerOrganizationMemberRequest;
use App\Http\Resources\PartnerOrganizationMemberResource;
use App\Models\PartnerOrganizationMember;
use Illuminate\Http\Request;

class PartnerOrganizationMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PartnerOrganizationMemberResource::collection(PartnerOrganizationMember::orderBy('fieldName')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnerOrganizationMemberRequest $request)
    {
        $this->authorize('create', [PartnerOrganizationMember::class]);

        $partnerOrganizationMember = new PartnerOrganizationMember();
        $partnerOrganizationMember->fieldName = $request->get('fieldName');
        $partnerOrganizationMember->fieldName = $request->get('fieldName');
        $partnerOrganizationMember->fieldName = $request->get('fieldName');

        $partnerOrganizationMember->save();

        return new PartnerOrganizationMemberResource($partnerOrganizationMember);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartnerOrganizationMember  $partnerOrganizationMember
     * @return \Illuminate\Http\Response
     */
    public function show(PartnerOrganizationMember $partnerOrganizationMember)
    {
        $this->authorize('view', [PartnerOrganizationMember::class]);

        return new PartnerOrganizationMemberResource($partnerOrganizationMember);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartnerOrganizationMember  $partnerOrganizationMember
     * @return \Illuminate\Http\Response
     */
    public function update(PartnerOrganizationMemberRequest $request, PartnerOrganizationMember $partnerOrganizationMember)
    {
        $this->authorize('update', [PartnerOrganizationMember::class]);

        $partnerOrganizationMember->fieldName = $request->get('fieldName');
        $partnerOrganizationMember->fieldName = $request->get('fieldName');
        $partnerOrganizationMember->fieldName = $request->get('fieldName');

        $partnerOrganizationMember->save();

        return new PartnerOrganizationMemberResource($partnerOrganizationMember);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartnerOrganizationMember  $partnerOrganizationMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(PartnerOrganizationMember $partnerOrganizationMember)
    {
        $this->authorize('delete', [PartnerOrganizationMember::class]);

        $partnerOrganizationMember->delete();

        return response()->json(null, 204);
    }
}
