<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable = ['hotel_id', 'user_id', 'check_in', 'check_out', 'status'];

    public function payments()
    {
        return $this->hasOne(Payment::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
