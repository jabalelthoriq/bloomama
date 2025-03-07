<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPregnant extends Model
{
    use HasFactory;

    protected $table = 'user_pregnancies';

    protected $fillable = [
        'pregnancy_id',
        'user_id',
        'start_date',
        'pregnancy_week',
        'last_check_date',
        'notes',
    ];

    


}
