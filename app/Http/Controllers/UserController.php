<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', ['user'=>$user]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->validate([
            'username' => 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required',
            'password'=> 'required|confirmed',
            'role'=> 'required'
        ]);
        $user['bio'] = $request->bio;

        if ($request->hasFile('avatar_image')) {
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $user['avatar_url'] = asset('storage/' . $path);
        }
        $createdUser = User::create($user);
        $createdUser->roles()->attach($request->role);
        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, $id)
    {
        $userData = $request->validate([
            'username' => 'required',
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required|email',
            'role'=> 'required',
            'password' => 'nullable|confirmed'
        ]);

        $user = User::findOrFail($id);

        if (!empty($userData['password'])) {
            $userData['password'] = bcrypt($userData['password']);
        } else {
            unset($userData['password']);
        }

        $userData['bio'] = $request->bio;

        if ($request->hasFile('avatar_image')) {
            if ($user->avatar_url) {
                $oldPath = str_replace(asset('storage/'), '', $user->avatar_url);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $path = $request->file('avatar_image')->store('avatars', 'public');
            $userData['avatar_url'] = asset('storage/' . $path);
        }

        $user->update($userData);
        $user->roles()->sync([$request->role]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
