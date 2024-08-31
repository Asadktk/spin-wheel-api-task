<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    protected $table = 'wallet_transactions';
    
    protected $fillable = [
        'transaction_id',
        'user_id',
        'amount',
        'source',
        'type',
    ];
}
