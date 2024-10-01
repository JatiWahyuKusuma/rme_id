<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperadminModel extends Model
{
    use HasFactory;

    protected $table = 'm_superadmin'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'superadmin_id'; // Mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = false;

    protected $fillable = [
        'level_id',
        'nama',
        'email',
        'password',
    ];
}
