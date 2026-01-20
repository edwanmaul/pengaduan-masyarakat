<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','title','body','photo_path','category','status'];

    public function user()  { return $this->belongsTo(User::class); }
    public function responses() { return $this->hasMany(ReportResponse::class); }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'in_process' => 'Diproses',
            'resolved' => 'Selesai',
            default => ucfirst($this->status),
        };
    }

    /**
     * URL foto laporan.
     *
     * Default penyimpanan saat ini: storage/app/public (disk "public")
     * yang biasanya diakses lewat /storage via `php artisan storage:link`.
     *
     * Untuk menghindari foto tidak tampil ketika symlink belum dibuat,
     * kita juga menyiapkan route fallback /storage/{path} (lihat routes/web.php).
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_path) {
            return null;
        }

        // Normalisasi path untuk mengakomodasi data lama yang mungkin tersimpan
        // sebagai "public/reports/..." atau "/storage/reports/...".
        $path = ltrim((string) $this->photo_path, '/');
        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }
        if (Str::startsWith($path, 'public/')) {
            $path = Str::after($path, 'public/');
        }

        // Jika suatu saat foto disimpan langsung di folder public, cukup simpan path "uploads/...".
        if (Str::startsWith($path, 'uploads/')) {
            return asset($path);
        }

        // Jika file tidak ada (mis. data path salah / file terhapus), jangan tampilkan URL
        // agar UI menampilkan placeholder (tidak broken image).
        if (!Storage::disk('public')->exists($path)) {
            return null;
        }

        // Default: disk public -> diakses via /storage/{path}
        return url('storage/'.$path);
    }
}
