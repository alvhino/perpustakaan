<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



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

public function buku()
{
    return $this->belongsTo (Buku::class, 'id_buku');
}

public function user()
{
    return $this->belongsTo (user::class, 'id_user');
}


}
