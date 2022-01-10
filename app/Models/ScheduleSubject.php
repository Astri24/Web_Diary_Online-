<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleSubject extends Model
{
    use HasFactory;

    protected $table = "schedule_subjects";

    protected $fillable = [
        'matkul', 'waktu', 'day_id'
    ];

    public function days() {
        return $this->belongsTo(ScheduleDay::class, 'day_id');
    }
}
