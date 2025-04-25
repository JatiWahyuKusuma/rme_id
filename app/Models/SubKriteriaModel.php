<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubKriteriaModel extends Model
{
    
    use HasFactory;
    protected $table = 'subkriteria'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'subkriteria_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = true;

    protected $fillable = [
        'kriteria_id',
        'nama_subkriteria',
        'bobot_subkriteria',
    ];


    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'kriteria_id', 'kriteria_id');
    }

    
}
