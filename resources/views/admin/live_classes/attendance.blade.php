@extends('admin.layouts.master')

@section('content')
<div class="content-inner container-fluid pb-0" id="page_layout">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
                    <div class="header-title">
                        <h4 class="card-title mb-0">Laporan Absensi</h4>
                        <p class="mb-0">Kelas: **{{ $liveClass->topic->name ?? 'N/A' }}**</p>
                    </div>
                    <a href="{{ route('admin.live-classes.index') }}" class="btn btn-light">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive rounded py-4 table-space">
                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama Peserta (di Aplikasi)</th>
                                    <th>Email/Nama di Zoom</th>
                                    <th>Waktu Masuk</th>
                                    <th>Waktu Keluar</th>
                                    <th>Durasi (Menit)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($matchedParticipants as $data)
                                    <tr>
                                        <td>
                                            @if($data['app_user'])
                                                <span class="text-success">✅ <strong>{{ $data['app_user']->name }}</strong></span>
                                            @else
                                                <span class="text-danger">❌ (Tamu/Tidak Dikenali)</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $data['zoom_data']['user_email'] ?? $data['zoom_data']['name'] }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($data['zoom_data']['join_time'])->timezone('Asia/Jakarta')->format('H:i:s') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data['zoom_data']['leave_time'])->timezone('Asia/Jakarta')->format('H:i:s') }}</td>
                                        <td>{{ round($data['zoom_data']['duration'] / 60) }} Menit</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p class="mb-0">Tidak ada data partisipan yang ditemukan.</p>
                                            <small>Laporan mungkin belum siap atau tidak ada peserta yang bergabung.</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection