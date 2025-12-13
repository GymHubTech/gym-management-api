<?php

namespace App\Http\Controllers\Core;

use App\Helpers\ApiResponse;
use App\Http\Requests\Core\CustomerScanRequest;
use App\Http\Resources\Core\CustomerScanResource;
use App\Repositories\Core\CustomerScanRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class CustomerScanController
{
    public function __construct(
        private CustomerScanRepository $customerScanRepository,
    )
    {}

    /**
     * @return JsonResponse
     */
    public function getAllCustomerScans($customerId): JsonResponse
    {
        $customerScans = $this->customerScanRepository->getAllScans((int)$customerId);
        return ApiResponse::success(CustomerScanResource::collection($customerScans)->response()->getData(true));
    }

    /**
     * @param $customerId
     * @param CustomerScanRequest $request
     *
     * @return JsonResponse
     */
    public function createScan($customerId, CustomerScanRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['customerId'] = (int)$customerId;
        $customerScan = $this->customerScanRepository->createScan($validated);
        return ApiResponse::success(new CustomerScanResource($customerScan->load('files')), 'Scan created successfully', 201);
    }

    /**
     * @param $id
     * @param CustomerScanRequest $request
     *
     * @return JsonResponse
     */
    public function updateCustomerScan($id, CustomerScanRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $customerScan = $this->customerScanRepository->updateScan((int)$id, $validated);
        return ApiResponse::success(new CustomerScanResource($customerScan), 'Scan updated successfully');
    }

    /**
     * @param $id
     *
     * @return JsonResponse
     */
    public function deleteCustomerScan($id): JsonResponse
    {
        $this->customerScanRepository->deleteScan((int)$id);
        return ApiResponse::success(null, 'Scan deleted successfully');
    }
}
