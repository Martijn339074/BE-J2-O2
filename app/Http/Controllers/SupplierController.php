<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\Magazine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class SupplierController extends Controller
{
    /**
     * Display a listing of suppliers, sorted by number of products
     */
    public function index()
    {
        // Get suppliers with their product count, sorted in descending order
        $suppliers = Supplier::withCount(['products' => function ($query) {
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
        $supplier->load(['products' => function ($query) {
            $query->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
        }]);

        return view('suppliers.show', compact('supplier'));
    }
    public function showProducts($id)
    {
        $supplier = Supplier::with(['products' => function ($query) {
            $query->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering')
                ->with('magazine');
        }])->findOrFail($id);
    
        // Group products by ID and select the latest delivery
        $supplier->products = $supplier->products->groupBy('id')->map(function ($products) {
            return $products->sortByDesc('pivot.DatumLevering')->first();
        })->values();
    
        return view('suppliers.products', compact('supplier'));
    }

    public function deleteProduct($supplierId, $productId)
    {
        $supplier = Supplier::findOrFail($supplierId);
        $product = $supplier->products()->where('products.id', $productId)->first();

        if (!$product) {
            return redirect()->route('suppliers.show', $supplierId)
                ->with('error', 'Product not found for this supplier.');
        }

        // Delete the pivot record
        $supplier->products()->detach($product->id);

        return redirect()->route('suppliers.show', $supplierId)
            ->with('success', 'Product deleted from supplier successfully.');
    }

    public function showDeliveryForm($supplierId, $productId)
    {
        $supplier = Supplier::findOrFail($supplierId);
        $product = Product::with('magazine')->findOrFail($productId);

        // Check if product is inactive before showing the form
        if (!$product->IsActief) {
            return redirect()
                ->route('suppliers.index')
                ->with('error', "Het product {$product->Naam} van de leverancier {$supplier->Naam} wordt niet meer geproduceerd");
        }

        return view('suppliers.delivery-form', compact('supplier', 'product'));
    }

    public function processDelivery(Request $request, $supplierId, $productId)
    {
        $request->validate([
            'aantal' => 'required|integer|min:1',
            'volgende_levering' => 'required|date|after:today',
        ]);

        $supplier = Supplier::findOrFail($supplierId);
        $product = Product::findOrFail($productId);

        if (!$product->IsActief) {
            return redirect()
                ->route('suppliers.index')
                ->with('error', "The product {$product->Naam} from supplier {$supplier->Naam} is no longer produced");
        }

        DB::transaction(function () use ($request, $supplierId, $productId) {
            $delivery = DB::table('ProductPerLeverancier')
                ->where('LeverancierId', $supplierId)
                ->where('ProductId', $productId)
                ->first();

            if ($delivery) {
                DB::table('ProductPerLeverancier')
                    ->where('LeverancierId', $supplierId)
                    ->where('ProductId', $productId)
                    ->update([
                        'DatumLevering' => now(),
                        'Aantal' => $request->aantal,
                        'DatumEerstVolgendeLevering' => $request->volgende_levering,
                    ]);
            } else {
                DB::table('ProductPerLeverancier')->insert([
                    'LeverancierId' => $supplierId,
                    'ProductId' => $productId,
                    'DatumLevering' => now(),
                    'Aantal' => $request->aantal,
                    'DatumEerstVolgendeLevering' => $request->volgende_levering,
                ]);
            }

            $magazine = Magazine::where('ProductId', $productId)->first();
            if ($magazine) {
                $magazine->AantalAanwezig += $request->aantal;
                $magazine->LaatsteLevering = now();
                $magazine->save();
            }
        });

        return redirect()->route('suppliers.index')
            ->with('success', 'Delivery processed successfully');
    }
}
