<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, Billable;

    public function sendEmailVerificationNotification()
    {
        $this->notify(new \App\Notifications\VerifyEmail());
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all of the budgets for the Budget
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * Retrieve the user's active subscription plan interval.
     *
     * Checks if the user is subscribed to the default subscription and maps
     * their active Stripe price ID to a readable plan name ('monthly' or 'yearly').
     *
     * @return string|null The active plan identifier ('monthly', 'yearly'), or null if unsubscribed or unmatched.
     */
    public function currentPlan(): ?string
    {
        if (!$this->subscribed('default')) {
            return null;
        }

        return match (true) {
            $this->subscribedToPrice(config('services.stripe.price_ai_monthly'), 'default') => 'monthly',
            $this->subscribedToPrice(config('services.stripe.price_ai_yearly'), 'default') => 'yearly',

            default => null,
        };
    }

    /**
     * Determine whether the user is currently subscribed to the monthly plan.
     *
     * @return bool True if the user's active plan is 'monthly', false otherwise.
     */
    public function isOnMonthlyPlan(): bool
    {
        return $this->currentPlan() === 'monthly';
    }

    /**
     * Determine whether the user is currently subscribed to the yearly plan.
     *
     * @return bool True if the user's active plan is 'yearly', false otherwise.
     */
    public function isOnYearlyPlan(): bool
    {
        return $this->currentPlan() === 'yearly';
    }
}
