<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'jurusan';

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'jurusan_id');
    }
}
