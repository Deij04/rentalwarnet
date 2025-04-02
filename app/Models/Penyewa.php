<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penyewa extends Model
{
    /** @use HasFactory<\Database\Factories\PenyewaFactory> */
    use HasFactory;
    protected $table = 'penyewa';
    protected $fillable = ['user_id','Umur','Alamat','Jenis Kelamin'];
    public function user() {
       return $this->belongsTo(User::class);
    }
    public function trasaksi() {
        return $this->hasMany(Transaksi::class);
    }

}
