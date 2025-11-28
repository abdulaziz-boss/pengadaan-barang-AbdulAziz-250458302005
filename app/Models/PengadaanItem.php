<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengadaanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengadaan_id',
        'barang_id',
        'jumlah',
        'harga_saat_pengajuan',
        'total_harga_item',
    ];

    public function pengadaan()
    {
        return $this->belongsTo(Pengadaan::class);
    }

   public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
