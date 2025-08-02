<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\LiveClass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Jubaer\Zoom\Facades\Zoom;
use App\Http\Controllers\Controller;
use App\DataTables\LiveClassDataTable;

class LiveClassController extends Controller
{
    public function index(LiveClassDataTable $dataTable)
    {
        $grades = Grade::all();
        $subjects = Subject::with('grade')->get();
        return $dataTable->render('admin.live_classes.index',compact('subjects','grades'));
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

        $zoomSettings = array_merge([
            'join_before_host' => false,
            'host_video' => false,
            'participant_video' => false,
            'mute_upon_entry' => false,
            'waiting_room' => false,
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
            'type' => $request->type ?? 1,
            'duration' => $request->duration,
            'start_time' => \Carbon\Carbon::parse($request->start_time),
            'timezone' => 'Asia/Jakarta',
            'password' => $request->password ?? Str::random(8),
            'status' => 'scheduled',
            'settings' => $zoomSettings,
        ]);

        $meeting = Zoom::createMeeting([
            'agenda'     => $request->agenda,
            'topic'      => $liveClass->topic->name ?? 'Live Class',
            'type'       => 2,
            'duration'   => $request->duration,
            'timezone'   => $liveClass->timezone,
            'password'   => $liveClass->password,
            'start_time' => $liveClass->start_time->toIso8601String(),
            'settings'   => $zoomSettings,
        ]);

        $liveClass->update([
            'zoom_meeting_id' => $meeting['id'],
            'zoom_join_url'   => $meeting['join_url'],
            'zoom_start_url'  => $meeting['start_url'],
        ]);


        return redirect()
            ->route('admin.live-classes.index')
            ->with('success', 'Live Class created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'grade_id'     => 'required|exists:grades,id',
            'subject_id'   => 'required|exists:subjects,id',
            'topic_id'     => 'required|exists:topics,id',
            'user_id'      => 'required|exists:users,id', // tutor
            'agenda'       => 'required|string|max:1000',
            'start_time'   => 'required|date',
            'duration'     => 'required|integer|min:1',
            'type'         => 'nullable|in:0,1', // 1 = Zoom
            'password'     => 'nullable|string|max:100',
            'settings'     => 'nullable|array',
        ]);

        $zoomSettings = array_merge([
            'join_before_host'   => false,
            'host_video'         => false,
            'participant_video'  => false,
            'mute_upon_entry'    => false,
            'waiting_room'       => false,
            'audio'              => 'both',
            'auto_recording'     => 'none',
            'approval_type'      => 0,
        ], $request->input('settings', []));

        $liveClass = LiveClass::findOrFail($id);

        $liveClass->update([
            'grade_id' => $request->grade_id,
            'subject_id' => $request->subject_id,
            'topic_id' => $request->topic_id,
            'user_id' => $request->user_id,
            'agenda' => $request->agenda,
            'type' => $request->type ?? 1,
            'duration' => $request->duration,
            'start_time' => Carbon::parse($request->start_time),
            'settings'       => $zoomSettings,
        ]);

        if ($liveClass->type == 1 && $liveClass->zoom_meeting_id) {

            $zoomMeeting = Zoom::meeting()->find($liveClass->zoom_meeting_id);

            if ($zoomMeeting) {
                $zoomMeeting->update([
                    'topic' => $request->topic,
                    'start_time' => $liveClass->start_time->toDateTimeString(),
                    'duration' => $request->duration,
                    'agenda' => $request->agenda,
                    'password' => $request->password ?? $zoomMeeting->password,
                    'settings' => $zoomSettings,
                ]);
            }
        }

        return redirect()->route('admin.live-classes.index')->with('success', 'Live Class updated successfully.');
    }



    public function destroy($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        
        if ($liveClass->type == 1 && $liveClass->zoom_meeting_id) {
            $zoomMeeting = Zoom::meeting()->find($liveClass->zoom_meeting_id);
            if ($zoomMeeting) {
                $zoomMeeting->delete();
            }
        }

        $liveClass->delete();

        return redirect()->route('admin.live-classes.index')->with('success', 'Live Class deleted successfully.');
    }
}
