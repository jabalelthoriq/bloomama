<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPregnant extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $table = 'user_pregnancies';

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
    ];

    /**
     * Get the user that owns the pregnancy record.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
