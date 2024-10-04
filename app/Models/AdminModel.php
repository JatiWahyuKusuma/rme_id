<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
class AdminModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_admin'; //mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'admin_id'; //mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = false;

    protected $fillable = [
        'level_id',
        'opco_id',
        'nama',
        'email',
        'password',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public function opco(): BelongsTo
    {
        return $this->belongsTo(OpcoModel::class, 'opco_id', 'opco_id');
    }
}
