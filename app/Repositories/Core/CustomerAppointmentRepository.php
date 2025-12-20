<?php

namespace App\Repositories\Core;

use App\Constant\CustomerAppointmentConstant;
use App\Models\Core\CustomerAppointment;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerAppointmentRepository
{


    public function getAllCustomerAppointments(int $customerId): LengthAwarePaginator
    {
        return CustomerAppointment::where('account_id', 1)
        ->where('customer_id', $customerId)
        ->with('appointmentType')
        ->orderBy('appointment_start', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(50);
    }

    /**
     * @param array $data
     *
     * @return CustomerAppointment
     */
    public function createCustomerAppointment(array $data): CustomerAppointment
    {
        $data['account_id'] = 1;
        $data['created_by'] = 1;
        $data['updated_by'] = 1;
        $data['appointment_status'] = CustomerAppointmentConstant::APPOINTMENT_STATUS_CONFIRMED;

        $startTime = $data['appointment_start'] ?? $data['appointmentStart'] ?? null;
        $duration = $data['duration'] ?? null;

        if ($startTime && $duration) {
            $data['appointment_end'] = CustomerAppointment::appointmentEndDateTime($startTime, $duration);
        }

        return CustomerAppointment::create($data);
    }

    /**
     * @param int $id
     *
     * @return CustomerAppointment
     */
    public function getCustomerAppointmentById(int $id): CustomerAppointment
    {
        return CustomerAppointment::where('account_id', 1)
        ->where('id', $id)
        ->firstOrFail();
    }



    /**
     * @param int $id
     * @param array $data
     *
     * @return CustomerAppointment
     */
    public function updateCustomerAppointment(int $id, array $data): CustomerAppointment
    {
        $data['updated_by'] = 1;
        $customerAppointment = $this->getCustomerAppointmentById($id);

        // Auto-calculate end time if start time or duration is updated
        $startTime = $data['appointment_start'] ?? $data['appointmentStart'] ?? null;
        $duration = $data['duration'] ?? null;

        if ($startTime || $duration) {
            $startTime = $startTime ?? $customerAppointment->appointment_start;
            $duration = $duration ?? $customerAppointment->duration;
            $data['appointment_end'] = CustomerAppointment::appointmentEndDateTime($startTime, $duration);
        }

        $customerAppointment->update($data);
        return $customerAppointment;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function deleteCustomerAppointment(int $id): bool
    {
        $customerAppointment = $this->getCustomerAppointmentById($id);
        return $customerAppointment->update(['appointment_status' => CustomerAppointmentConstant::APPOINTMENT_STATUS_CANCELLED]);
    }
}
