<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Urutan status agar tidak bisa mundur.
     */
    private function statusRank(string $status): int
    {
        return match ($status) {
            'pending' => 0,
            'in_process' => 1,
            'resolved' => 2,
            default => 0,
        };
    }

    private function canMoveTo(string $current, string $next): bool
    {
        return $this->statusRank($next) >= $this->statusRank($current);
    }

    public function index(Request $request)
    {
        $status = $request->query('status','all');
        $query = Report::with('user')->latest();

        if (in_array($status, ['pending','in_process','resolved'])) {
            $query->where('status',$status);
        }

        $reports = $query->paginate(15)->withQueryString();
        return view('admin.reports.index', compact('reports','status'));
    }

    public function show(Report $report)
    {
        $report->load('user','responses.user');
        return view('admin.reports.show', compact('report'));
    }

    public function respond(Request $request, Report $report)
    {
        $from = $request->input('from') ?? $request->query('from');

        $validated = $request->validate([
            'message' => ['required','string','max:2000'],
            'status'  => ['required','in:pending,in_process,resolved'],
        ]);

        // Status tidak boleh mundur.
        $currentStatus = $report->status ?? 'pending';
        if (! $this->canMoveTo($currentStatus, $validated['status'])) {
            return back()
                ->withErrors(['status' => 'Status tidak bisa dikembalikan ke tahap sebelumnya.'])
                ->withInput();
        }

        ReportResponse::create([
            'report_id' => $report->id,
            'user_id'   => auth()->id(),
            'message'   => $validated['message'],
        ]);

        $report->update(['status' => $validated['status']]);

        return redirect()
            ->route('admin.reports.show', ['report' => $report, 'from' => $from])
            ->with('success','Tanggapan terkirim & status diperbarui.');
    }

    public function updateStatus(Request $request, Report $report)
    {
        $from = $request->input('from') ?? $request->query('from');

        $validated = $request->validate([
            'status' => ['required','in:pending,in_process,resolved'],
        ]);

        // Status tidak boleh mundur.
        $currentStatus = $report->status ?? 'pending';
        if (! $this->canMoveTo($currentStatus, $validated['status'])) {
            return back()
                ->withErrors(['status' => 'Status tidak bisa dikembalikan ke tahap sebelumnya.']);
        }

        $report->update(['status' => $validated['status']]);
        return redirect()
            ->route('admin.reports.show', ['report' => $report, 'from' => $from])
            ->with('success','Status diperbarui.');
    }

}