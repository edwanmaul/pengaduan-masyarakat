<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.reports.index', compact('reports'));
    }

    public function create()
    {
        return view('user.reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => ['required','string','max:150'],
            'body'     => ['required','string','max:5000'],
            'category' => ['nullable','string','max:50'],
            'photo'    => ['nullable','image','mimes:jpeg,png,jpg,webp','max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('reports', 'public'); // butuh storage:link
        }

        $report = Report::create([
            'user_id'    => auth()->id(),
            'title'      => $validated['title'],
            'body'       => $validated['body'],
            'category'   => $validated['category'] ?? null,
            'photo_path' => $path,
            'status'     => 'pending',
        ]);

        return redirect()->route('user.reports.show', $report)->with('success','Laporan berhasil dikirim.');
    }

    public function show(Report $report)
    {
        abort_if($report->user_id !== auth()->id(), 403);
        $report->load('responses.user');
        return view('user.reports.show', compact('report'));
    }

}
