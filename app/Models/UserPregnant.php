<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPregnant extends Model
{
const STATUS_ACTIVE = 'active';
const STATUS_COMPLETED = 'completed';
const STATUS_INACTIVE = 'inactive';

    use HasFactory;

    protected $primaryKey = 'pregnancy_id';
    protected $table = 'user_pregnancies';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'start_date',
        'due_date',
        'gravida',
        'para',
        'abortus',
        'pregnancy_week',
        'last_check_date',
        'notes',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'last_check_date' => 'date',
        'gravida' => 'integer',
        'para' => 'integer',
        'abortus' => 'integer',
        'pregnancy_week' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function healthTrackings()
    {
        return $this->hasMany(HealthTracking::class, 'pregnancy_id', 'pregnancy_id')
            ->orderBy('date_recorded', 'desc');
    }
    public function scopeActive($query)
{
    return $query->where('status', 'active');
}
}
