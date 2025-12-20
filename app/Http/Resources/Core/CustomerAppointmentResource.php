<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Core\CustomerResource;

class CustomerAppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'accountId' => $this->account_id,
            'customerId' => $this->customer_id,
            'appointmentTypeId' => $this->appointment_type_id,
            'appointmentStart' => $this->appointment_start?->format('Y-m-d H:i:s'),
            'appointmentEnd' => $this->appointment_end?->format('Y-m-d H:i:s'),
            'duration' => $this->duration,
            'appointmentStatus' => $this->appointment_status,
            'notes' => $this->notes,
            'appointmentType' => $this->whenLoaded('appointmentType', function () {
                return [
                    'id' => $this->appointmentType->id,
                    'name' => $this->appointmentType->name,
                ];
            }),
            'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
            'deletedAt' => $this->deleted_at?->format('Y-m-d H:i:s'),
        ];
    }
}
