<?php

namespace App\Http\Controllers\Tutor;

use App\Models\Note;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TutorNoteController extends Controller
{
    public function index($slug)
    {
        $title = 'Manage Notes';
        $user = Auth::user();
        $topic = Topic::where('slug', $slug)->firstOrFail();
        $notes = $topic->notes()->get();
        return view('frontend.tutors.notes.index', compact('notes', 'title', 'user', 'topic'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'topic_id' => 'required|integer|exists:topics,id',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120', 
            'key_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'status' => 'required|in:draft,publish',
        ]);

        $topic = Topic::findOrFail($request->topic_id);
        $data = $request->only('name', 'description', 'status');

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('notes', 'public');
            $data['file_url'] = Storage::disk('public')->url($filePath);
            $data['file_public_id'] = $filePath;
        } 

        if ($request->hasFile('key_file')) {
            $keyFilePath = $request->file('key_file')->store('notes/keys', 'public');
            $data['key_url'] = Storage::disk('public')->url($keyFilePath);
            $data['key_public_id'] = $keyFilePath;
        }

        $topic->notes()->create($data);

        return back()->with('success', 'Note has been created successfully.');
    }

    public function update(Request $request, $slug, $noteId)
    {
        $note = Note::findOrFail($noteId); 

        $request->validate([
            'topic_id' => 'required|integer|exists:topics,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'key_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'status' => 'required|in:draft,publish',
        ]);

        $data = $request->only('topic_id', 'name', 'description', 'status');

        if ($request->hasFile('file')) {
            if ($note->file_public_id && Storage::disk('public')->exists($note->file_public_id)) {
                Storage::disk('public')->delete($note->file_public_id);
            }
            $filePath = $request->file('file')->store('notes', 'public');
            $data['file_url'] = Storage::disk('public')->url($filePath);
            $data['file_public_id'] = $filePath;
        }

        if ($request->hasFile('key_file')) {
            if ($note->key_public_id && Storage::disk('public')->exists($note->key_public_id)) {
                Storage::disk('public')->delete($note->key_public_id);
            }
            $keyFilePath = $request->file('key_file')->store('notes/keys', 'public');
            $data['key_url'] = Storage::disk('public')->url($keyFilePath);
            $data['key_public_id'] = $keyFilePath;
        }

        $note->update($data);

        return back()->with('success', 'Note has been updated successfully.');
    }

    public function destroy($noteId)
    {
        $note = Note::findOrFail($noteId); 

        if ($note->file_public_id && Storage::disk('public')->exists($note->file_public_id)) {
            Storage::disk('public')->delete($note->file_public_id);
        }

        if ($note->key_public_id && Storage::disk('public')->exists($note->key_public_id)) {
            Storage::disk('public')->delete($note->key_public_id);
        }

        $note->delete();

        return back()->with('success', 'Note has been deleted successfully.');
    }
}