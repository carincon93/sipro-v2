<?php

namespace App\Http\Controllers;

use App\Http\Requests\RDIRequest;
use App\Models\RDI;
use App\Models\Call;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RDIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Call $call)
    {
        $this->authorize('viewAny', [RDI::class]);

        return Inertia::render('Calls/Projects/RDI/Index', [
            'filters'   => request()->all('search'),
            'call'      => $call,
            'rdi'       => $call->rdi()->select('id', 'title', 'start_date')->orderBy('title', 'ASC')
                ->filterRDI(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Call $call)
    {
        $this->authorize('create', [RDI::class]);

        return Inertia::render('Calls/Projects/RDI/Create', [
            'call' => $call
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RDIRequest $request, Call $call)
    {
        $this->authorize('create', [RDI::class]);

        $rdi = new RDI();
        $rdi->fieldName = $request->fieldName;
        $rdi->fieldName = $request->fieldName;
        $rdi->fieldName = $request->fieldName;

        $rdi->save();

        return redirect()->route('calls.rdi.index', ['call'])->with('success', __('The resource has been created successfully.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function show(Call $call, RDI $rdi)
    {
        $this->authorize('view', [RDI::class, $rdi]);

        return Inertia::render('Calls/Projects/RDI/Show', [
            'call'  => $call,
            'rdi'   => $rdi
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function edit(Call $call, RDI $rdi)
    {
        $this->authorize('update', [RDI::class, $rdi]);

        return Inertia::render('Calls/Projects/RDI/Edit', [
            'call'  => $call,
            'rdi'   => $rdi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function update(RDIRequest $request, Call $call, RDI $rdi)
    {
        $this->authorize('update', [RDI::class, $rdi]);

        $rdi->fieldName = $request->fieldName;
        $rdi->fieldName = $request->fieldName;
        $rdi->fieldName = $request->fieldName;

        $rdi->save();

        return redirect()->back()->with('success', __('The resource has been updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RDI  $rdi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Call $call, RDI $rdi)
    {
        $this->authorize('delete', [RDI::class, $rdi]);

        $rdi->delete();

        return redirect()->route('calls.rdi.index', ['call'])->with('success', __('The resource has been deleted successfully.'));
    }
}
