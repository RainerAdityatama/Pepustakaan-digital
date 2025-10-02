<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stok extends Model
{
    protected $table = 'stoks';

    protected $fillable = ['book_id', 'status'];

    public function books(): BelongsTo
    {
        return $this->belongsTo(Books::class);
    }

    public function peminjaman(): HasMany
    {
    // BENAR: Satu Stock bisa punya banyak (hasMany) riwayat peminjaman (Rent).
    return $this->hasMany(Peminjaman::class);
    }
}
