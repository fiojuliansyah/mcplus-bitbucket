<?php

namespace App\Http\Controllers\Admin;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use App\Models\ReplayClass;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\ReplayClassDataTable;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
// use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ReplayClassController extends Controller
{
    public function index(ReplayClassDataTable $dataTable)
    {
        $grades = Grade::all();
        return $dataTable->render('admin.replay_classes.index',compact('grades'));
    }

    public function store(Request $request)
    {

        // Validate input
        $validated = $request->validate([
            'grade_id'     => 'required|exists:grades,id',
            'subject_id'   => 'required|exists:subjects,id',
            'topic_id'     => 'required|exists:topics,id',
            'user_id'      => 'required|exists:users,id',
            'upload_file'  => 'required|file|mimes:mp4,mov,avi,jpg,jpeg,png',
        ]);

        // Eager-load topic with grade and subject
        $topic = Topic::with(['grade', 'subject'])->findOrFail($validated['topic_id']);
        $tutor = User::findOrFail($validated['user_id']);

        // Construct video name and folder path
        $videoName = "{$topic->grade->name}_{$topic->subject->name}_{$topic->name}_{$tutor->name}";
        $cloudinaryFolder = "replay_class/{$topic->grade->name}/{$topic->subject->name}/{$topic->name}";

        // Upload to Cloudinary
        $cloudinary = new Cloudinary(
            Configuration::instance(config('cloudinary'))
        );

        // Upload file to Cloudinary
        $uploadedFile = $cloudinary->uploadApi()->upload(
            $request->file('upload_file')->getRealPath(),
            [
                'folder' => $cloudinaryFolder,
                'public_id' => $videoName,
                'resource_type' => 'auto',
            ]
        );

        // Create replay class entry
        $replayClass = ReplayClass::create([
            'grade_id'          => $validated['grade_id'],
            'subject_id'        => $validated['subject_id'],
            'topic_id'          => $validated['topic_id'],
            'user_id'           => $validated['user_id'],
            'replay_url'        => $uploadedFile['secure_url'],
            'replay_public_id'  => $uploadedFile['public_id'],
        ]);

        return redirect()
            ->route('admin.replay-classes.index')
            ->with('success', 'Replay Class uploaded successfully.');
    }

    public function update(Request $request, $id)
    {
        $replayClass = ReplayClass::findOrFail($id);

        $validated = $request->validate([
            'grade_id' => 'required|exists:grades,id',
            'subject_id' => 'required|exists:subjects,id',
            'topic_id' => 'required|exists:topics,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $replayClass->grade_id = $validated['grade_id'];
        $replayClass->subject_id = $validated['subject_id'];
        $replayClass->topic_id = $validated['topic_id'];
        $replayClass->user_id = $validated['user_id'];

        if ($request->has('update_media') && $request->hasFile('media_file')) {
            // $path = $request->file('media_file')->store('replay_classes', 'public');
            // $replayClass->media_path = $path;
        }

        $replayClass->save();

        return redirect()->back()->with('success', 'Replay Class updated successfully.');
    }

    public function destroy($id)
    {
        $replayClass = ReplayClass::findOrFail($id);

        $replayClass->delete();

        return redirect()->back()->with('success', 'Live Class deleted successfully.');
    }
}
