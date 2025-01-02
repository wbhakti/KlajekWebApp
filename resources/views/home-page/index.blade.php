<!-- resources/views/home.blade.php -->
@extends('home-page.layouts.app-home')

@section('content')

<!-- Header-->
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">KLAJEK</h1>
            <p class="lead fw-normal text-white-50 mb-0">Kami adalah aplikasi pengiriman makanan terbaik yang siap membantu Anda menikmati hidangan favorit Anda dengan mudah dan cepat.</p>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-0">

        <!-- Pilihan Restoran -->
        <div class="text-center">
            <h4 class="fw-bolder mb-4">Daftar Restoran</h4>
        </div>
        <div class="d-flex flex-wrap justify-content-center" style="gap: 1rem;">
            @foreach ($restoran['data'] as $item)
                <div class="card" style="min-width: 150px;">
                    <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Baru</div>
                    <img class="card-img-top" src="{{ $item['image_url'] }}" alt="{{ $item['nama'] }}" />
                    <div class="card-body d-flex flex-column justify-content-between text-center">
                        <div>
                            <h6 class="fw-bolder mb-1">{{ $item['nama'] }}</h6>
                            <small class="text-muted d-block mb-2">{{ $item['deskripsi'] }}</small>
                        </div>
                        <form action="/restoran/{{ $item['id'] }}" method="GET" class="mt-auto">
                            <button type="submit" class="btn btn-primary btn-sm">Pilih Resto</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@if (session('error'))
<script>
    alert('{{ session('error') }}');
</script>
@endif

@if (session('duplicate'))
    <form id="clear-cart-form" action="/restoran/{{ session('merchantNew') }}" method="GET" style="display: none;">
        <input type="hidden" name="reset" value="Y">
    </form>

    <script>
        if (confirm('{{ session('duplicate') }}')) {
            document.getElementById('clear-cart-form').submit();
        }
    </script>
@endif

@endsection
