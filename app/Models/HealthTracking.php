<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthTracking extends Model
{
    use HasFactory;

    protected $primaryKey = 'tracking_id';
    protected $table = 'health_trackings';

    protected $fillable = [
        'user_id',
        'pregnancy_id',
        'date_recorded',
        'weight',
        'height', // Added height
        'blood_pressure',
        'heart_rate',
        'notes',
        'pregnancy_week', // Added pregnancy_week
    ];

    protected $casts = [
        'date_recorded' => 'datetime:Y-m-d',
        'weight' => 'decimal:3',
        'height' => 'decimal:3', // Added height cast
        'heart_rate' => 'integer',
        'pregnancy_week' => 'integer', // Added pregnancy_week cast
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function pregnancy()
    {
        return $this->belongsTo(UserPregnant::class, 'pregnancy_id', 'pregnancy_id');
    }
}
