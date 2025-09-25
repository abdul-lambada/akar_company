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
            // Team fields
            'job_title' => 'nullable|string|max:120',
            'short_bio' => 'nullable|string|max:1000',
            'is_public' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'whatsapp_public' => 'nullable|string|max:32',
            'years_of_experience' => 'nullable|integer|min:0|max:60',
            'slug' => 'nullable|string|max:160|unique:users,slug',
        ]);

        // Convert comma separated to arrays
        $expertise = array_filter(array_map('trim', explode(',', (string) $request->input('expertise_text', ''))));
        $skills = array_filter(array_map('trim', explode(',', (string) $request->input('skills_text', ''))));
        $data['expertise'] = $expertise ?: null;
        $data['skills'] = $skills ?: null;
        $data['is_public'] = $request->boolean('is_public');

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
            // Team fields
            'job_title' => 'nullable|string|max:120',
            'short_bio' => 'nullable|string|max:1000',
            'is_public' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255',
            'whatsapp_public' => 'nullable|string|max:32',
            'years_of_experience' => 'nullable|integer|min:0|max:60',
            'slug' => 'nullable|string|max:160|unique:users,slug,'.$user->user_id.',user_id',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        // Convert comma separated to arrays
        $expertise = array_filter(array_map('trim', explode(',', (string) $request->input('expertise_text', ''))));
        $skills = array_filter(array_map('trim', explode(',', (string) $request->input('skills_text', ''))));
        $data['expertise'] = $expertise ?: null;
        $data['skills'] = $skills ?: null;
        $data['is_public'] = $request->boolean('is_public');

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