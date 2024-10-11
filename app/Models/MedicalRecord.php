<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $fillable = ['patient_id', 'doctor_id', 'appointment_date', 'diagnosis', 'prescription'];

}
