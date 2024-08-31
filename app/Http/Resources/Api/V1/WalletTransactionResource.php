<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'type' => 'wallet_transactions',
                'id' => (string) $this->id,
                'attributes' => [
                    'transaction_id' => $this->transaction_id,
                    'amount' => $this->amount,
                    'source' => $this->source,
                    'type' => $this->type,
                    'created_at' => $this->created_at->toIso8601String(),
                    'updated_at' => $this->updated_at->toIso8601String(),
                ],
                'links' => [
                    'self' => url("/wallet-transactions/{$this->id}"),
                ],
            ],
        ];
    }
}
