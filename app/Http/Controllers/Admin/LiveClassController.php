<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Subject;
use App\Models\LiveClass;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JubaerHossain\Zoom\Facades\Zoom;
use App\DataTables\LiveClassDataTable;

class LiveClassController extends Controller
{
    public function index(LiveClassDataTable $dataTable)
    {
        $subjects = Subject::with('grade')->get();
        return $dataTable->render('admin.live_classes.index',compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
            'agenda' => 'required|string',
            'type' => 'required|integer',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'settings' => 'nullable|array', 
        ]);

        
        $liveClass = LiveClass::create([
            'subject_id' => $request->subject_id,
            'topic' => $request->topic,
            'agenda' => $request->agenda,
            'type' => $request->type,
            'duration' => $request->duration,
            'start_time' => Carbon::parse($request->start_time),
            'timezone' => 'Asia/Dhaka',
            'status' => 'scheduled',
        ]);

        
        if ($request->type == 1) {
            
            $zoomSettings = $request->input('settings', []);

            
            $zoomSettings = array_merge([
                'join_before_host' => false,
                'host_video' => false,
                'participant_video' => false,
                'mute_upon_entry' => false,
                'waiting_room' => false,
                'audio' => 'both',
                'auto_recording' => 'none',
                'approval_type' => 0,
            ], $zoomSettings);

            
            $meetings = Zoom::createMeeting([
                "agenda" => $request->agenda,
                "topic" => $request->topic,
                "type" => 2, 
                "duration" => $request->duration,
                "timezone" => 'Asia/Dhaka',
                "password" => $request->password ?? 'default_password',
                "start_time" => $liveClass->start_time->toDateTimeString(),
                "settings" => $zoomSettings,
            ]);

            
            $liveClass->update([
                'zoom_meeting_id' => $meetings->id,
                'zoom_join_url' => $meetings->join_url,
            ]);
        }

        return redirect()->route('admin.live_classes.index')->with('success', 'Live Class created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'agenda' => 'required|string',
            'type' => 'required|integer',
            'duration' => 'required|integer',
            'start_time' => 'required|date',
            'settings' => 'nullable|array', 
        ]);

        $liveClass = LiveClass::findOrFail($id);

        
        $liveClass->update([
            'topic' => $request->topic,
            'agenda' => $request->agenda,
            'type' => $request->type,
            'duration' => $request->duration,
            'start_time' => Carbon::parse($request->start_time),
        ]);

        
        if ($liveClass->type == 1 && $liveClass->zoom_meeting_id) {
            
            $zoomSettings = $request->input('settings', []);

            
            $zoomSettings = array_merge([
                'join_before_host' => false,
                'host_video' => false,
                'participant_video' => false,
                'mute_upon_entry' => false,
                'waiting_room' => false,
                'audio' => 'both',
                'auto_recording' => 'none',
                'approval_type' => 0,
            ], $zoomSettings);

            
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

        return redirect()->route('admin.live_classes.index')->with('success', 'Live Class updated successfully.');
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

        return redirect()->route('admin.live_classes.index')->with('success', 'Live Class deleted successfully.');
    }
}
