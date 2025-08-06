@extends('frontend.layouts.app2')

@section('content')
@extends('frontend.layouts.app2')

@section('content')
<div class="main-wrapper my-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 text-center">
                    <div class="card-body p-4 p-md-5">

                        @if($isVerified)

                            @if(isset($billplz['paid']) && $billplz['paid'] === 'true')
                                <div class="success-icon mb-4">
                                    <img src="/frontpage/assets/img/logo.svg" class="logo" alt="Logo">
                                </div>
                                <h2 class="h3 mb-2">Pembayaran Berhasil!</h2>
                                <p class="text-muted mb-4">
                                    Terima kasih! Langganan Anda sedang kami proses dan akan segera aktif. Konfirmasi akan dikirimkan ke email Anda.
                                </p>
                                <div class="bg-light rounded p-3 mb-4">
                                    <p class="mb-1 small text-muted">Transaction ID:</p>
                                    <h5 class="mb-0 font-monospace">{{ $billplz['id'] ?? 'N/A' }}</h5>
                                </div>
                            @else
                                <div class="pending-icon mb-4">
                                    <img src="/frontpage/assets/img/logo.svg" class="logo" alt="Logo">
                                </div>
                                <h2 class="h3 mb-2">Pembayaran Belum Selesai</h2>
                                <p class="text-muted mb-4">
                                    Sepertinya pembayaran Anda dibatalkan atau belum selesai. Silakan coba lagi atau hubungi dukungan jika Anda mengalami masalah.
                                </p>
                            @endif

                        @else
                            <div class="pending-icon mb-4">
                                <img src="/frontpage/assets/img/logo.svg" class="logo" alt="Logo">
                            </div>
                            <h2 class="h3 mb-2">Pembayaran Sedang Diproses</h2>
                            <p class="text-muted mb-4">
                                Kami sedang menunggu konfirmasi akhir status pembayaran Anda dari server. Halaman ini akan diperbarui secara otomatis.
                            </p>
                        @endif

                        <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4">
                            Kembali ke Halaman Utama
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('styles')
<style>
    .success-icon svg, .pending-icon svg {
        width: 80px;
        height: 80px;
    }
    .success-icon svg circle {
        stroke: #198754;
        stroke-width: 2;
        fill: none;
    }
    .success-icon svg path {
        fill: #198754;
    }
    .pending-icon svg {
        color: #ffc107;
    }
</style>
@endpush