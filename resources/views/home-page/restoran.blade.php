<!-- resources/views/home.blade.php -->
@extends('home-page.layouts.app-home')

@section('content')

<style>
    .kategori-select {
        border: 2px solid #007bff;
        border-radius: 5px;
        padding: 10px;
        font-size: 1.2rem;
        color: #007bff;
        background-color: #f8f9fa;
    }

    .kategori-select:focus {
        border-color: #0056b3;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
</style>

<!-- Header -->
<header class="bg-dark py-5" style="background-image: url('{{ $merchant['image_url'] }}'); background-size: cover; background-position: center;">
    <div class="container px-4 px-lg-5 my-5">
        <!-- Overlay Background -->
        <div class="text-center text-white" style="position: relative;">
            <!-- Overlay effect -->
            <div class="overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 1;"></div>

            <!-- Teks -->
            <div style="position: relative; z-index: 2;">
                <h1 class="display-4 fw-bolder">{{ $merchant['nama'] }}</h1>
                <p class="lead fw-normal text-white-50 mb-0">{{ $merchant['deskripsi'] }}</p>
            </div>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-0">

        <!-- Pilihan Kategori -->
        <div class="text-center mb-4">
            <h4 class="fw-bolder">Kategori Menu</h4>
        </div>
        <div class="form-group">
            <select class="form-select form-select-lg kategori-select" id="kategoriSelect">
                <option value="all" data-kategori="all" selected>SEMUA MENU</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item['id'] }}" data-kategori="{{ $item['nama'] }}" {{ request()->query('kategori') == $item['nama'] ? 'selected' : '' }}>
                        {{ $item['nama'] }}
                    </option>
                @endforeach
            </select>            
        </div>
        
        <!-- List makanan -->
        <div class="text-center">
            <h4 class="fw-bolder mt-5 mb-4">Pilihan Makanan</h4>
        </div>

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @if(!empty($produk['data']))
                @foreach ($produk['data'] as $item)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Sale badge-->
                        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                        <!-- Product image-->
                        <img class="card-img-top" src="{{ $item['image_url'] }}" alt="..." onerror="this.onerror=null;this.src='{{ asset('img/default-img.jpeg') }}';"/>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name with modal trigger-->
                                <h5 class="fw-bolder" style="font-size: 14px;" data-bs-toggle="modal" data-bs-target="#modal{{ $item['id'] }}">{{ $item['nama'] }}</h5>
                                <!-- Product reviews-->
                                <div class="d-flex justify-content-center small text-warning mb-2">
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                    <div class="bi-star-fill"></div>
                                </div>
                                <!-- Product price-->
                                Rp {{ $item['harga'] }}
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto btn-add-to-cart" href="javascript:void(0)" 
                                data-id="{{ $item['id'] }}" 
                                data-name="{{ $item['nama'] }}" 
                                data-price="{{ $item['harga'] }}"
                                data-idmerchant="{{ $merchant['id'] }}"
                                data-img="{{ $item['image_url'] }}">
                                Add to cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modal{{ $item['id'] }}" tabindex="-1" aria-labelledby="modalLabel{{ $item['id'] }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $item['id'] }}">{{ $item['nama'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Harga:</strong> Rp {{ $item['harga'] }}</p>
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['nama'] }}" class="img-fluid" onerror="this.onerror=null;this.src='{{ asset('img/default-img.jpeg') }}';"/>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a class="btn btn-primary btn-add-to-cart" href="javascript:void(0)" 
                                    data-id="{{ $item['id'] }}" 
                                    data-name="{{ $item['nama'] }}" 
                                    data-price="{{ $item['harga'] }}"
                                    data-idmerchant="{{ $merchant['id'] }}"
                                    data-img="{{ $item['image_url'] }}">
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        
    </div>
</section>

<script>
    $(document).on('click', '.btn-add-to-cart', function () {
        const productId = $(this).data('id');
        const productName = $(this).data('name');
        const productPrice = $(this).data('price');
        const merchant = $(this).data('idmerchant');
        const productImage = $(this).data('img');

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: productId,
                name: productName,
                price: productPrice,
                quantity: 1, // Default
                merchantId: merchant,
                productImage: productImage,
            },
            success: function (response) {
                alert(response.message);
                $('#cart-badge').text(Object.keys(response.cart).length);
            },
            error: function (xhr) {
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const kategoriSelect = document.getElementById('kategoriSelect');
        kategoriSelect.addEventListener('change', function () {
            const kategori = this.options[this.selectedIndex].getAttribute('data-kategori');
            const merchantId = "{{ $merchant['id'] }}";
            if (kategori) {
                window.location.href = `/restoran/${merchantId}?kategori=${encodeURIComponent(kategori)}`;
            }
        });
    });
</script>


@endsection