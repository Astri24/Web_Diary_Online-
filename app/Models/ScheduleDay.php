<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleDay extends Model
{
    use HasFactory;

    protected $table = "schedule_days";

    protected $fillable = [
        'hari'
    ];

    public function subjects() {
        return $this->hasMany(ScheduleSubject::class, 'day_id');
    }
}
