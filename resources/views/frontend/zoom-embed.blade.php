
<!DOCTYPE html>

<head>
    <title>Zoom WebSDK CDN</title>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="origin-trial" content="">
</head>

<body>
    <div class="container">
        <main id="zmmtg-root"></main>
    </div>

    <script src="https://source.zoom.us/4.0.0/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/4.0.0/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/4.0.0/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/4.0.0/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/4.0.0/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-4.0.0.min.js"></script>
        
    <script>
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareWebSDK();

        const sdkKey = "{{ env('ZOOM_SDK_KEY') }}";
        const meetingNumber = "{{ $liveClass->zoom_meeting_id }}";
        const passWord = "{{ $liveClass->password }}";
        const userName = "{{ auth()->user()->name }}";
        const userEmail = "{{ auth()->user()->email }}";
        const role = "{{ optional(auth()->user())->account_type == 'tutor' ? 1 : 0 }}";
        const leaveUrl = "{{ route('admin.live-classes.index') }}";

        function getSignature(meetingNumber, role) {
            return fetch("{{ route('zoom.signature') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ meetingNumber: meetingNumber, role: role })
            })
            .then(response => response.json())
            .then(data => data.signature);
        }

        getSignature(meetingNumber, role).then(signature => {
            if (!signature) {
                console.error("Gagal mendapatkan signature.");
                return;
            }

            ZoomMtg.init({
                leaveUrl: leaveUrl,
                isSupportAV: true,
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
        });

    </script>
</body>

</html>