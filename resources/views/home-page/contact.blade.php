@extends('home-page.layouts.app-home')

@section('content')

<section class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">HUBUNGI KAMI</h1>
        </div>
        <div class="mb-4 text-white" >
            <label for="nama" class="form-label fw-bold">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap" required>
        </div>
        <div class="mb-4 text-white">
            <label for="phone" class="form-label fw-bold">Pesan</label>
            <textarea name="pesan" class="form-control" id="pesan" cols="40" rows="5" placeholder="Masukan Pertanyaan" required></textarea>
        </div>
        <div class="card-footer text-end">
            <button type="button" id="kirim-button" class="btn btn-primary" style="margin-bottom: 10px;">Kirim</button>
        </div>
    </div>
</section>

<script>
    document.getElementById('kirim-button').addEventListener('click', async function() {
        var namaInput = document.getElementById('nama');
        var pesanInput = document.getElementById('pesan');


        if (!namaInput || namaInput.value.trim() === "") {
            alert("Nama lengkap harus diisi!");
            return false;
        }

        if (!pesanInput || pesanInput.value.trim() === "") {
            alert("Pesan harus diisi!");
            return false;
        }

        var nohpDriver = "6282220900097";

        // Format pesan WhatsApp
        var waLink = "https://wa.me/" + nohpDriver + "?text=" +
            "Nama Lengkap : " + namaInput.value + "%0A" +
            "Pesan/Pertanyaan : " + pesanInput.value;
            window.open(waLink, '_blank');
    });
</script>

@endsection