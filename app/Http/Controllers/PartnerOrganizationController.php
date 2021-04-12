<?php

namespace App\Http\Controllers;

use App\Http\Requests\PartnerOrganizationRequest;
use App\Models\Call;
use App\Models\RDI;
use App\Models\PartnerOrganization;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        return Inertia::render('Calls/Projects/RDI/PartnerOrganizations/Create', [
            'call' => $call,
            'rdi'  => $rdi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PartnerOrganizationRequest $request, Call $call, RDI $rdi)
    {
        $this->authorize('create', [PartnerOrganization::class]);

        $partnerOrganization = new PartnerOrganization();
        $partnerOrganization->partner_organization_type         = $request->partner_organization_type;
        $partnerOrganization->name                              = $request->name;
        $partnerOrganization->legal_status                      = $request->legal_status;
        $partnerOrganization->company_type                      = $request->company_type;
        $partnerOrganization->nit                               = $request->nit;
        $partnerOrganization->agreement_description             = $request->agreement_description;
        $partnerOrganization->research_group                    = $request->research_group;
        $partnerOrganization->gruplac_code                      = $request->gruplac_code;
        $partnerOrganization->gruplac_link                      = $request->gruplac_link;
        $partnerOrganization->knowledge_transfer_activities     = $request->knowledge_transfer_activities;

        $endDate       = date('Y', strtotime($rdi->end_date));
        $companyName   = Str::slug(substr($request->name, 0, 30), '-');

        $letterOfIntent = $request->letter_of_intent;

        $letterOfIntentFileName = ($rdi->id + 8000)."-SGPS-$endDate-carta-de-intencion-$companyName.".$letterOfIntent->extension();
        $letterOfIntentFile = $letterOfIntent->storeAs(
            'partner-organizations', $letterOfIntentFileName
        );
        $partnerOrganization->letter_of_intent = $letterOfIntentFile;

        $intellectualProperty = $request->intellectual_property;
        $intelectualPropertyFileName = ($rdi->id + 8000)."-SGPS-$endDate-propiedad-intelectual-$companyName.".$intellectualProperty->extension();
        $intelectualPropertyFile = $intellectualProperty->storeAs(
            'intellectual-properties', $intelectualPropertyFileName
        );

        $partnerOrganization->intellectual_property = $intelectualPropertyFile;

        $partnerOrganization->rdi()->associate($rdi);

        $partnerOrganization->save();

        return redirect()->route('calls.rdi.partner-organizations.index', [$call, $rdi])->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, RDI $rdi, PartnerOrganization $partnerOrganization)
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
    public function edit(Call $call, RDI $rdi, PartnerOrganization $partnerOrganization)
    {
        $this->authorize('update', [PartnerOrganization::class, $partnerOrganization]);

        return Inertia::render('Calls/Projects/RDI/PartnerOrganizations/Edit', [
            'call'                  => $call,
            'rdi'                   => $rdi,
            'partnerOrganization'   => $partnerOrganization
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function update(PartnerOrganizationRequest $request, Call $call, RDI $rdi, PartnerOrganization $partnerOrganization)
    {
        $this->authorize('update', [PartnerOrganization::class, $partnerOrganization]);

        $partnerOrganization->partner_organization_type         = $request->partner_organization_type;
        $partnerOrganization->name                              = $request->name;
        $partnerOrganization->legal_status                      = $request->legal_status;
        $partnerOrganization->company_type                      = $request->company_type;
        $partnerOrganization->nit                               = $request->nit;
        $partnerOrganization->agreement_description             = $request->agreement_description;
        $partnerOrganization->research_group                    = $request->research_group;
        $partnerOrganization->gruplac_code                      = $request->gruplac_code;
        $partnerOrganization->gruplac_link                      = $request->gruplac_link;
        $partnerOrganization->knowledge_transfer_activities     = $request->knowledge_transfer_activities;

        $endDate       = date('Y', strtotime($rdi->end_date));
        $companyName   = Str::slug(substr($request->name, 0, 30), '-');

        if ($request->hasFile('letter_of_intent')) {
            Storage::delete($partnerOrganization->letter_of_intent);
            $letterOfIntent = $request->letter_of_intent;
            $letterOfIntentFileName = ($rdi->id + 8000)."-SGPS-$endDate-carta-de-intencion-$companyName.".$letterOfIntent->extension();
            $letterOfIntentFile = $letterOfIntent->storeAs(
                'partner-organizations', $letterOfIntentFileName
            );
            $partnerOrganization->letter_of_intent = $letterOfIntentFile;
        }
        if ($request->hasFile('intellectual_property')) {
            Storage::delete($partnerOrganization->intellectual_property);
            $intellectualProperty = $request->intellectual_property;
            $intelectualPropertyFileName = ($rdi->id + 8000)."-SGPS-$endDate-propiedad-intelectual-$companyName.".$intellectualProperty->extension();
            $intelectualPropertyFile = $intellectualProperty->storeAs(
                'intellectual-properties', $intelectualPropertyFileName
            );
            $partnerOrganization->intellectual_property = $intelectualPropertyFile;
        }

        $partnerOrganization->rdi()->associate($rdi);

        $partnerOrganization->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PartnerOrganization  $partnerOrganization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, RDI $rdi, PartnerOrganization $partnerOrganization)
    {
        $this->authorize('delete', [PartnerOrganization::class, $partnerOrganization]);

        Storage::delete($partnerOrganization->letter_of_intent);
        Storage::delete($partnerOrganization->intellectual_property);

        $partnerOrganization->delete();

        return redirect()->route('calls.rdi.partner-organizations.index', [$call, $rdi])->with('success', 'The resource has been deleted successfully.');
    }
}
