<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
            if ($request->user()->mahasiswa) {
                $request->user()->mahasiswa->update(['email' => $request->user()->email]);
            }
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateMahasiswa(Request $request): RedirectResponse
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            $mahasiswa = Mahasiswa::create([
                'user_id' => $user->id,
                'created_by' => $user->id,
                'nama' => $user->name,
                'email' => $user->email,
            ]);
        }

        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:20', 'unique:mahasiswas,nim,' . $mahasiswa->id],
            'jenis_kelamin' => ['required', 'string', 'size:1', 'in:L,P'],
            'jurusan' => ['required', 'string', 'max:255'],
            'angkatan' => ['required', 'string', 'size:4', 'regex:/^[0-9]{4}$/'],
            'tgl_lahir' => ['required', 'date', 'before:today'],
            'alamat' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($mahasiswa->foto) {
                Storage::disk('public')->delete($mahasiswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        $mahasiswa->update($validated);

        return Redirect::route('profile.edit')->with('status', 'mahasiswa-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->mahasiswa()->delete();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
