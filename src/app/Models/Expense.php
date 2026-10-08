<?php

namespace App\Models;

use App\Enums\ExpenseCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['budget_id', 'name', 'amount', 'category'])]
class Expense extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseFactory> */
    use HasFactory, SoftDeletes;

    protected $casts = [
        'category' => ExpenseCategory::class
    ];

    protected $appends = ['category_label', 'category_color'];

    /**
     * Get the human-readable label for the expense category.
     *
     * @return string The label corresponding to the expense category.
     */
    public function getCategoryLabelAttribute(): string
    {
        return $this->category->label();
    }

    /**
     * Get the color code associated with the expense category.
     *
     * @return string The color code corresponding to the expense category.
     */
    public function getCategoryColorAttribute(): string
    {
        return $this->category->color();
    }

    /**
     * Get the budget that owns the Expense
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }
}
