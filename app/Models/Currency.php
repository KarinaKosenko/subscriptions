<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Currency extends Model
{
    /**
     * @var string
     */
    protected $table = 'currencies';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code'
    ];

    /**
     * @return HasMany
     */
    public function pricingPlans(): HasMany
    {
        return $this->hasMany(PricingPlan::class);
    }
}
