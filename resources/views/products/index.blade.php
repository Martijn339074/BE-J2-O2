<x-layout title="Magazijns">
    <div class="container">
        <h1>Products Detailed List</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Barcode</th>
                    <th>Warehouse Quantity</th>
                    <th>Packaging Unit</th>
                    <th>Allergens</th>
                    <th>Suppliers</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->Id }}</td>
                    <td>{{ $product->Naam }}</td>
                    <td>{{ $product->Barcode }}</td>
                    <td>
                        @if($product->magazine)
                            {{ $product->magazine->AantalAanwezig ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($product->magazine)
                            {{ $product->magazine->VerpakkingsEenheid ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @foreach($product->allergens as $allergen)
                            <span class="badge bg-warning">{{ $allergen->Naam }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($product->suppliers as $supplier)
                            <div>
                                {{ $supplier->Naam }} 
                                (Last delivery: {{ $supplier->pivot->DatumLevering }}, 
                                Quantity: {{ $supplier->pivot->Aantal }})
                            </div>
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
