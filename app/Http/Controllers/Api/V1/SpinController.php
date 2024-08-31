<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreSpinRequest;
use App\Http\Resources\Api\V1\SpinCollection;
use App\Http\Resources\Api\V1\SpinHistoryCollection;
use App\Http\Resources\Api\V1\SpinResource;
use App\Http\Resources\Api\V1\WalletTransactionResource;
use App\Models\Spin;
use App\Models\WalletTransaction;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SpinController extends Controller
{
    use ApiResponses;

    public function useSpin(StoreSpinRequest $request)
    {
        $user = Auth::user();

        if ($request->spin_type === 'free') {
            $spinsToday = Spin::where('user_id', $user->id)
                ->where('spin_type', 'free')
                ->whereDate('created_at', now()->toDateString())
                ->count();

            if ($spinsToday >= 3) {
                return $this->error(['message' => 'You have used all free spins for today.'], 403);
            }
        }

        $prize = 100;
        $user->wallet->deposit($prize);

        $transactionId = 'speedforce-' . now()->year . '-' . strtoupper(Str::random(9));
        $transaction = WalletTransaction::create([
            'transaction_id' => $transactionId,
            'user_id' => $user->id,
            'amount' => $prize,
            'source' => 'spin_prize',
            'type' => 'addition',
        ]);

        $spin = Spin::create([
            'user_id' => $user->id,
            'spin_type' => $request->spin_type,
            'amount' => $prize,
            'result' => 'Won ' . $prize
        ]);

        return $this->ok([
            'spin' => new SpinResource($spin),
            'transaction' => new WalletTransactionResource($transaction),
            'balance' => $user->wallet->balance
        ]);
    }

    public function buySpin(StoreSpinRequest $request)
    {
        $user = Auth::user();
        $cost = 200;

        if ($user->wallet->balance < $cost) {
            return $this->error(['message' => 'Insufficient balance to buy a spin.'], 403);
        }

        $user->wallet->withdraw($cost);

        $transactionId = 'speedforce-' . now()->year . '-' . strtoupper(Str::random(9));
        $transaction = WalletTransaction::create([
            'transaction_id' => $transactionId,
            'user_id' => $user->id,
            'amount' => $cost,
            'source' => 'buy_spin',
            'type' => 'deduction',
        ]);

        $spin = Spin::create([
            'user_id' => $user->id,
            'spin_type' => 'paid',
            'amount' => $cost,
            'result' => 'Paid spin purchased'
        ]);

        return $this->ok([
            'spin' => new SpinResource($spin),
            'transaction' => new WalletTransactionResource($transaction),
            'balance' => $user->wallet->balance
        ]);
    }




    public function getUserSpinHistory(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return $this->error('User not authenticated', 401);
        }

        $spins = $user->spins;
        return new SpinHistoryCollection($spins);
    }
}
