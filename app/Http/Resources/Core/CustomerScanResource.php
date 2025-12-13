<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerScanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'scanType' => $this->scan_type,
            'scanDate' => $this->scan_date,
            'notes' => $this->notes,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'deletedAt' => $this->deleted_at,
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
        ];
    }
}
