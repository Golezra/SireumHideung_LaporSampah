<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WargaController extends Controller
{
    // Tampilkan dashboard warga
    public function dashboard()
    {
        $user = Auth::user();
        return view('warga.dashboard', compact('user'));
    }

    // Tampilkan form edit profil
    public function editProfil()
    {
        $user = Auth::user();
        return view('warga.edit-profil', compact('user'));
    }

    // Proses update profil
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'rt' => 'required',
            'phone_number' => 'required',
            'nik' => 'required|digits:16|unique:users,nik,' . $user->id,
            'pict' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'new_password' => 'nullable|min:6|max:6',
        ]);

        // Update foto profil jika ada file baru
        if ($request->hasFile('pict')) {
            // Hapus foto lama jika bukan default
            if ($user->foto_profil && $user->foto_profil != 'img/foto-profil/default-fotoprofil.png') {
                @unlink(public_path($user->foto_profil));
            }
            $file = $request->file('pict');
            $filename = 'foto-profil-' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/foto-profil'), $filename);
            $user->foto_profil = 'img/foto-profil/' . $filename;
        }

        $user->name = $request->name;
        $user->rt = $request->rt;
        $user->phone_number = $request->phone_number;
        $user->nik = $request->nik;

        // Update password jika diisi
        if ($request->filled('new_password')) {
            $user->password = bcrypt($request->new_password);
        }

        $user->save();

        return redirect()->route('warga.dashboard')->with('success', 'Profil berhasil diperbarui!');
    }
}
