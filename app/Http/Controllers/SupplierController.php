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
    public function showProducts($id)
    {
        // Check if the view exists
        if (!View::exists('suppliers.products')) {
            // Redirect to suppliers index if view not found
            return redirect()->route('suppliers.index')
                ->with('error', 'Producten weergave niet beschikbaar');
        }

        $supplier = Supplier::with(['products' => function($query) {
            $query->with('magazine')
                  ->withPivot('DatumLevering', 'Aantal', 'DatumEerstVolgendeLevering');
        }])->findOrFail($id);

        return view('suppliers.products', compact('supplier'));
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

        // Double-check if product is still active before processing
        if (!$product->IsActief) {
            return redirect()
                ->route('suppliers.index')
                ->with('error', "Het product {$product->Naam} van de leverancier {$supplier->Naam} wordt niet meer geproduceerd");
        }

        DB::transaction(function () use ($request, $supplierId, $productId) {
            // Update or create new delivery record
            $delivery = DB::table('ProductPerLeverancier')->insert([
                'LeverancierId' => $supplierId,
                'ProductId' => $productId,
                'DatumLevering' => now(),
                'Aantal' => $request->aantal,
                'DatumEerstVolgendeLevering' => $request->volgende_levering,
            ]);

            // Update warehouse quantity
            $magazine = Magazine::where('ProductId', $productId)->first();
            if ($magazine) {
                $magazine->AantalAanwezig += $request->aantal;
                $magazine->save();
            }
        });

        return redirect()->route('suppliers.index')
                        ->with('success', 'Levering succesvol verwerkt');
    }
}