@extends('home-page.layouts.app-home')

@section('content')

<!-- Header -->
<header class="bg-dark py-5">
    <!-- Overlay Background -->
    <div class="text-center text-white" style="position: relative;">
        
        <!-- Teks -->
        <div style="position: relative; z-index: 2;">
            <h1 class="display-4 fw-bolder">Terima Kasih</h1>
            <p class="lead fw-normal text-white-50 mb-0"></p>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container text-center">
        <div class="alert alert-success" role="alert">
            <h4 class="alert-heading">Pembelian Anda Telah Sukses!</h4>
            <p>Terima kasih atas kepercayaan Anda. Pembelian Anda telah berhasil diproses. Anda akan menerima konfirmasi lebih lanjut melalui whatsapp.</p>
            <hr>
            <p>Silahkan selesaikan pembayaran Anda</p>
            <hr>
            <p class="mb-0">Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami.</p>
        </div>
    </div>
</section>

@endsection
