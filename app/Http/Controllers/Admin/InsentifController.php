<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InsentifController extends Controller
{
    public function addPoinForm()
    {
        $users = User::all();
        return view('admin.insentif.add-poin', compact('users'));
    }

    public function addPoin(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'poin' => 'required|integer|min:1',
        ]);

        $user = User::findOrFail($request->user_id);
        $user->poin += $request->poin;
        $user->save();

        return redirect()->back()->with('success', 'Poin berhasil ditambahkan ke pengguna!');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('query', '');

        $users = \App\Models\User::where('name', 'like', '%' . $query . '%')
            ->orWhere('rt', 'like', '%' . $query . '%')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'poin' => $user->poin,
                    'rt' => $user->rt,
                    'jumlah_lapor' => $user->jumlah_lapor,
                ];
            });

        return response()->json($users);
    }
}
