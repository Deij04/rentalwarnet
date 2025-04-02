<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiFactory> */
    use HasFactory;
    protected $table= 'Transaksi';
    protected $fillable=['user_id','penyewa_id','room_id','date'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function penyewa() {
       return $this->belongsTo(Penyewa::class);
    }
    public function room() {
        return $this->belongsTo(Room::class);
    }

}
