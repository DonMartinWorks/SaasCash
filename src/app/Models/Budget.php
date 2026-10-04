<?php

namespace App\Models;

use App\enums\BudgetType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable('user_id', 'name', 'amount', 'type')]
class Budget extends Model
{
    /** @use HasFactory<\Database\Factories\BudgetFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'type' => BudgetType::class
    ];

    /**
     * Get the user that owns the Budget
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the expenses for the Budget
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Determine whether the budget type is general.
     *
     * @return bool True if the budget type is general, false otherwise.
     */
    public function isGeneral(): bool
    {
        return $this->type === BudgetType::General;
    }

    /**
     * Determine whether the budget type is a goal.
     *
     * @return bool True if the budget type is a goal, false otherwise.
     */
    public function isGoal(): bool
    {
        return $this->type === BudgetType::Goal;
    }
}
