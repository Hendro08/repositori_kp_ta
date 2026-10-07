<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notification';
    protected $primaryKey = 'id_notif';
    protected $guarded = []; 

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
