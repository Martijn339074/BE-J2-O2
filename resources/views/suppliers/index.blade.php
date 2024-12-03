<x-layout>
    <div class="container">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1>Suppliers</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Contact Persoon</th>
                    <th>Leverancier Nummer</th>
                    <th>Telefoon Nummer</th>
                    <th>Aantal Producten</th>
                    <th>Acties</th>
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
                        <a href="{{ route('suppliers.show', $supplier->Id) }}" class="btn btn-primary btn-sm">Zie Producten</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>