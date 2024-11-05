<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatCadanganPotensiModel extends Model
{
    protected $table = 'riwayat_cadangan_potensi'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = true;

    protected $fillable = [
        'cadpot_id',
        'opco_id',
        'field_change',
        'old_value',
        'new_value',
    ];

    public function riwayatcadpot()
    {
        return $this->belongsTo(CadangandanPotensiModel::class, 'cadpot_id');
    }
    
    public function Opco()
    {
        return $this->belongsTo(OpcoModel::class, 'opco_id');
    }
}
