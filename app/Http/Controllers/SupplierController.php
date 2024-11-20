<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers, sorted by number of products
     */
    public function index()
    {
        // Get suppliers with their product count, sorted in descending order
        $suppliers = Supplier::withCount(['products' => function($query) {
            $query->distinct('ProductId');
        }])
        ->orderBy('products_count', 'desc')
        ->get();

        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show detailed information about a specific supplier
     */
    public function show(Supplier $supplier)
    {
        // Load related products with pivot information
        $supplier->load(['products' => function($query) {
            $query->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
        }]);

        return view('suppliers.show', compact('supplier'));
    }
}