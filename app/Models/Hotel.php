<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'location'];
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
