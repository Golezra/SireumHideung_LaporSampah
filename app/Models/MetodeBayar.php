<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodeBayar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lapor_sampah_id',
        'order_id',
        'keterangan',
        'nominal',
        'metode_bayar',
        'jenis_sampah',
        'status_sampah',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laporSampah()
    {
        return $this->belongsTo(LaporSampah::class, 'lapor_sampah_id');
    }
}
