<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spin;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpinHistoryController extends Controller
{
    use ApiResponses;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Ensure the user has admin role
        if (!Auth::user()->hasRole('Admin')) {
            return $this->error('Unauthorized', 403);
        }

        // Retrieve all spins
        $spins = Spin::all();

        return $this->ok(['spins' => $spins]);
    }
}
