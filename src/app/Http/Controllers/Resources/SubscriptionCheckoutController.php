<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class SubscriptionCheckoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $plan): Response
    {
        $prices = [
            'monthly' => config('services.stripe.price_ai_monthly'),
            'yearly' => config('services.stripe.price_ai_yearly')
        ];

        abort_unless(isset($prices[$plan]), 404, 'Plan no válido');

        $checkout = $request->user()
            ->newSubscription('default', $prices[$plan])
            // ->allowPromotionCodes()
            ->checkout([
                'success_url' => route('billing.success'),
                'cancel_url' => route('billing.cancel')
            ]);

        return Inertia::location($checkout->url);
    }
}
