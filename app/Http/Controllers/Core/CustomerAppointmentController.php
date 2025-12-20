<?php

namespace App\Http\Controllers\Core;

use App\Helpers\ApiResponse;
use App\Http\Requests\Core\CustomerAppointmentRequest;
use App\Http\Resources\Core\CustomerAppointmentResource;
use App\Repositories\Core\CustomerAppointmentRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomerAppointmentController
{
    public function __construct(private CustomerAppointmentRepository $customerAppointmentRepository)
    {
    }

    public function getAllCustomerAppointments(int $customerId): JsonResponse
    {
        $appointments = $this->customerAppointmentRepository->getAllCustomerAppointments($customerId);
        return ApiResponse::success(CustomerAppointmentResource::collection($appointments)->response()->getData(true));
    }

    public function createCustomerAppointment(int $customerId, CustomerAppointmentRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['customerId'] = $customerId;
        $appointment = $this->customerAppointmentRepository->createCustomerAppointment($validated);
        return ApiResponse::success(new CustomerAppointmentResource($appointment->load('appointmentType')), 'Appointment created successfully', 201);
    }

    public function updateCustomerAppointment(int $id, CustomerAppointmentRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $appointment = $this->customerAppointmentRepository->updateCustomerAppointment($id, $validated);
        return ApiResponse::success(new CustomerAppointmentResource($appointment->load('appointmentType')), 'Appointment updated successfully');
    }

    public function deleteCustomerAppointment(int $id): JsonResponse
    {
        $this->customerAppointmentRepository->deleteCustomerAppointment($id);
        return ApiResponse::success(null, 'Appointment deleted successfully');
    }
}
