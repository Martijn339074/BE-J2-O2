<x-layout>
    <div class="container">
        <h1>{{ $supplier->Naam }} - Supplier Details</h1>
        
        <div class="card mb-4">
            <div class="card-header">
                <h2>Supplier Information</h2>
            </div>
            <div class="card-body">
                <p><strong>Contact Person:</strong> {{ $supplier->ContactPersoon }}</p>
                <p><strong>Supplier Number:</strong> {{ $supplier->LeverancierNummer }}</p>
                <p><strong>Mobile:</strong> {{ $supplier->Mobiel }}</p>
            </div>
        </div>
    
        <div class="card">
            <div class="card-header">
                <h2>Products Supplied</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Last Delivery Date</th>
                            <th>Quantity</th>
                            <th>Next Delivery Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($supplier->products as $product)
                        <tr>
                            <td>{{ $product->Naam }}</td>
                            <td>{{ $product->pivot->DatumLevering }}</td>
                            <td>{{ $product->pivot->Aantal }}</td>
                            <td>{{ $product->pivot->DatumEerstVolgendeLevering ?? 'Not scheduled' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>