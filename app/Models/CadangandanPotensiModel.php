<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadangandanPotensiModel extends Model
{
    use HasFactory;

    protected $table = 'm_cadangan_potensi'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'cadpot_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = true;

    protected $fillable = [
        'opco_id',
        'jarak',
        'latitude',
        'longitude',
        'no_id',
        'komoditi',
        'lokasi_iup',
        'tipe_sd_cadangan',
        'sd_cadangan_ton',
        'catatan',
        'status_penyelidikan',
        'acuan',
        'kabupaten',
        'kecamatan',
        'luas_ha',
        'masa_berlaku_iup',
        'masa_berlaku_ppkh',
    ];

    public function opco(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'opco_id', 'opco_id');
    }
}
