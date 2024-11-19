<x-layout title="Magazijns">
    
<div class="container">
    <h1>Product Information</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Barcode</th>
                <th>Packaging Unit</th>
                <th>Stock</th>
                <th>Allergens</th>
                <th>Suppliers</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->Id }}</td>
                <td>{{ $product->Naam }}</td>
                <td>{{ $product->Barcode }}</td>
                <td>{{ $product->magazine->VerpakkingsEenheid }}</td>
                <td>{{ $product->magazine->AantalAanwezig }}</td>
                <td>
                    @foreach ($product->allergens as $allergen)
                        {{ $allergen->Naam }}<br>
                    @endforeach
                </td>
                <td>
                    @foreach ($product->suppliers as $supplier)
                        {{ $supplier->Naam }}<br>
                        Last Delivery: {{ $supplier->pivot->DatumLevering }}<br>
                        Quantity: {{ $supplier->pivot->Aantal }}<br>
                        Next Delivery: {{ $supplier->pivot->DatumEerstVolgendeLevering }}<br>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-layout>
