<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'jumlah_barang',
        'foto_bukti',
        'user_id',
        'nama_penginput',
        'satuan_barang',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
