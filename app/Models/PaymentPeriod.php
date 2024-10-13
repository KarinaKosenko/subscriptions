<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPeriod extends Model
{
    const MONTH_TYPE = 'month';
    const YEAR_TYPE = 'year';
    const TYPES = [
        self::MONTH_TYPE,
        self::YEAR_TYPE
    ];

    /**
     * @var string
     */
    protected $table = 'payment_periods';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'amount',
        'discount_percent'
    ];
}
