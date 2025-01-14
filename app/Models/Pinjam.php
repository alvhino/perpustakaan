<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;
    protected $table = 'pinjam';
    protected $primaryKey = 'id';
    protected $fillable=array(
    'id_user',
    'id_buku',
    'status',
);
}
