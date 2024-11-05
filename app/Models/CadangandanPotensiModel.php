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

    public function saveWithHistory($requestData)
    {
        // Simpan perubahan ke tabel cadangan utama
        $this->fill($requestData);
        $this->save();

        // Simpan riwayat perubahan ke tabel riwayat_cadangan_potensi
        RiwayatCadanganPotensiModel::create([
            'cadpot_id' => $this->cadpot_id,
            'opco_id' => $this->opco_id,
            'jarak' => $this->jarak,
            'komoditi' => $this->komoditi,
            'lokasi_iup' => $this->lokasi_iup,
            'tipe_sd_cadangan' => $this->tipe_sd_cadangan,
            'sd_cadangan_ton' => $this->sd_cadangan_ton,
            'catatan' => $this->catatan,
            'status_penyelidikan' => $this->status_penyelidikan,
            'acuan' => $this->acuan,
            'kabupaten' => $this->kabupaten,
            'kecamatan' => $this->kecamatan,
            'luas_ha' => $this->luas_ha,
            'masa_berlaku_iup' => $this->masa_berlaku_iup,
            'masa_berlaku_ppkh' => $this->masa_berlaku_ppkh,
            'lastUpdate' => now(), // Waktu update terakhir
        ]);
    }
}
