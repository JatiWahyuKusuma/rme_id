<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadanganbbModel extends Model
{
    use HasFactory;
    protected $table = 'm_cadangan_bb'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'cadanganbb_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = true;

    protected $fillable = [
        'opco_id',
        'latitude',
        'longitude',
        'jarak',
        'luas_ha',
        'kebutuhan_pertahun_ton',
        'komoditi',
        'lokasi_iup',
        'sd_cadangan_ton',
        'status_penyelidikan',
        'status_pembebasan',
        'catatan',
        'kabupaten',
        'kecamatan',
        'masa_berlaku_iup',
        'masa_berlaku_ppkh',
        'umur_cadangan_thn',
        'umur_masa_berlaku_izin',
    ];

    public function opco(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'opco_id', 'opco_id');
    }
}
