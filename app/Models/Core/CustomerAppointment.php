<?php

namespace App\Models\Core;

use App\Models\Account\AppointmentType;
use App\Models\Core\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasCamelCaseAttributes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class CustomerAppointment extends Model
{
    use HasFactory, HasCamelCaseAttributes, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_customer_appointment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_id',
        'customer_id',
        'appointment_type_id',
        'trainer_id',
        'appointment_start',
        'appointment_end',
        'notes',
        'duration',
        'appointment_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'appointment_start' => 'datetime',
        'appointment_end' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return BelongsTo
     */
    public function appointmentType(): BelongsTo
    {
        return $this->belongsTo(AppointmentType::class);
    }

    public static function appointmentEndDateTime(string $appointmentStart, int $duration): string
    {
       return Carbon::parse($appointmentStart)->addMinutes($duration)->format('Y-m-d H:i:s');
    }
}
