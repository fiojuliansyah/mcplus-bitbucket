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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class LiveClassController extends Controller
{
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

        $tutor = User::findOrFail($request->user_id);
        if (!$tutor->zoom_token) {
            return back()->withInput()->with('error', 'Gagal: Tutor yang dipilih belum menghubungkan akun Zoom mereka.');
        }

        $zoomSettings = array_merge([
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => true,
            'waiting_room' => true,
            'audio' => 'both',
            'auto_recording'  => 'none',
            'approval_type' => 0,
        ], $request->input('settings', []));

        $liveClass = LiveClass::create([
            'grade_id' => $request->grade_id,
            'subject_id'  => $request->subject_id,
            'topic_id' => $request->topic_id,
            'user_id' => $request->user_id,
            'agenda' => $request->agenda,
            'type' => 1, 
            'duration' => $request->duration,
            'start_time' => Carbon::parse($request->start_time, 'Asia/Jakarta'),
            'timezone' => 'Asia/Jakarta',
            'password' => $request->password ?? Str::random(8),
            'status' => 'scheduled',
            'settings' => $zoomSettings,
        ]);
        $response = Http::withToken($tutor->zoom_token)
            ->post("https://api.zoom.us/v2/users/{$tutor->zoom_id}/meetings", [
                'topic'      => $liveClass->topic->name ?? 'Sesi Kelas Online',
                'agenda'     => $request->agenda,
                'type'       => 2, 
                'start_time' => $liveClass->start_time->toIso8601String(),
                'duration'   => $request->duration,
                'timezone'   => $liveClass->timezone,
                'password'   => $liveClass->password,
                'settings'   => $zoomSettings,
            ]);

        if (!$response->successful()) {
            $liveClass->delete(); 
            $errorMessage = $response->json()['message'] ?? 'Terjadi kesalahan saat menghubungi Zoom.';
            return back()->withInput()->with('error', 'Gagal membuat meeting di Zoom. Pesan: ' . $errorMessage);
        }

        $meeting = $response->json();
        $liveClass->update([
            'zoom_meeting_id' => $meeting['id'],
            'zoom_join_url'   => $meeting['join_url'],
            'zoom_start_url'  => $meeting['start_url'],
        ]);
        return redirect()->route('admin.live-classes.index')->with('success', 'Live Class berhasil dibuat.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([]);
        $liveClass = LiveClass::findOrFail($id);
        $tutor = $liveClass->user;

        if (!$tutor || !$tutor->zoom_token) {
            return back()->withInput()->with('error', 'Tutor untuk kelas ini tidak valid atau belum terhubung ke Zoom.');
        }

        $liveClass->update($request->except('settings')); 
        $zoomSettings = array_merge($liveClass->settings ?? [], $request->input('settings', []));
        $liveClass->settings = $zoomSettings;
        $liveClass->save();

        if ($liveClass->type == 1 && $liveClass->zoom_meeting_id) {
            $response = Http::withToken($tutor->zoom_token)
                ->patch("https://api.zoom.us/v2/meetings/{$liveClass->zoom_meeting_id}", [
                    'topic'      => $liveClass->topic->name ?? 'Sesi Kelas Online',
                    'agenda'     => $request->agenda,
                    'start_time' => Carbon::parse($request->start_time)->toIso8601String(),
                    'duration'   => $request->duration,
                    'settings'   => $zoomSettings,
                ]);
            if (!$response->noContent()) {
                return back()->withInput()->with('error', 'Gagal memperbarui meeting di Zoom.');
            }
        }

        return redirect()->route('admin.live-classes.index')->with('success', 'Live Class berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $liveClass = LiveClass::findOrFail($id);
        if ($liveClass->type == 1 && $liveClass->zoom_meeting_id) {
            $tutor = $liveClass->user;
            if ($tutor && $tutor->zoom_token) {
                Http::withToken($tutor->zoom_token)
                    ->delete("https://api.zoom.us/v2/meetings/{$liveClass->zoom_meeting_id}");
            }
        }

        $liveClass->delete();
        
        return redirect()->route('admin.live-classes.index')->with('success', 'Live Class berhasil dihapus.');
    }
}