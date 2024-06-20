<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['flight_id', 'email'];

    public function flight() {
        return $this->belongsTo(Flight::class);
    }
}
