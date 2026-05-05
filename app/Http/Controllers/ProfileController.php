<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $user = $request->user();
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            if ($user->role === 'tutor' && $user->tutor) {
                $user->tutor->update([
                    'no_hp' => $request->no_hp ?? $user->tutor->no_hp,
                    'alamat' => $request->alamat ?? $user->tutor->alamat,
                    'latitude' => $request->latitude ?? $user->tutor->latitude,
                    'longitude' => $request->longitude ?? $user->tutor->longitude,
                ]);
            } elseif ($user->role === 'siswa' && $user->siswa) {
                $user->siswa->update([
                    'no_hp' => $request->no_hp ?? $user->siswa->no_hp,
                    'alamat' => $request->alamat ?? $user->siswa->alamat,
                    'latitude' => $request->latitude ?? $user->siswa->latitude,
                    'longitude' => $request->longitude ?? $user->siswa->longitude,
                ]);
            }
        });

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
