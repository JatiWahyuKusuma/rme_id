<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmurIzinModel extends Model
{
    use HasFactory;
    protected $table = 'umurizin'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'umurizin_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = true;

    protected $fillable = [
        'cadanganbb_id',
        'opco_id',
        'tahun_habis',
        'status'
        
    ];

    public function cadanganbb(): BelongsTo
    {
        return $this->belongsTo(CadanganbbModel::class, 'cadanganbb_id', 'cadanganbb_id');
    }
    
    public function opco(): BelongsTo
    {
        return $this->belongsTo(OpcoModel::class, 'opco_id', 'opco_id');
    }
}
