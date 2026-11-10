<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use Illuminate\Http\Request;

class TicketScanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Budget $budget)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:1240']
        ]);
    }
}
