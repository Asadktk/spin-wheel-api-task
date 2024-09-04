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
        $includeUser = $request->routeIs('transaction.show');

        return [
            'type' => 'wallet_transaction',
            'id' => $this->id,
            'attributes' => [
                'transaction_id' => $this->transaction_id,
                'amount' => $this->amount,
                'source' => $this->source,
                'type' => $this->type,
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
            'relationships' => [
                'user' => $this->when($includeUser, function () {
                    return [
                        'data' => [
                            'type' => 'user',
                            'id' => $this->user_id,
                        ],
                        'links' => [
                            'self' => route('user.show', ['id' => $this->user_id]),
                        ],
                    ];
                }),
            ],
            'links' => [
                'self' => 'todo'
                // 'self' => route('transaction.show', ['id' => $this->id]),
            ],
        ];
    }
}
