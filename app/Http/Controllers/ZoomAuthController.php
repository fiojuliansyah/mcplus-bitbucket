<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ZoomAuthController extends Controller
{
    public function redirectToZoom()
    {
        $query = http_build_query([
            'response_type' => 'code',
            'client_id'     => env('ZOOM_CLIENT_ID'),
            'redirect_uri'  => env('ZOOM_REDIRECT_URI'),
            'scope'         => 'meeting:write meeting:read user:read',
        ]);

        return redirect("https://zoom.us/oauth/authorize?$query");
    }


    public function handleCallback(Request $request)
    {
        $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'authorization_code',
            'code' => $request->code,
            'redirect_uri' => env('ZOOM_REDIRECT_URI'),
        ])->withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('ZOOM_CLIENT_ID') . ':' . env('ZOOM_CLIENT_SECRET')),
        ]);

        $tokenData = $response->json();

        Session::put('zoom_access_token', $tokenData['access_token']);
        Session::put('zoom_refresh_token', $tokenData['refresh_token']);

        return redirect()->route('admin.live-classes.index')->with('success', 'Zoom authorized!');
    }
}
