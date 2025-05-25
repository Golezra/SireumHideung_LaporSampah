<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporSampah extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'metode_bayar_id',
        'setting_biaya_id',
        'volume_sampah',
        'lokasi_sampah',
        'keterangan_lokasi',
        'foto_sampah',
        'jenis_sampah',
        'status_bayar',
        'status_lapor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function metodeBayar()
    {
        return $this->hasOne(MetodeBayar::class, 'lapor_sampah_id');
    }

    public function settingBiaya()
    {
        return $this->belongsTo(SettingBiaya::class);
    }
}
