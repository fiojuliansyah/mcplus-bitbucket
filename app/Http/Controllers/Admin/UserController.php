<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        $userAllCount = User::count();
        $userCount = User::whereIn('account_type', ['student', 'parent'])->count();
        $tutorCount = User::where('account_type', 'tutor')->count();
        $adminCount = User::where('account_type', 'admin')->count();
        $roles = Role::all();
        return $dataTable->render('admin.users.index', compact('userCount', 'tutorCount', 'userAllCount', 'adminCount','roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8',
            'account_type' => 'required|string',
            'roles' => 'array|nullable',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'account_type' => $request->account_type,
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|unique:users,phone,' . $id,
            'account_type' => 'required|string',
            'status' => 'required|string',
            'roles' => 'array|nullable',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'account_type' => $request->account_type,
            'status' => $request->status,
        ]);

        if ($request->has('roles')) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
