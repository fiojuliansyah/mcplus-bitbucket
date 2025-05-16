<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\TutorDataTable;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class TutorController extends Controller
{
    public function index(TutorDataTable $dataTable)
    {
        $roles = Role::all();
        return $dataTable->render('admin.tutors.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8',
            'roles' => 'array|nullable',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'account_type' => 'tutor',
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.tutors.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|unique:users,phone,' . $id,
            'status' => 'required|string',
            'roles' => 'array|nullable',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'account_type' => 'tutor',
            'status' => $request->status,
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.tutors.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.tutors.index')->with('success', 'User deleted successfully.');
    }

    public function assignSubjects(Request $request, $tutorId)
    {
        $tutor = User::findOrFail($tutorId);

        $request->validate([
            'subjects' => 'required|array',
            'subjects.*' => 'exists:subjects,id',
        ]);

        $tutor->subjects()->sync($request->subjects);

        return redirect()->route('admin.tutors.index')->with('success', 'Subjects assigned to tutor successfully.');
    }
}
