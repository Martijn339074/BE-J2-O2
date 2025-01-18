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

        <h1>Leveranciers</h1>

        @if($suppliers->isEmpty())
            <div class="alert alert-warning" role="alert">
                Er zijn momenteel geen leveranciers beschikbaar.
            </div>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
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
                            <td>{{ $supplier->Naam }}</td>
                            <td>{{ $supplier->ContactPersoon }}</td>
                            <td>{{ $supplier->LeverancierNummer }}</td>
                            <td>{{ $supplier->Mobiel }}</td>
                            <td>{{ $supplier->products_count }}</td>
                            <td>
                                <a href="{{ route('suppliers.show', $supplier->Id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-box"></i>
                                </a>
                                <a href="{{ route('suppliers.edit', $supplier->Id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center mt-4">
                {{ $suppliers->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
</x-layout>