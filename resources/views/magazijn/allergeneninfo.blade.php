<x-layout>

    <div class="container">
        <h1>{{ $title }}</h1>
        
        @if (isset($message))
        <div class="alert alert-info">
            {{ $message }}
        </div>
        @endif
        
        @if (isset($redirect) && $redirect)
        <script>
            setTimeout(() => {
                window.location.href = "{{ $redirectUrl }}";
            }, {{ $redirectTime }});
        </script>
    @else
    @if (isset($product))
    <div>
        <h3>Productinformatie</h3>
        <p><strong>Naam:</strong> {{ $product->ProductNaam }}</p>
        <p><strong>Barcode:</strong> {{ $product->Barcode }}</p>
    </div>
    @endif
    
    @if (isset($allergenen) && count($allergenen) > 0)
    <div>
        <h3>Allergenen</h3>
        <ul>
            @foreach ($allergenen as $allergeen)
            <li>{{ $allergeen->Naam }}</li>
            @endforeach
        </ul>
    </div>
    @else
    <p>Geen allergenen gevonden voor dit product.</p>
        @endif
        @endif
    </div>
</x-layout>