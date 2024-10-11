<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingPlan extends Model
{
    /**
     * @var string
     */
    protected $table = 'pricing_plans';

    /**
     * @var string[]
     */
    protected $with = ['currency'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'monthly_price_per_user',
        'currency_id',
        'is_active'
    ];

    /**
     * @return BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
