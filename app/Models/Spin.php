<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spin_type',
        'amount',
        'result',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->hasOne(WalletTransaction::class, 'user_id', 'user_id')->latest();
    }
}
