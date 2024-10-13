<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;

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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCurrent($query): mixed
    {
        $now = Carbon::now()->toDateTimeString();

        return $query
            ->where('is_active', 1)
            ->where('active_from', '<=', $now)
            ->where('active_until', '>', $now);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeFuture($query): mixed
    {
        $now = Carbon::now()->toDateTimeString();

        return $query->where('active_from', '>', $now);
    }

    /**
     * @param $query
     * @param int $userId
     * @return mixed
     */
    public function scopeByUserId($query, int $userId): mixed
    {
        return $query->where('user_id', $userId);
    }
}
