<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $total = Report::where('user_id', $userId)->count();
        $pending = Report::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();
        $processDone = Report::where('user_id', $userId)
            ->whereIn('status', ['in_process', 'resolved'])
            ->count();

        return view('user.dashboard', compact('total', 'pending', 'processDone'));
    }

    public function summary()
    {
        $userId = auth()->id();

        $total = Report::where('user_id', $userId)->count();
        $pending = Report::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();
        $prosesSelesai = Report::where('user_id', $userId)
            ->whereIn('status', ['in_process', 'resolved'])
            ->count();

        return view('user.summary', compact('total', 'pending', 'prosesSelesai'));
    }
}
