<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WalletTransactionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($transaction) use ($request) {
                return (new WalletTransactionResource($transaction))->toArray($request)['data']; // Correctly accessing 'data' key
            }),
            'links' => [
                'self' => url('/wallet-transactions'),
                'next' => null, 
                'last' => null, 
            ],
        ];
    }
}
