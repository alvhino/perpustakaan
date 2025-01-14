<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoroi';
    protected $primaryKey = 'id';
    protected $fillable=array(
    'nama_kategori',
);
}
