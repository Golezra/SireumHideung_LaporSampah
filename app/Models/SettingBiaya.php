<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingBiaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'biaya_organik',
        'biaya_anorganik',
        'biaya_campuran',
        'biaya_pengurangan',
        'is_active',
    ];

    public function laporSampah()
    {
        return $this->hasMany(LaporSampah::class);
    }
}
