<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorModel extends Model
{
    use HasFactory;

    protected $table = 'm_vendor'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'vendor_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = false;

    protected $fillable = [
        'opco_id',
        'jarak',
        'latitude',
        'longitude',
        'vendor',
        'komoditi',
        'desa',
        'kecamatan',
        'kabupaten',
        'kap_ton_thn',
        'konsumsi_ton_thn',
    ];

    public function opco(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'opco_id', 'opco_id');
    }
}
