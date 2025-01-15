<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_kategori',
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_kategori');
    }
}
