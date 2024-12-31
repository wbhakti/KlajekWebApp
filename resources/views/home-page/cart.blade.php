@extends('home-page.layouts.app-home')

@section('content')

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
        <h3 class="text-center mb-4">Keranjang Belanja</h3>
        <div class="card shadow-lg">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($cart as $id => $item)
                                @php $total = $item['price'] * $item['quantity']; @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['image'] ?? asset('img/default-img.jpeg') }}" alt="{{ $item['name'] }}" class="img-fluid me-3" style="max-width: 60px; height: auto;">
                                            <span>{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $id }}, -1)">-</button>
                                            <input type="text" class="form-control text-center" value="{{ $item['quantity'] }}" style="width: 50px;" readonly id="quantity-{{ $id }}">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $id }}, 1)">+</button>
                                        </div>
                                    </td>
                                    <td id="total-{{ $id }}">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @php $grandTotal += $total; @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">Total Keseluruhan</th>
                                <th id="grand-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <hr>
                <h3 class="mb-4">Info Pengiriman</h3>
                <div class="mb-4">
                    <label for="nama" class="form-label fw-bold">Nama Pemesan</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama pemesan" required>
                </div>
                <div class="mb-4">
                    <label for="phone" class="form-label fw-bold">Nomor HP / WA</label>
                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Nomor HP pemesan" required>
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label fw-bold">Alamat Pengiriman</label>
                    <button type="button" class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#mapModal">
                        Lokasi saya
                    </button>
                    <input type="text" name="longlat" id="longlat" value="" hidden>
                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Klik peta untuk memilih alamat"></textarea>
                </div>

                <!-- Modal untuk menampilkan peta -->
                <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="map" style="height: 400px; border: 1px solid #ddd;"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer text-end">
                <a href="/restoran/{{ $merchant['id'] }}" class="btn btn-outline-secondary me-2" style="margin-bottom: 10px;">Lanjut Belanja</a>
                <button type="button" id="checkout-button" class="btn btn-primary" style="margin-bottom: 10px;">Checkout</button>
            </div>
        </div>
    </div>

</section>

<script>
    function updateQuantity(itemId, change) {
        const quantityInput = document.getElementById(`quantity-${itemId}`);
        let currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity + change > 0) {
            currentQuantity += change;
            quantityInput.value = currentQuantity;

            fetch(`/update-cart/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: currentQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    const totalElement = document.getElementById(`total-${itemId}`);
                    if (totalElement) {
                        const total = data.itemTotal;
                        totalElement.textContent = `Rp ${total}`;
                    }

                    document.getElementById('grand-total').textContent = `Rp ${data.grandTotal}`;
                } else {
                    alert('Gagal memperbarui jumlah item.');
                }
            });
        }
    }
</script>

<script>
    document.getElementById('checkout-button').addEventListener('click', function () {
        var phoneInput = document.getElementById('phone');
        var addressInput = document.getElementById('address');
        var nama = document.getElementById('nama');
        var longlat = document.getElementById('longlat');

        if (!phoneInput || phoneInput.value.trim() === "") {
            alert("Nomor HP harus diisi!");
            return false;
        }

        var nomorHp = phoneInput.value.trim();
        if (nomorHp.startsWith("0")) {
            nomorHp = "62" + nomorHp.substring(1);
        }

        var nohpDriver = "6282183254364";
        var namaToko = "{{ $merchant['nama'] }}";
        var alamatToko = "{{ $merchant['deskripsi'] }}";

        var daftarProduk = "";
        var totalTagihan = 0;
        @foreach ($cart as $item)
            daftarProduk += "• {{ $item['name'] }} x{{ $item['quantity'] }} @Rp {{ number_format($item['price'], 0, ',', '.') }} = Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}%0A";
            totalTagihan += {{ $item['price'] * $item['quantity'] }};
        @endforeach
        var menu = daftarProduk;

        var totalTagihanFormatted = "Rp " + totalTagihan.toLocaleString('id-ID', { minimumFractionDigits: 0 });
        var biayaAntar = "Rp 10.000"; 
        var lokasiPengantaran = "https://maps.google.com/?q=@" + longlat.value;

        // Format pesan WhatsApp
        var waLink = "https://wa.me/" + nohpDriver + "?text=" +
            "DAFTAR PEMESANAN%0A" + namaToko + "%0A" + alamatToko + "%0A%0A" + menu + "%0A" +
            "------------------------------%0A" +
            "Total Tagihan " + totalTagihanFormatted + "%0A" +
            "Biaya Antar " + biayaAntar + "%0A" +
            "Pembayaran Transfer%0A%0A" +
            "Data Pemesan%0A" +
            "Nama : " + nama.value + "%0A" +
            "Nomor Handphone : " + nomorHp + "%0A" +
            "Alamat : " + addressInput.value + "%0A%0A" +
            "------------------------------%0A" +
            "Lokasi Pengantaran%0A" + lokasiPengantaran;

        window.open(waLink, '_blank');
        window.location.href = '/checkout';
    });
</script>

<script>
    let map, marker;

    function initMap() {
        const initialPosition = { lat: -7.7114025, lng: 110.5974914 }; // Koordinat awal jika lokasi pengguna tidak ditemukan

        map = new google.maps.Map(document.getElementById("map"), {
            center: initialPosition,
            zoom: 13,
        });

        // Tambahkan marker pada lokasi awal
        marker = new google.maps.Marker({
            position: initialPosition,
            map: map,
            draggable: false, // Marker tidak bisa dipindahkan
        });

        // Cek apakah Geolocation API tersedia dan dapat digunakan
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    // Update peta ke lokasi pengguna
                    const userLocation = { lat: userLat, lng: userLng };
                    map.setCenter(userLocation);
                    marker.setPosition(userLocation);

                    // Update alamat saat marker dipindahkan
                    updateAddress(userLat, userLng);
                },
                function () {
                    updateAddress(initialPosition.lat, initialPosition.lng); // Gunakan lokasi default
                }
            );
        } else {
            updateAddress(initialPosition.lat, initialPosition.lng); // Gunakan lokasi default
        }
    }

    // Fungsi untuk mengambil alamat dari Google Maps API
    async function updateAddress(lat, lng) {
        const addressField = document.getElementById("address");
        const longlat = document.getElementById("longlat");
        const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await response.json();
        if (data && data.display_name) {
            addressField.value = `${data.display_name}`;
            longlat.value = `${lat},${lng}`;
        } else {
            addressField.value = 'Isi alamat pengiriman';
            longlat.value = '-7.7114025,110.5974914';
        }
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1kT5Kf-JiXJtg4taoWOZ5WuvqPertrjg&callback=initMap"></script>


@endsection
