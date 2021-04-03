<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductiveSectorRequest;
use App\Models\ProductiveSector;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductiveSectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', [ProductiveSector::class]);

        return Inertia::render('ProductiveSectors/Index', [
            'filters'   => request()->all('search'),
            'productiveSectors' => ProductiveSector::orderBy('name', 'ASC')
                ->filterProductiveSector(request()->only('search'))->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', [ProductiveSector::class]);

        return Inertia::render('ProductiveSectors/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductiveSectorRequest $request)
    {
        $this->authorize('create', [ProductiveSector::class]);

        $productiveSector = new ProductiveSector();
        $productiveSector->name = $request->name;

        $productiveSector->save();

        return redirect()->route('productive-sectors.index')->with('success', 'The resource has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return \Illuminate\Http\Response
     */
    public function show(ProductiveSector $productiveSector)
    {
        $this->authorize('view', [ProductiveSector::class, $productiveSector]);

        return Inertia::render('ProductiveSectors/Show', [
            'productiveSector' => $productiveSector
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductiveSector $productiveSector)
    {
        $this->authorize('update', [ProductiveSector::class, $productiveSector]);

        return Inertia::render('ProductiveSectors/Edit', [
            'productiveSector' => $productiveSector
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return \Illuminate\Http\Response
     */
    public function update(ProductiveSectorRequest $request, ProductiveSector $productiveSector)
    {
        $this->authorize('update', [ProductiveSector::class, $productiveSector]);

        $productiveSector->name = $request->name;

        $productiveSector->save();

        return redirect()->back()->with('success', 'The resource has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductiveSector $productiveSector)
    {
        $this->authorize('delete', [ProductiveSector::class, $productiveSector]);

        $productiveSector->delete();

        return redirect()->route('productive-sectors.index')->with('success', 'The resource has been deleted successfully.');
    }
}
