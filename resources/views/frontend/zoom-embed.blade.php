@extends('frontend.layouts.zoom')

@section('content')
<div class="container">
    <main id="zmmtg-root"></main>
</div>
@endsection


@push('scripts')
<script src="https://source.zoom.us/4.0.0/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/4.0.0/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/4.0.0/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/4.0.0/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/4.0.0/lib/vendor/lodash.min.js"></script>
<script src="https://source.zoom.us/zoom-meeting-4.0.0.min.js"></script>
    
    <script>
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareWebSDK();

        // Siapkan data dari backend Laravel
        const sdkKey = "{{ env('ZOOM_SDK_KEY') }}";
        const meetingNumber = "{{ $liveClass->zoom_meeting_id }}";
        const passWord = "{{ $liveClass->password }}";
        const userName = "{{ auth()->user()->name }}";
        const userEmail = "{{ auth()->user()->email }}";
        const role = "{{ optional(auth()->user())->account_type == 'tutor' ? 1 : 0 }}";
        const leaveUrl = "{{ route('admin.live-classes.index') }}";

        // Fungsi untuk mengambil signature dari server Laravel
        function getSignature(meetingNumber, role) {
            return fetch("{{ route('zoom.signature') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ meetingNumber: meetingNumber, role: role })
            })
            .then(response => response.json())
            .then(data => data.signature);
        }

        // Jalankan prosesnya
        getSignature(meetingNumber, role).then(signature => {
            if (!signature) {
                console.error("Gagal mendapatkan signature.");
                return;
            }

            // ======================= AWAL PERUBAHAN =======================
            // Kode inisialisasi untuk Client View
            
            // Kita tidak lagi menggunakan createClient() atau fungsi joinMeeting() terpisah
            ZoomMtg.init({
                leaveUrl: leaveUrl,
                isSupportAV: true,
                // Panggilan untuk join meeting sekarang ada di dalam success callback dari init
                success: function () {
                    ZoomMtg.join({
                        signature: signature,
                        sdkKey: sdkKey,
                        meetingNumber: meetingNumber,
                        passWord: passWord,
                        userName: userName,
                        userEmail: userEmail,
                        success: function (res) {
                            console.log("Berhasil bergabung ke meeting:", res);
                        },
                        error: function (res) {
                            console.error("Gagal bergabung:", res);
                        }
                    });
                },
                error: function (res) {
                    console.error("Inisialisasi SDK gagal:", res);
                }
            });
            // ======================= AKHIR PERUBAHAN ======================
        });

    </script>
@endpush