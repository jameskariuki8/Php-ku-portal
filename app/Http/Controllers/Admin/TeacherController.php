<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    // Show form to add a new teacher
    public function create()
    {
        return view('admin.register-teacher');
    }

    // Store teacher data
    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],  // Ensure 'password_confirmation' is included in the form
        ]);

        // Store teacher data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',  // Assigning role as 'teacher'
        ]);

        // Redirect with success message
        return redirect()->route('admin.dashboard')->with('success', 'Teacher registered successfully.');
    }
}
