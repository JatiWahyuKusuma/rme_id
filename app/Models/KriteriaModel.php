<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaModel extends Model
{
    use HasFactory;
    protected $table = 'kriteria'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'kriteria_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = true;

    protected $fillable = [
        'nama_kriteria',
        'jenis_kriteria',
        'bobot_kriteria',
    ];

    public function subKriteria()
    {
        return $this->hasMany(SubKriteriaModel::class, 'kriteria_id', 'kriteria_id');
    }
}
