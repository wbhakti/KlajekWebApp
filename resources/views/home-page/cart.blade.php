@extends('home-page.layouts.app-home')

@section('content')

<style>
    /* Pastikan tabel responsif */
    .table-responsive {
        overflow-x: auto; /* Izinkan scroll horizontal jika diperlukan */
    }

    .table {
        width: 100%; /* Pastikan tabel mengambil seluruh lebar kontainer */
        table-layout: auto; /* Biarkan kolom menyesuaikan ukuran konten */
    }

    .table-image {
        max-width: 60px;
        height: auto;
    }

    .font-heading {
        font-size: 16px;
    }

    .font-isi-nama {
        font-size: 14px;
    }

    .font-isi-harga {
        font-size: 14px;
    }

    .font-isi-jumlah {
        font-size: 14px;
    }

    .font-isi-total {
        font-size: 14px;
    }
    .font-isi-grandtotal {
        font-size: 16px;
    }
    /* Ukuran tombol default */
    .btn-small {
        font-size: 14px; /* Ukuran font lebih kecil */
        padding: 4px 8px; /* Kurangi padding */
    }

/* Gaya responsif untuk layar kecil */
    @media (max-width: 768px) {

    .table-responsive {
    overflow-x: hidden; /* Izinkan scroll horizontal jika diperlukan */
    }

    .table {
        width: 100%; /* Pastikan tabel mengambil seluruh lebar kontainer */
        table-layout: fixed; /* Biarkan kolom menyesuaikan ukuran konten */
    }

    .table th, .table td {
        padding: 2px; /* Kurangi padding */
    }

    .table-image {
        display: none; /* Hilangkan gambar */
    }

    

    .input-group .btn {
        font-size: 8px; /* Sesuaikan ukuran tombol */
    }

    .input-group input {
        width: 40px; /* Sesuaikan lebar input */
        font-size: 8px; /* Sesuaikan ukuran teks input */
    }

    .font-heading {
        font-size: 9px;
    }

    .font-isi-nama {
        word-break: break-word;
        font-size: 10px;
    }

    .font-isi-harga {
        font-size: 10px;
    }

    .font-isi-jumlah {
        font-size: 10px;
    }

    .font-isi-total {
        font-size: 10px;
    }
    .font-isi-grandtotal {
        font-size: 11px;
    }
    .btn-small {
        font-size: 10px; /* Ukuran font lebih kecil */
        padding: 2px 6px; /* Kurangi padding */
    }
}

</style>

<!-- Header -->
<div class="d-flex flex-wrap justify-content-center" style="gap: 1rem;">
    <div class="card" style="min-width: 150px;">
        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Favorit</div>
        <img class="card-img-top" src="{{ $merchant['image_url'] }}" alt="{{ $merchant['nama'] }}" />
        <div class="card-body d-flex flex-column justify-content-between text-center">
            <div>
                <h4 class="fw-bolder mb-1">{{ $merchant['nama'] }}</h4>
                <small class="text-muted d-block mb-2">{{ $merchant['deskripsi'] }}</small>
            </div>
        </div>
    </div>
</div>

<section class="py-4">

    <div class="container px-4 px-lg-5 mt-0">
        <h3 class="text-center mb-4">Keranjang Belanja</h3>
        <div class="card shadow-lg">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th class="font-heading">Nama Produk</th>
                                <th class="font-heading">Harga</th>
                                <th class="font-heading">Jumlah</th>
                                <th class="font-heading">Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($cart as $id => $item)
                            @php $total = $item['price'] * $item['quantity']; @endphp
                            <tr>
                                <td class="font-isi-nama">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item['image'] ?? asset('img/default-img.jpeg') }}" alt="{{ $item['name'] }}" class="img-fluid me-3 table-image">
                                        <span>{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="font-isi-harga">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="font-isi-jumlah">
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $id }}, -1)">-</button>
                                        <input type="text" class="form-control text-center jml-input" value="{{ $item['quantity'] }}" readonly id="quantity-{{ $id }}">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="updateQuantity({{ $id }}, 1)">+</button>
                                    </div>
                                </td>
                                <td class="font-isi-total" id="total-{{ $id }}">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-small">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @php $grandTotal += $total; @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end font-isi-grandtotal">Total Keseluruhan</th>
                                <th id="grand-total" class="font-isi-grandtotal">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
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
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#mapModal">
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
                    body: JSON.stringify({
                        quantity: currentQuantity
                    })
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
    document.getElementById('checkout-button').addEventListener('click', async function() {
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

        var nohpDriver = "6282220900097";
        var namaToko = "{{ $merchant['nama'] }}";
        var alamatToko = "{{ $merchant['deskripsi'] }}";
        var idMerchant = "{{ $merchant['id'] }}";

        var daftarProduk = "";
        var totalTagihan = 0;
        @foreach ($cart as $item)
            daftarProduk += "• {{ $item['name'] }} x{{ $item['quantity'] }} @Rp {{ number_format($item['price'], 0, ',', '.') }} = Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}%0A";
            totalTagihan += {{ $item['price'] * $item['quantity'] }};
        @endforeach
        var menu = daftarProduk;

        var totalTagihanFormatted = "Rp " + totalTagihan.toLocaleString('id-ID', { minimumFractionDigits: 0 });

        //hitung ongkir
        let biayaAntar = 20000;
        let fee = 2000;
        try {
            const [latitude, longitude] = longlat.value.split(',');
            const merchantId = idMerchant;

            const response = await fetch(`https://api.klajek.com/api/ongkir?merchant_id=${merchantId}&latitude=${latitude}&longitude=${longitude}`);
            if (response.ok) {
                const data = await response.json();
                biayaAntar = data.data["biaya_antar"];
                fee = data.data["fee"];
            } else {
                console.log("Gagal menghitung ongkir, menggunakan default ongkir.");
            }
        } catch (error) {
            console.log("Error menghitung ongkir:", error);
        }

        const totalBayar = totalTagihan + biayaAntar + fee;
        const biayaAntarFormatted = `Rp ${biayaAntar.toLocaleString('id-ID')}`;
        const feeFormatted = `Rp ${fee.toLocaleString('id-ID')}`;
        const totalBayarFormatted = `Rp ${totalBayar.toLocaleString('id-ID')}`;

        var lokasiPengantaran = "https://maps.google.com/?q=@" + longlat.value;

        // Format pesan WhatsApp
        var waLink = "https://wa.me/" + nohpDriver + "?text=" +
            "DAFTAR PEMESANAN%0A" + namaToko + "%0A" + alamatToko + "%0A%0A" + menu + "%0A" +
            "------------------------------%0A" +
            "Total Tagihan " + totalTagihanFormatted + "%0A" +
            "Biaya Antar " + biayaAntarFormatted + "%0A" +
            "Biaya Fee " + feeFormatted + "%0A" +
            "Total Bayar " + totalBayarFormatted + "%0A" +
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
        const initialPosition = { lat: -7.7114025, lng: 110.5974914 };

        map = new google.maps.Map(document.getElementById("map"), {
            center: initialPosition,
            zoom: 13,
        });

        // Tambahkan marker pada lokasi awal
        marker = new google.maps.Marker({
            position: initialPosition,
            map: map,
            draggable: true,
        });

        marker.addListener("dragend", function () {
            const newPosition = marker.getPosition();
            const newLat = newPosition.lat();
            const newLng = newPosition.lng();

            updateAddress(newLat, newLng);
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    const userLocation = { lat: userLat, lng: userLng };
                    map.setCenter(userLocation);
                    marker.setPosition(userLocation);

                    updateAddress(userLat, userLng);
                },
                function () {
                    updateAddress(initialPosition.lat, initialPosition.lng);
                }
            );
        } else {
            updateAddress(initialPosition.lat, initialPosition.lng);
        }
    }

    async function updateAddress(lat, lng) {
        const addressField = document.getElementById("address");
        const longlat = document.getElementById("longlat");
        const apiKey = "AIzaSyB1kT5Kf-JiXJtg4taoWOZ5WuvqPertrjg";
        const response = await fetch(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}`);
        const data = await response.json();
        console.log(lat + " " + lng);
        if (data.status === "OK" && data.results[0]) {
            addressField.value = data.results[0].formatted_address;
            longlat.value = `${lat},${lng}`;
        } else {
            addressField.value = 'Alamat tidak ditemukan';
            longlat.value = '-7.7114025,110.5974914'; // Lokasi default
        }
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1kT5Kf-JiXJtg4taoWOZ5WuvqPertrjg&callback=initMap"></script>


@endsection