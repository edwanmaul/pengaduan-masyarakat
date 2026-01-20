<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung semua laporan
        $total = Report::count();

        // Hitung laporan menunggu
        $pending = Report::where('status', 'pending')->count();

        // Hitung laporan yang sedang diproses atau sudah selesai
        $processDone = Report::whereIn('status', ['in_process', 'resolved'])->count();

        // Kalau kamu masih butuh data terbaru untuk halaman lain:
        $latest = Report::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('total', 'pending', 'processDone', 'latest'));
    }

    public function laporanTerbaru()
    {
        $laporan = Report::orderBy('created_at', 'desc')->get();

        return view('admin.laporan-terbaru', compact('laporan'));
    }
}
