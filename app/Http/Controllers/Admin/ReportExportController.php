<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportEtlExporter;
use Illuminate\Http\Request;

class ReportExportController extends Controller
{
    public function csv(Request $request, ReportEtlExporter $exporter)
    {
        return $exporter->exportCsv([
            'status'   => $request->query('status', null),
            'from'     => $request->query('from', null),
            'to'       => $request->query('to', null),
            'category' => $request->query('category', null),
            'q'        => $request->query('q', null),
        ]);
    }
}
