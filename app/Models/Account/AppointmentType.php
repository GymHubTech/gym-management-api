<?php

namespace App\Models\Account;

use App\Traits\HasCamelCaseAttributes;
use App\Models\Core\CustomerAppointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppointmentType extends Model
{
    use HasFactory, HasCamelCaseAttributes, SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_appointment_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['account_id', 'name'];


    /**
     * @return HasMan
     */
    public function customerAppointments(): HasMany
    {
        return $this->hasMany(CustomerAppointment::class);
    }
}
