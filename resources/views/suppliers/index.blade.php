<x-layout>

    <div class="container">
        <h1>Suppliers</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Person</th>
                    <th>Supplier Number</th>
                    <th>Mobile</th>
                    <th>Number of Products</th>
                    <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->Id }}</td>
                <td>{{ $supplier->Naam }}</td>
                <td>{{ $supplier->ContactPersoon }}</td>
                <td>{{ $supplier->LeverancierNummer }}</td>
                <td>{{ $supplier->Mobiel }}</td>
                <td>{{ $supplier->products_count }}</td>
                <td>
                    <a href="{{ route('suppliers.show', $supplier->Id) }}" class="btn btn-primary btn-sm">View Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</x-layout>