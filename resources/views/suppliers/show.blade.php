<x-layout>
    <div class="container">
        <h1>Geleverde producten - {{ $supplier->Naam }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($supplier->products->isEmpty())
            <div class="alert alert-warning" role="alert">
                Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin.
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Aantal in magazijn</th>
                                <th>Laatste levering</th>
                                <th>Aantal volgende levering</th>
                                <th>Volgende levering</th>
                                <th>Nieuwe levering</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supplier->products as $product)
                                <tr>
                                    <td>{{ $product->Naam }}</td>
                                    <td>{{ $product->magazine->AantalAanwezig ?? 0 }}</td>
                                    <td>{{ $product->pivot->DatumLevering }}</td>
                                    <td>{{ $product->pivot->Aantal }}</td>
                                    <td>{{ $product->pivot->DatumEerstVolgendeLevering ?? 'Niet gepland' }}</td>
                                    <td>
                                        <a href="{{ route('suppliers.delivery-form', [$supplier->Id, $product->Id]) }}"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div class="mt-3">
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Terug naar overzicht</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.delete-product').click(function() {
                var productId = $(this).data('product-id');
                if (confirm('Weet u zeker dat u dit product wilt verwijderen?')) {
                    $('#delete-product-' + productId).submit();
                }
            });
        });
    </script>
</x-layout>
