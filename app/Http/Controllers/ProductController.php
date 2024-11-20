<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Allergen;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $allergens = Allergen::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('allergens', 'suppliers'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|max:255',
            'Description' => 'nullable',
            'Price' => 'required|numeric',
            'allergens' => 'array',
            'suppliers' => 'array'
        ]);

        $product = Product::create($validatedData);

        // Attach allergens
        if (isset($validatedData['allergens'])) {
            $product->allergens()->sync($validatedData['allergens']);
        }

        // Attach suppliers with additional pivot data
        if (isset($validatedData['suppliers'])) {
            $supplierData = [];
            foreach ($validatedData['suppliers'] as $supplierId) {
                $supplierData[$supplierId] = [
                    'DatumLevering' => now(),
                    'Aantal' => $request->input('supplier_quantity.' . $supplierId, 0),
                    'DatumEerstVolgendeLevering' => $request->input('next_delivery_date.' . $supplierId)
                ];
            }
            $product->suppliers()->sync($supplierData);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['magazine', 'allergens', 'suppliers']);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $allergens = Allergen::all();
        $suppliers = Supplier::all();
        $product->load(['allergens', 'suppliers']);
        return view('products.edit', compact('product', 'allergens', 'suppliers'));
    }
    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'Name' => 'required|max:255',
            'Description' => 'nullable',
            'Price' => 'required|numeric',
            'allergens' => 'array',
            'suppliers' => 'array'
        ]);

        $product->update($validatedData);

        // Sync allergens
        if (isset($validatedData['allergens'])) {
            $product->allergens()->sync($validatedData['allergens']);
        }

        // Sync suppliers with additional pivot data
        if (isset($validatedData['suppliers'])) {
            $supplierData = [];
            foreach ($validatedData['suppliers'] as $supplierId) {
                $supplierData[$supplierId] = [
                    'DatumLevering' => now(),
                    'Aantal' => $request->input('supplier_quantity.' . $supplierId, 0),
                    'DatumEerstVolgendeLevering' => $request->input('next_delivery_date.' . $supplierId)
                ];
            }
            $product->suppliers()->sync($supplierData);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
