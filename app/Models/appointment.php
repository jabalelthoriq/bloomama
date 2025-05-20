<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'user_id',
        'midwife_id',
        'date_time',
        'status',
        'notes',
    ];

    public function getFormattedVisitTime()
    {
        return date('h:ia', strtotime($this->date_time));
    }

    public function getInitials()
    {
        // Since we don't have a patient_name field, we'll return a placeholder
        // You might want to establish relationships with a users table to get the actual name
        return 'U' . $this->user_id;
    }
}
