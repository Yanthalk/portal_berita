<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';
    protected $primaryKey = 'category_id'; 
    public $timestamps = false; 

    protected $fillable = [
        'nama_kategori',
    ];

    // Relasi ke berita
    public function berita()
    {
        return $this->hasMany(News::class, 'category_id', 'category_id');
    }
}
