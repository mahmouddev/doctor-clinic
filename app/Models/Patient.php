<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Patient.
 *
 * @package namespace App\Models;
 */
class Patient extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'dob',
        'email',
        'phone',
        'gendar',
        'blood_group',
        'diabetic',
        'hbp',
        'heart_diseases',
        'accidents',
        'surgeries',
        'comments'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
    ];

    public function prescriptions(){
        return $this->hasMany(Prescription::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
