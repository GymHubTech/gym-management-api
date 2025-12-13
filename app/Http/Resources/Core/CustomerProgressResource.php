<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerProgressResource extends JsonResource
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
            'recordedBy' => $this->recorded_by,

            // Basic Measurements
            'weight' => $this->weight,
            'height' => $this->height,
            'bodyFatPercentage' => $this->body_fat_percentage,
            'bmi' => $this->bmi,

            // Body Measurements
            'chest' => $this->chest,
            'waist' => $this->waist,
            'hips' => $this->hips,
            'leftArm' => $this->left_arm,
            'rightArm' => $this->right_arm,
            'leftThigh' => $this->left_thigh,
            'rightThigh' => $this->right_thigh,
            'leftCalf' => $this->left_calf,
            'rightCalf' => $this->right_calf,

            // Body Composition
            'skeletalMuscleMass' => $this->skeletal_muscle_mass,
            'bodyFatMass' => $this->body_fat_mass,
            'totalBodyWater' => $this->total_body_water,
            'protein' => $this->protein,
            'minerals' => $this->minerals,
            'visceralFatLevel' => $this->visceral_fat_level,
            'basalMetabolicRate' => $this->basal_metabolic_rate,
            'dataSource' => $this->data_source,
            'notes' => $this->notes,
            'recordedDate' => $this->recorded_date,
            'files' => $this->whenLoaded('files', function () {
                return $this->files->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'fileName' => $file->file_name,
                        'fileUrl' => $file->file_url,
                        'thumbnailUrl' => $file->thumbnail_url,
                        'fileSize' => $file->file_size,
                        'mimeType' => $file->mime_type,
                        'fileDate' => $file->file_date,
                        'uploadedBy' => $file->uploaded_by,
                        'remarks' => $file->remarks,
                    ];
                });
            }),
            'customer' => $this->whenLoaded('customer', function () {
                return new CustomerResource($this->customer);
            }),

            // Timestamps
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at,
        ];
    }
}
