<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function PHPSTORM_META\type;

class SpinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $routeName = $this->spin_type === 'paid' ? 'spin.buy' : 'spin';

        $selfLink = route($routeName, ['id' => $this->id]);

        return [
            'type' => 'spin',
            'id' => $this->id,
            'attributes' => [
                'spin_type' => $this->spin_type,
                'amount' => $this->amount,
                'result' => $this->result,
                'created_at' => $this->created_at->toIso8601String(),
                'updated_at' => $this->updated_at->toIso8601String(),
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ],
                    'links' => [
                        [
                            'self' => 'todo'
                        ]
                    ]
                ],
                'transaction' => [
                    'data' => new WalletTransactionResource($this->whenLoaded('transaction')),
                ],
            ],
            'links' => [
                'self' => $selfLink,
            ]
        ];
    }
}
