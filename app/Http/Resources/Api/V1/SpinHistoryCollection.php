<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpinHistoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'links' => [
                'self' => url('/spins'),
                'next' => null, 
                'last' => null, 
            ],
            'data' => $this->collection->map(function ($spin) {
                return new SpinHistoryResource($spin);
            }),
        ];
    }
}
