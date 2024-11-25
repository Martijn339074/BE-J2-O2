<x-layout>
    <div class="container">
        <h1>Levering product - {{ $product->Naam }}</h1>
    
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <script>
                    setTimeout(function() {
                        window.location.href = '{{ route('suppliers.products', $supplier->Id) }}';
                    }, 4000);
                </script>
            </div>
        @endif
    
        <div class="card">
            <div class="card-body">
                <form action="{{ route('suppliers.process-delivery', [$supplier->Id, $product->Id]) }}" method="POST">
                    @csrf
    
                    <div class="mb-3">
                        <label for="aantal" class="form-label">Aantal producteenheden</label>
                        <input type="number" 
                               class="form-control @error('aantal') is-invalid @enderror" 
                               id="aantal" 
                               name="aantal" 
                               value="{{ old('aantal') }}"
                               required>
                        @error('aantal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-3">
                        <label for="volgende_levering" class="form-label">Datum eerstvolgende levering</label>
                        <input type="date" 
                               class="form-control @error('volgende_levering') is-invalid @enderror" 
                               id="volgende_levering" 
                               name="volgende_levering" 
                               value="{{ old('volgende_levering') }}"
                               required>
                        @error('volgende_levering')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Sla op</button>
                        <a href="{{ route('suppliers.products', $supplier->Id) }}" class="btn btn-secondary">Annuleren</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </x-layout>