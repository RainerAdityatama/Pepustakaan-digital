<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    
    protected $fillable = [
        'stock_id',
        'user_id',
        'book_id',
        'tanggal_peminjaman',
        'tanggal_pengembalian_seharusnya',
        'tanggal_pengembalian',
        'status',
        'denda',
    ];

    protected $casts = [
        'tanggal_pengembalian_seharusnya' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function book() {
        return $this->belongsTo(Books::class);
    }

    public function stock(): BelongsTo
    {
    return $this->belongsTo(Stok::class, 'book_id');
    }   

    public function denda(): HasOne
    {
        return $this->hasOne(Denda::class);
    }
}
