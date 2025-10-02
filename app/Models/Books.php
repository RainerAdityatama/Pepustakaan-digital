<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Books extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'year',
        'file_path',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stok::class, 'book_id')->where('status', 'tersedia');
    }

    public function peminjaman() {
        return $this->hasMany(Peminjaman::class);
    }

    protected static function booted()
    {
        // Event 'deleting' akan berjalan sebelum sebuah record dihapus
        static::deleting(function (Books $book) {
            
            // 1. Hapus file gambar dari storage jika ada
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }

            // 2. Hapus semua record stok yang berelasi dengan buku ini
            $book->stock()->delete();
        });
    }
}
