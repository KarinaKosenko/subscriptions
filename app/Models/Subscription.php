<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    /**
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'pricing_plan_id',
        'payment_period_id',
        'users_number',
        'price',
        'active_from',
        'active_until',
        'is_active'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function pricingPlan(): BelongsTo
    {
        return $this->belongsTo(PricingPlan::class);
    }

    /**
     * @return BelongsTo
     */
    public function paymentPeriod(): BelongsTo
    {
        return $this->belongsTo(PaymentPeriod::class);
    }
}
