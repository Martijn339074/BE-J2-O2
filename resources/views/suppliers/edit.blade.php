<x-layout>
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1>Bewerk Leverancier: {{ $supplier->Naam }}</h1>

        <form id="editForm" action="{{ route('suppliers.update', $supplier->Id) }}" method="POST" class="mt-4">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="Naam" class="form-label">Naam</label>
                        <input type="text" class="form-control @error('Naam') is-invalid @enderror" id="Naam"
                            name="Naam" value="{{ old('Naam', $supplier->Naam) }}" required>
                        @error('Naam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ContactPersoon" class="form-label">Contact Persoon</label>
                        <input type="text" class="form-control @error('ContactPersoon') is-invalid @enderror"
                            id="ContactPersoon" name="ContactPersoon"
                            value="{{ old('ContactPersoon', $supplier->ContactPersoon) }}" required>
                        @error('ContactPersoon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="LeverancierNummer" class="form-label">Leverancier Nummer</label>
                        <input type="text" class="form-control @error('LeverancierNummer') is-invalid @enderror"
                            id="LeverancierNummer" name="LeverancierNummer"
                            value="{{ old('LeverancierNummer', $supplier->LeverancierNummer) }}" required>
                        @error('LeverancierNummer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Mobiel" class="form-label">Mobiel</label>
                        <input type="text" class="form-control @error('Mobiel') is-invalid @enderror" id="Mobiel"
                            name="Mobiel" value="{{ old('Mobiel', $supplier->Mobiel) }}" required>
                        @error('Mobiel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h3>Contact Informatie</h3>
                    <div class="mb-3">
                        <label for="Straat" class="form-label">Straat</label>
                        <input type="text" class="form-control @error('Straat') is-invalid @enderror" id="Straat"
                            name="Straat" value="{{ old('Straat', $supplier->contact->Straat) }}" required>
                        @error('Straat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Huisnummer" class="form-label">Huisnummer</label>
                        <input type="number" class="form-control @error('Huisnummer') is-invalid @enderror"
                            id="Huisnummer" name="Huisnummer"
                            value="{{ old('Huisnummer', $supplier->contact->Huisnummer) }}" required>
                        @error('Huisnummer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Postcode" class="form-label">Postcode</label>
                        <input type="text" class="form-control @error('Postcode') is-invalid @enderror"
                            id="Postcode" name="Postcode" value="{{ old('Postcode', $supplier->contact->Postcode) }}"
                            required>
                        @error('Postcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Stad" class="form-label">Stad</label>
                        <input type="text" class="form-control @error('Stad') is-invalid @enderror" id="Stad"
                            name="Stad" value="{{ old('Stad', $supplier->contact->Stad) }}" required>
                        @error('Stad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('suppliers.show', $supplier->Id) }}" class="btn btn-secondary">Annuleren</a>
                <button type="submit" class="btn btn-primary">Opslaan</button>
            </div>
        </form>
    </div>
</x-layout>