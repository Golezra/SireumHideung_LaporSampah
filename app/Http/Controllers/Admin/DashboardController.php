<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $pendingCount = \App\Models\LaporSampah::where('status_lapor', 'pending')->count();
        return view('admin.dashboard', compact('pendingCount'));
    }
}
