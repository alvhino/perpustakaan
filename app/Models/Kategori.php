<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $fillable=array(
    'nama_kategori',
);
    public function buku()
    {
        return $this->hasMany(Buku::class,'id_kategori');
    }
}
