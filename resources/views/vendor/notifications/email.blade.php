<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Template</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #f4f4f4; }

        .body-text {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }
        .button {
            background-color: #FF4667;
            border-radius: 5px;
            color: #ffffff;
            display: inline-block;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 16px;
            font-weight: bold;
            line-height: 50px;
            text-align: center;
            text-decoration: none;
            width: 200px;
        }
        .footer-text {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #888888;
        }
    </style>
</head>
<body style="margin: 0 !important; padding: 0 !important; background-color: #f4f4f4;">

    <div style="display: none; font-size: 1px; color: #f4f4f4; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        {{ $preheader ?? '' }}
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="background-color: #f4f4f4;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;">
                            <a href="{{ config('app.url') }}" target="_blank">
                                <img alt="Logo" src="{{ asset('/frontpage/assets/img/logo.svg') }}" width="180" style="display: block; width: 180px; max-width: 180px; min-width: 180px;">
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 0px 10px 0px 10px; background-color: #f4f4f4;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 40px 30px 40px 30px; border-radius: 8px;" class="body-text">
                            
                            <h1 style="font-size: 24px; font-weight: bold; margin: 0;">{{ $greeting ?? 'Hello!' }}</h1>
                            <br>

                            @foreach ($introLines as $line)
                                <p style="margin: 0;">{{ $line }}</p>
                            @endforeach
                            
                            @isset($actionText)
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top: 30px; margin-bottom: 30px;">
                                    <tr>
                                        <td align="center">
                                            <a href="{{ $actionUrl }}" target="_blank" class="button">{{ $actionText }}</a>
                                        </td>
                                    </tr>
                                </table>
                            @endisset

                            @foreach ($outroLines as $line)
                                <p style="margin: 0;">{{ $line }}</p>
                            @endforeach
                            
                            <p style="margin-top: 30px; margin-bottom: 0;">
                                {{ $salutation ?? 'Regards,' }}<br>
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" style="padding: 30px 10px 30px 10px; background-color: #f4f4f4;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <!-- Footer -->
                    <tr>
                        <td align="center" class="footer-text">
                            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                            @isset($actionText)
                                <p style="margin-top: 10px;">If you're having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser: <br> <a href="{{ $actionUrl }}" target="_blank" style="color: #007bff; text-decoration: underline; word-break: break-all;">{{ $actionUrl }}</a></p>
                            @endisset
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
