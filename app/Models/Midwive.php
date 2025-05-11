<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword;

class Midwive extends Authenticatable
{
    use  HasFactory, Notifiable;
    use Notifiable;

    // Tentukan nama tabel jika berbeda dengan konvensi Laravel
    protected $table = 'midwives';

    // Tentukan primary key yang benar
    protected $primaryKey = 'midwife_id';

    // Tentukan juga tipe data primary key jika bukan integer
    public $incrementing = true; // set false jika bukan auto increment

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'status',
        'profile_picture',
        'available_day',
        'start_time',
        'end_time',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
