<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPeriod extends Model
{
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
