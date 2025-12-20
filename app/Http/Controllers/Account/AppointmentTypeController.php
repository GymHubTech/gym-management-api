<?php

namespace App\Http\Controllers\Account;

use App\Helpers\ApiResponse;
use App\Http\Resources\Account\AppointmentTypeResource;
use App\Repositories\Account\AppointmentTypeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AppointmentTypeController
{
    public function __construct(private AppointmentTypeRepository $appointmentTypeRepository)
    {
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getAllAppointmentTypes(Request $request): JsonResponse
    {
        $appointmentTypes = $this->appointmentTypeRepository->getAllAppointmentTypes();
        return ApiResponse::success(AppointmentTypeResource::collection($appointmentTypes)->response()->getData(true));
    }
}
