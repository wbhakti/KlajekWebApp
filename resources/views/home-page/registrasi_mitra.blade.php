@extends('home-page.layouts.app-home')

@section('content')

<section class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Registrasi Mitra</h1>
        </div>
        <div class="mb-4 text-white" >
            <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
        </div>
        <div class="mb-4 text-white" >
            <label for="resto" class="form-label fw-bold">Nama Resto</label>
            <input type="text" class="form-control" id="resto" name="resto" placeholder="Nama Resto" required>
        </div>
        <div class="mb-4 text-white">
            <label for="alamat" class="form-label fw-bold">Alamat</label>
            <textarea name="alamat" class="form-control" id="alamat" cols="40" rows="5" placeholder="Alamat lengkap resto" required></textarea>
        </div>
        <div class="mb-4 text-white" >
            <label for="phone" class="form-label fw-bold">Nomer Handphone (WA)</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nomer Handphone" required>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="kirim-button" class="btn btn-primary" style="margin-bottom: 10px;">Kirim</button>
        </div>
    </div>
</section>

<script>
    document.getElementById('kirim-button').addEventListener('click', async function() {
        var namaInput = document.getElementById('nama');
        var restoInput = document.getElementById('resto');
        var alamatInput = document.getElementById('alamat');
        var phoneInput = document.getElementById('phone');


        if (!namaInput || namaInput.value.trim() === "") {
            alert("Nama lengkap harus diisi!");
            return false;
        }
        if (!restoInput || restoInput.value.trim() === "") {
            alert("Nama Resto harus diisi!");
            return false;
        }
        if (!alamatInput || alamatInput.value.trim() === "") {
            alert("Alamat Resto harus diisi!");
            return false;
        }
        if (!phoneInput || phoneInput.value.trim() === "") {
            alert("Nomor Handphone harus diisi!");
            return false;
        }

        var nohpDriver = "6282220900097";

        // Format pesan WhatsApp
        var waLink = "https://wa.me/" + nohpDriver + "?text=" +
            "Nama Lengkap : " + namaInput.value + "%0A" +
            "Nama Resto : " + restoInput.value + "%0A" +
            "Alamat Resto : " + alamatInput.value + "%0A" +
            "Nomor Handphone : " + phoneInput.value;
            window.open(waLink, '_blank');
    });
</script>

@endsection
