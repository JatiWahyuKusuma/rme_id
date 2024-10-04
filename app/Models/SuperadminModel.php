<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperadminModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'm_superadmin'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'superadmin_id'; // Mendefinisikan primary key dari tabel yang digunakan
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'level_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Jika Anda memiliki password yang harus di-hash, tambahkan mutator
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

       public function level(): BelongsTo
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    public static function isSuperAdmin($userId)
    {
        return self::where('user_id', $userId)->exists();
    }
}

