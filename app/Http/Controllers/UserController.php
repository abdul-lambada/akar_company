<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('user_id')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'nullable|string|max:50',
            'password' => 'required|string|min:6',
        ]);

        User::create($data); // password akan di-hash via cast
        return redirect()->route('users.index')->with('success', 'User created');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->user_id.',user_id',
            'email' => 'required|email|max:255|unique:users,email,'.$user->user_id.',user_id',
            'role' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}