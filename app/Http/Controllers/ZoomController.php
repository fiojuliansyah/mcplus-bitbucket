<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ZoomController extends Controller
{
    public function redirectToZoom()
    {
        return Socialite::driver('zoom')->redirect();
    }

    public function handleZoomCallback()
    {
        try {
            $zoomUser = Socialite::driver('zoom')->user();

            $user = User::updateOrCreate(
                [
                    'email' => $zoomUser->getEmail()
                ],
                [
                    'name' => $zoomUser->getName(),
                    'zoom_id' => $zoomUser->getId(),
                    'zoom_token' => $zoomUser->token,
                    'zoom_refresh_token' => $zoomUser->refreshToken,
                ]
            );

            Auth::login($user);

            return redirect()->route('tutor.settings')->with('success', 'Akun Zoom Anda berhasil dihubungkan!');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal mengautentikasi dengan Zoom. Silakan coba lagi. Pesan: ' . $e->getMessage());
        }
    }
}