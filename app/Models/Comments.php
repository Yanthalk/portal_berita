<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
    public $timestamps = false; 

    protected $fillable = [
        'komentar',
        'tanggal_komentar',
        'user_id',
        'news_id'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi ke berita
    public function berita()
    {
        return $this->belongsTo(News::class, 'news_id', 'news_id');
    }
}
