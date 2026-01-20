@extends('layouts.app')
@section('title','Semua Laporan')

@section('content')
<div class="card">
    <form method="get" class="inline" style="display:inline-block; margin-right:10px;">
        <label for="status" style="display:inline-block; margin-right:8px">Filter status</label>
        <select id="status" name="status" onchange="this.form.submit()">
            @php
                $options = [
                    'all' => 'Semua',
                    'pending' => 'Menunggu',
                    'in_process' => 'Diproses',
                    'resolved' => 'Selesai',
                ];
            @endphp
            @foreach ($options as $key => $label)
                <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    <a class="btn btn-light"
       href="{{ route('admin.reports.export.csv', request()->query()) }}">
        Export CSV
    </a>
</div>

<div class="card" style="margin-top:12px">
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Pelapor</th>
                <th>Status</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($reports as $r)
            <tr>
                <td>{{ $r->title }}</td>
                <td>{{ $r->user->name }}</td>
                <td><span class="badge {{ $r->status }}">{{ $r->status_label }}</span></td>
                <td>{{ $r->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }}</td>
                <td><a class="btn btn-light" href="{{ route('admin.reports.show',$r) }}">Detail</a></td>
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada data.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{ $reports->links() }}
</div>
@endsection
