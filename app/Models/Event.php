<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id'); //parameter kedua adalah milik model Event, parameter ketiga adalah milik model Group
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id'); //parameter kedua adalah milik model Event, parameter ketiga adalah milik model Group
    }
}
