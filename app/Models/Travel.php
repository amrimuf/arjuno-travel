<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'origin', 'destination', 'departure_time', 'user_id', 'is_available'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
