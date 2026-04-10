<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_penginput',
        'nama_barang',
        'jumlah_barang',
        'foto_bukti',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
