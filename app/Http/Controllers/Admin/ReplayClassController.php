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

        $topic = Topic::with(['grade', 'subject'])->findOrFail($validated['topic_id']);
        $tutor = User::findOrFail($validated['user_id']);

        $videoName = "{$topic->grade->name}_{$topic->subject->name}_{$topic->name}_{$tutor->name}";
        $cloudinaryFolder = "replay_class/{$topic->grade->name}/{$topic->subject->name}/{$topic->name}";

        $cloudinary = new Cloudinary(
            Configuration::instance(config('cloudinary'))
        );

        $uploadedFile = $cloudinary->uploadApi()->upload(
            $request->file('upload_file')->getRealPath(),
            [
                'folder' => $cloudinaryFolder,
                'public_id' => $videoName,
                'resource_type' => 'auto',
            ]
        );

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

        if ($request->update_media && $request->upload_file) {
            // Init Cloudinary
            // dd($request);
            $cloudinary = new Cloudinary(
                Configuration::instance(config('cloudinary'))
            );

            // Delete old file from Cloudinary
            if ($replayClass->replay_public_id) {
                $cloudinary->uploadApi()->destroy($replayClass->replay_public_id, [
                    'resource_type' => 'image', // or 'image', or 'auto'
                ]);
            }

            // Reconstruct new filename/folder
            $topic = Topic::with(['grade', 'subject'])->findOrFail($validated['topic_id']);
            $tutor = User::findOrFail($validated['user_id']);

            $videoName = "{$topic->grade->name}_{$topic->subject->name}_{$topic->name}_{$tutor->name}";
            $cloudinaryFolder = "replay_class/{$topic->grade->name}/{$topic->subject->name}/{$topic->name}";

            // Upload file to Cloudinary
            $uploadedFile = $cloudinary->uploadApi()->upload(
                $request->file('upload_file')->getRealPath(),
                [
                    'folder' => $cloudinaryFolder,
                    'public_id' => $videoName,
                    'resource_type' => 'auto',
                ]
            );


            // Update Cloudinary fields
            $replayClass->replay_url = $uploadedFile['secure_url'];
            $replayClass->replay_public_id = $uploadedFile['public_id'];
        }

        $replayClass->save();

        return redirect()->back()->with('success', 'Replay Class updated successfully.');
    }

    public function destroy($id)
    {
        $replayClass = ReplayClass::findOrFail($id);

        $cloudinary = new Cloudinary(
            Configuration::instance(config('cloudinary'))
        );

        $cloudinary->uploadApi()->destroy($replayClass->replay_public_id, [
            'resource_type' => 'video', // or 'image' / 'auto'
        ]);

        $replayClass->delete();

        return redirect()->back()->with('success', 'Replay Class deleted successfully.');
    }
}
