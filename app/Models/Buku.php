<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $primaryKey = 'id';
    protected $fillable=array(
    'judul',
    'sampul',
    'selengkapnya',
    'id_kategori',
);

public function kategori()
{
    return $this->hasMany(Kategori::class,'id_kategori');
}
}
