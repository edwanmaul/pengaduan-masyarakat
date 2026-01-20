<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportEtlExporter
{
    public function exportCsv(array $filters = []): StreamedResponse
    {
        $query = $this->buildQuery($filters);

        $filename = 'reports_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');

            // BOM UTF-8 biar Excel Windows kebaca benar
            fwrite($out, "\xEF\xBB\xBF");

            // Header CSV
            fputcsv($out, [
                'ID',
                'Tanggal Dibuat',
                'Nama Pelapor',
                'Email Pelapor',
                'Judul',
                'Laporan',
                'Kategori',
                'Status (kode)',
                'Status (label)',
            ]);

            $query->chunk(300, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    // ===== Transform =====
                    $nama = $r->user->name ?? '-';
                    $email = $r->user->email ?? '-';

                    $judul = $this->cleanText($r->title ?? '');
                    $laporan = $this->cleanText($r->body ?? '');

                    $kategori = $this->cleanText($r->category ?? '-');
                    $statusKode = $r->status ?? '-';
                    $statusLabel = $r->status_label ?? $statusKode;

                    // ===== Load (tulis ke CSV) =====
                    fputcsv($out, [
                        $r->id,
                        optional($r->created_at)->format('Y-m-d H:i:s'),
                        $nama,
                        $email,
                        $judul,
                        $laporan,
                        $kategori,
                        $statusKode,
                        $statusLabel,
                    ]);
                }
            });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function buildQuery(array $filters): Builder
    {
        $q = Report::query()->with('user')->latest();

        // Extract + filter
        if (!empty($filters['status']) && in_array($filters['status'], ['pending','in_process','resolved'], true)) {
            $q->where('status', $filters['status']);
        }

        if (!empty($filters['from']) && !empty($filters['to'])) {
            $q->whereBetween('created_at', [
                $filters['from'] . ' 00:00:00',
                $filters['to'] . ' 23:59:59',
            ]);
        }

        if (!empty($filters['category'])) {
            $q->where('category', $filters['category']);
        }

        if (!empty($filters['q'])) {
            $keyword = $filters['q'];
            $q->where(function ($sub) use ($keyword) {
                $sub->where('title', 'like', "%{$keyword}%")
                    ->orWhere('body', 'like', "%{$keyword}%");
            });
        }

        return $q;
    }

    private function cleanText(string $text): string
    {
        // Transform: buang HTML, rapikan spasi/newline
        $text = strip_tags($text);
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text ?? '');
    }
}
