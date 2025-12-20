<?php

namespace App\Repositories\Account;

use App\Models\Account\AppointmentType;
use Illuminate\Support\Collection;

class AppointmentTypeRepository
{

    /**
     * @return Collection
     */
    public function getAllAppointmentTypes(): Collection
    {
        return AppointmentType::where('account_id', 1)
        ->get();
    }


}
