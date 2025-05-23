<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id'; 
    public $incrementing = true;             
    protected $keyType = 'int';               

    protected $fillable = [
        'user_id',
        'midwife_id',
        'date_time',
        'status',
        'notes',
    ];

    /**
     * Format waktu janji temu
     */
    public function getFormattedVisitTime()
    {
        return date('h:ia', strtotime($this->date_time));
    }

    /**
     * Ambil inisial dari user_id
     * (sebaiknya diganti jika kamu sudah punya relasi ke tabel user)
     */
    public function getInitials()
    {
        return 'U' . $this->user_id;
    }

    /**
     * Relasi ke User (opsional)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Midwife (opsional)
     */
    public function midwife()
    {
        return $this->belongsTo(Midwife::class);
    }
}
