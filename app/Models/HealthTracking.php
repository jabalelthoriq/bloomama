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
        'blood_pressure',
        'heart_rate',
        'notes'
    ];

    protected $casts = [
        'date_recorded' => 'datetime:Y-m-d',
        'weight' => 'decimal:2',
        'heart_rate' => 'integer'
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
