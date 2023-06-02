<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Prescription.
 *
 * @package namespace App\Models;
 */
class Prescription extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id' , 'appointment_id', 'prescription'
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function appointment(){
        return $this->belongsTo(Appointment::class);
    }

}
