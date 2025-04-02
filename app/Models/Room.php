<?php

namespace App\Models;

use App\Models\Penyewa;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    /** @use HasFactory<\Database\Factories\RoomFactory> */
    use HasFactory;
    protected $table = 'room';
    protected $fillable = ['Nama_ruangan', 'Harga_sewa'];
    

    public function trasaksi() {
        return $this->hasMany(Transaksi::class);
    }


}



