<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news'; // Nama tabel
    protected $primaryKey = 'news_id'; // Primary key

    public $timestamps = false;

    protected $fillable = [
        'judul',
        'deskripsi',
        'konten',
        'gambar',
        'penulis',
        'tanggal_publish',
        'user_id',
        'category_id',
    ];

    // Relasi ke user (jika model User ada)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function Comments()
    {
        return $this->hasMany(Comments::class, 'news_id', 'news_id');
    }

}
