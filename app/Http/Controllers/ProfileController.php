<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = auth()->user();
        $completedCompetitions = 0; // Replace with actual logic
        $achievements = 0; // Replace with actual logic
        \Log::info('ProfileController@show called for user: ' . $user->id);
        return view('profile.profile', compact('user', 'completedCompetitions', 'achievements'));
    }

    public function edit()
    {
        $user = auth()->user();
        \Log::info('ProfileController@edit called for user: ' . $user->id);
        return view('profile.edit', compact('user'));
    }

    public function settings()
    {
        $user = auth()->user();
        $completedCompetitions = 0; // Replace with actual logic
        $achievements = 0; // Replace with actual logic
        \Log::info('ProfileController@settings called for user: ' . $user->id);
        return view('settings', compact('user', 'completedCompetitions', 'achievements'));
    }

    
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'nullable|min:8|confirmed',
            'experience' => 'nullable|array',
            'experience.*' => 'string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // Simpan data competition experience
        if ($request->has('experience')) {
            $user->experience = $request->experience;
        } else {
            $user->experience = [];
        }

        if ($request->hasFile('profile_image')) {
            // Hapus foto lama kalau ada
            if ($user->profile_image && \Storage::disk('public')->exists('images/' . $user->profile_image)) {
                \Storage::disk('public')->delete('images/' . $user->profile_image);
            }

            // Simpan foto baru
            $filename = $request->file('profile_image')->store('images', 'public');
            $user->profile_image = basename($filename);
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    
        // Update user
        $updated = $user->update($validated);
        \Log::info('User update result: ' . ($updated ? 'success' : 'no changes'), [
            'user_data' => $user->fresh()->toArray(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui!');
    }

    public function settingsUpdate(Request $request)
    {
        $user = auth()->user();
        \Log::info('Settings update attempted for user: ' . $user->id, [
            'input' => $request->except(['password', 'password_confirmation']),
        ]);

        // Validate input
        $validated = $request->validate([
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'notification_preferences.saved_competitions' => ['nullable', 'boolean'],
            'notification_preferences.new_competitions' => ['nullable', 'boolean'],
        ]);

        // Handle password
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
            \Log::info('Password updated for user: ' . $user->id);
        } else {
            unset($validated['password']);
            \Log::info('No password change requested');
        }

        // Handle notification preferences
        $notificationPreferences = [
            'saved_competitions' => $request->input('notification_preferences.saved_competitions', false),
            'new_competitions' => $request->input('notification_preferences.new_competitions', false),
        ];
        $validated['notification_preferences'] = $notificationPreferences;

        // Update user
        $updated = $user->update($validated);
        \Log::info('Settings update result: ' . ($updated ? 'success' : 'no changes'), [
            'user_data' => $user->fresh()->toArray(),
        ]);

        return redirect()->route('settings')->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function delete(Request $request)
    {
        $user = auth()->user();
        if (!in_array($user->role, ['user', 'organizer'])) {
            abort(403, 'Hanya pengguna atau penyelenggara yang dapat menghapus akun mereka.');
        }

        \Log::info('Account deletion attempted for user: ' . $user->id);

        // Delete profile image if exists
        if ($user->profile_image) {
            Storage::delete('public/images/' . $user->profile_image);
            \Log::info('Deleted profile image: ' . $user->profile_image);
        }

        // Delete user
        $user->delete();
        Auth::logout();
        \Log::info('User account deleted: ' . $user->id);

        return redirect()->route('login')->with('success', 'Akun Anda telah dihapus.');
    }
}