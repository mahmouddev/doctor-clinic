<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Appointment.
 *
 * @package namespace App\Models;
 */
class Appointment extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dov' , 'patient_id', 'type'
    ];

    protected $casts = [
        'dov' => 'date',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class);
    }

    public function prescription(){
        return $this->hasOne(Prescription::class);
    }
}
