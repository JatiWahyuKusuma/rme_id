<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcoModel extends Model
{
    use HasFactory;
    protected $table = 'm_opco'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'opco_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = false;

    protected $fillable = [
        'kode_opco',
        'nama_opco',
    ];

    
}
