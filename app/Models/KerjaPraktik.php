<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KerjaPraktik extends Model
{
    use HasFactory;
    protected $table = 'kerja_praktik';
    protected $primaryKey = 'id_kp';
    protected $guarded = [];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'tgl_kumpul' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
