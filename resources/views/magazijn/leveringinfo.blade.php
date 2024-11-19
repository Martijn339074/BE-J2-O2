<x-layout>
    <div class="container mt-4">
        <h1 class="text-center">{{ $title }}</h1>

        @if (isset($message))
            <div class="alert alert-warning text-center" role="alert">
                {{ $message }}
            </div>
        @endif

        @if (isset($product))
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Productinformatie
                </div>
                <div class="card-body">
                    <p><strong>Naam:</strong> {{ $product->ProductNaam }}</p>
                    <p><strong>Barcode:</strong> {{ $product->Barcode }}</p>
                    <p><strong>VerpakkingsEenheid:</strong> {{ $product->VerpakkingsEenheid }}</p>
                    <p><strong>Aantal Aanwezig:</strong> {{ $product->AantalAanwezig }}</p>
                </div>
            </div>
        @endif

        @if (isset($leverancier))
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    Leverancierinformatie
                </div>
                <div class="card-body">
                    <p><strong>Naam:</strong> {{ $leverancier->Naam }}</p>
                    <p><strong>Contactpersoon:</strong> {{ $leverancier->Contactpersoon }}</p>
                    <p><strong>Mobiel Nummer:</strong> {{ $leverancier->MobielNummer }}</p>
                </div>
            </div>
        @endif

        @if (isset($leveringen) && count($leveringen) > 0)
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    Leveringsgeschiedenis
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Datum Levering</th>
                                <th>Aantal Geleverd</th>
                                <th>Verwachte LeveringsDatum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leveringen as $levering)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($levering->DatumLevering)) }}</td>
                                    <td>{{ $levering->AantalGeleverd }}</td>
                                    <td>{{ $levering->VerwachteLeveringsDatum ? date('d-m-Y', strtotime($levering->VerwachteLeveringsDatum)) : 'Onbekend' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info text-center" role="alert">
                Er zijn geen leveringen gevonden voor dit product.
            </div>
        @endif

        <a href="{{ route('magazijn.index') }}" class="btn btn-secondary mt-4">Terug naar overzicht</a>
    </div>
</x-layout>
