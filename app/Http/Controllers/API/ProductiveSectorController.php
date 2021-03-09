<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductiveSectorRequest;
use App\Http\Resources\ProductiveSectorResource;
use App\Models\ProductiveSector;
use Illuminate\Http\Request;

class ProductiveSectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductiveSectorResource::collection(ProductiveSector::orderBy('fieldName')->get());
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
        $productiveSector->fieldName = $request->get('fieldName');
        $productiveSector->fieldName = $request->get('fieldName');
        $productiveSector->fieldName = $request->get('fieldName');

        $productiveSector->save();

        return new ProductiveSectorResource($productiveSector);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return \Illuminate\Http\Response
     */
    public function show(ProductiveSector $productiveSector)
    {
        $this->authorize('view', [ProductiveSector::class]);

        return new ProductiveSectorResource($productiveSector);
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
        $this->authorize('update', [ProductiveSector::class]);

        $productiveSector->fieldName = $request->get('fieldName');
        $productiveSector->fieldName = $request->get('fieldName');
        $productiveSector->fieldName = $request->get('fieldName');

        $productiveSector->save();

        return new ProductiveSectorResource($productiveSector);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductiveSector  $productiveSector
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductiveSector $productiveSector)
    {
        $this->authorize('delete', [ProductiveSector::class]);

        $productiveSector->delete();

        return response()->json(null, 204);
    }
}
