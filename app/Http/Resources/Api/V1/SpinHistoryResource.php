<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpinHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'spins',
            'id' => (string) $this->id,
            'attributes' => [
                'spin_type' => $this->spin_type,
                'amount' => $this->amount,
                'result' => $this->result,
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
            'links' => [
                'self' => url("#"),
            ],
        ];
    }
}
