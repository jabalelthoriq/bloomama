<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'calendar_events';

    protected $fillable = [
        'title',
        'description',
        'start_date_time',
        'end_date_time',
        'status',
    ];



    protected $primaryKey = 'event_id';
}
