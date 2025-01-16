<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable=array(
    'username',
    'password',
    'role',
);

public function pinjam()
{
    return $this->hasMany(pinjam::class, 'id_user');
}
}
