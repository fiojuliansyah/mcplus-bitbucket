<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LiveClassDataTable;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\LiveClass;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LiveClassController extends Controller
{
    private function getZoomAccessToken(): string
    {
        if (Cache::has('zoom_access_token')) {
            return Cache::get('zoom_access_token');
        }

        // Jika tidak ada di cache, minta token baru ke Zoom.
        $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'account_credentials',
            'account_id' => env('ZOOM_ACCOUNT_ID'),
            'client_id' => env('ZOOM_CLIENT_ID'),
            'client_secret' => env('ZOOM_CLIENT_SECRET'),
        ]);

        if (!$response->successful()) {
            throw new \Exception('Gagal mendapatkan Zoom Access Token. Periksa kredensial Anda di file .env.');
        }

        $data = $response->json();
        $accessToken = $data['access_token'];

        Cache::put('zoom_access_token', $accessToken, now()->addMinutes(59));

        return $accessToken;
    }

    public function index(LiveClassDataTable $dataTable)
    {
        $grades = Grade::all();
        $subjects = Subject::with('grade')->get();
        return $dataTable->render('admin.live_classes.index', compact('subjects', 'grades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id'  => 'required|exists:topics,id',
            'user_id' => 'required|exists:users,id',
            'agenda'  => 'required|string|max:1000',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
        ]);

        try {
            $accessToken = $this->getZoomAccessToken();

            $tutor = User::findOrFail($request->user_id);
            if (!$tutor->email) {
                return back()->withInput()->with('error', 'Tutor yang dipilih tidak memiliki alamat email terdaftar.');
            }

            $defaultSettings = [
                'host_video'        => false,
                'participant_video' => false,
                'join_before_host'  => false,
                'mute_upon_entry'   => false,
                'waiting_room'      => false,
            ];

            $rawSettings = $request->input('settings', []);
            $processedSettings = array_merge($defaultSettings, $rawSettings);

                foreach ($processedSettings as $key => $value) {
                if (array_key_exists($key, $defaultSettings)) {
                    $processedSettings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
            }


            $liveClass = LiveClass::create([
                'grade_id'   => $request->grade_id,
                'subject_id' => $request->subject_id,
                'topic_id'   => $request->topic_id,
                'user_id'    => $request->user_id,
                'agenda'     => $request->agenda,
                'type'       => 1, // 1 = Zoom
                'duration'   => $request->duration,
                'start_time' => Carbon::parse($request->start_time, 'Asia/Jakarta'),
                'timezone'   => 'Asia/Jakarta',
                'password'   => $request->password ?? Str::random(8),
                'status'     => 'scheduled',
                'settings'   => $processedSettings,
            ]);

            $response = Http::withToken($accessToken)
                ->post("https://api.zoom.us/v2/users/{$tutor->email}/meetings", [
                    'topic'      => ($liveClass->subject->name ?? 'Subject') . ' - ' . ($liveClass->grade->name ?? 'Grade') . ': ' . ($liveClass->topic->name ?? 'Topic'),
                    'agenda'     => $request->agenda,
                    'type'       => 2,
                    'start_time' => $liveClass->start_time->toIso8601String(),
                    'duration'   => $request->duration,
                    'password'   => $liveClass->password,
                    'settings'   => $processedSettings,
                ]);

            if (!$response->successful()) {
                $liveClass->delete();
                $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan saat membuat meeting.';
                return back()->withInput()->with('error', 'Gagal membuat meeting di Zoom: ' . $errorMessage);
            }

            $meeting = $response->json();
            $liveClass->update([
                'zoom_meeting_id' => $meeting['id'],
                'zoom_join_url'   => $meeting['join_url'],
                'zoom_start_url'  => $meeting['start_url'],
            ]);

            return redirect()->route('admin.live-classes.index')->with('success', 'Live Class berhasil dibuat.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id'  => 'required|exists:topics,id',
            'user_id' => 'required|exists:users,id',
            'agenda'  => 'required|string|max:1000',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:1',
        ]);

        $liveClass = LiveClass::findOrFail($id);

        try {
            $accessToken = $this->getZoomAccessToken();

            $defaultSettings = [
                'host_video'        => false,
                'participant_video' => false,
                'join_before_host'  => false,
                'mute_upon_entry'   => false,
                'waiting_room'      => false,
            ];

            $rawSettings = $request->input('settings', []);
            
            $processedSettings = array_merge($defaultSettings, $rawSettings);
            foreach ($processedSettings as $key => $value) {
                if (array_key_exists($key, $defaultSettings)) {
                    $processedSettings[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                }
            }
            
            $updateData = $request->except(['_token', '_method', 'settings']);
            $updateData['settings'] = $processedSettings;

            $liveClass->update($updateData);


            if ($liveClass->zoom_meeting_id) {
                Http::withToken($accessToken)
                    ->patch("https://api.zoom.us/v2/meetings/{$liveClass->zoom_meeting_id}", [
                        'topic'      => ($liveClass->subject->name ?? 'Subject') . ' - ' . ($liveClass->grade->name ?? 'Grade') . ': ' . ($liveClass->topic->name ?? 'Topic'),
                        'agenda'     => $request->agenda,
                        'start_time' => Carbon::parse($request->start_time)->toIso8601String(),
                        'duration'   => $request->duration,
                        'settings'   => $processedSettings,
                    ]);
            }

            return redirect()->route('admin.live-classes.index')->with('success', 'Live Class berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $liveClass = LiveClass::findOrFail($id);

        try {
            if ($liveClass->zoom_meeting_id) {
                $accessToken = $this->getZoomAccessToken();
                
                $response = Http::withToken($accessToken)
                    ->delete("https://api.zoom.us/v2/meetings/{$liveClass->zoom_meeting_id}");

                if (!$response->successful()) {
                    $errorInfo = $response->json();
                    $errorMessage = $errorInfo['message'] ?? 'Status: ' . $response->status();
                    
                    if ($response->status() == 404) {
                    } else {
                        return back()->with('error', 'Gagal menghapus meeting di Zoom. Pesan: ' . $errorMessage);
                    }
                }
            }

            $liveClass->delete();

            return redirect()->route('admin.live-classes.index')->with('success', 'Live Class berhasil dihapus.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat menghapus: ' . $e->getMessage());
        }
    }
}