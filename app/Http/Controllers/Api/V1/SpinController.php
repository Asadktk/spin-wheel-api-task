<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreSpinRequest;
use App\Http\Resources\Api\V1\SpinHistoryCollection;
use App\Http\Resources\Api\V1\SpinHistoryResource;
use App\Http\Resources\Api\V1\SpinResource;
use App\Models\Spin;
use App\Models\WalletTransaction;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SpinController extends Controller
{
    use ApiResponses;

    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    private function getUserSpins()
    {
        return Spin::where('user_id', $this->user->id)
            ->with(['user', 'transaction'])
            ->paginate();
    }

    private function createTransaction($amount, $source, $type)
    {
        $transactionId = 'speedforce-' . now()->year . '-' . strtoupper(Str::random(9));
        return WalletTransaction::create([
            'transaction_id' => $transactionId,
            'user_id' => $this->user->id,
            'amount' => $amount,
            'source' => $source,
            'type' => $type,
        ]);
    }

    private function createSpin($spinType, $amount, $result)
    {
        return Spin::create([
            'user_id' => $this->user->id,
            'spin_type' => $spinType,
            'amount' => $amount,
            'result' => $result,
        ]);
    }

    public function useSpin(StoreSpinRequest $request)
    {
        $freeSpinsToday = Spin::where('user_id', $this->user->id)
            ->where('spin_type', 'free')
            ->whereDate('created_at', now()->toDateString());


        if ($request->spin_type === 'free' && $freeSpinsToday->count() >= 50) {
            return $this->error(['message' => 'You have used all free spins for today.'], 403);
        }

        $prize = 100;
        $this->user->wallet->deposit($prize);

        $this->createTransaction($prize, 'spin_prize', 'addition');
        $this->createSpin($request->spin_type, $prize, 'Won ' . $prize);

        return SpinResource::collection($this->getUserSpins());
    }

    public function buySpin(StoreSpinRequest $request)
    {
        if ($request->spin_type !== 'paid') {
            return $this->error(['message' => 'Invalid spin type for this action.'], 403);
        }

        $cost = 200;

        if ($this->user->wallet->balance < $cost) {
            return $this->error(['message' => 'Insufficient balance to buy a spin.'], 403);
        }

        $this->user->wallet->withdraw($cost);

        $this->createTransaction($cost, 'buy_spin', 'deduction');
        $this->createSpin($request->spin_type, $cost, 'Paid spin purchased');

        return SpinResource::collection($this->getUserSpins());
    }

    public function getUserSpinHistory()
    {
        if (!$this->user) {
            return $this->error('User not authenticated', 401);
        }

        return SpinHistoryResource::collection($this->user->spins);
    }
}
