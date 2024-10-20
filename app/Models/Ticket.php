<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationship to the user who created the ticket
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    // Relationship to the user (admin) handling the ticket
    public function handler()
    {
        return $this->belongsTo(User::class, 'handler_id');
    }
}
