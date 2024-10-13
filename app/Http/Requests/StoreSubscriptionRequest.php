<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\{PaymentPeriodRepositoryInterface, PricingPlanRepositoryInterface};
use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    /**
     * @param PaymentPeriodRepositoryInterface $paymentPeriodRepository
     * @param PricingPlanRepositoryInterface $pricingPlanRepository
     */
    public function __construct(
        private PaymentPeriodRepositoryInterface $paymentPeriodRepository,
        private PricingPlanRepositoryInterface $pricingPlanRepository
    )
    {
        parent::__construct();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $activePricingPlansIds = $this->pricingPlanRepository->getIdsArray();
        $paymentPeriods = $this->paymentPeriodRepository->getIdsArray();

        return [
            'pricing_plan_id' => [
                'required',
                'in:' . implode(',', $activePricingPlansIds)
            ],
            'payment_period_id' => [
                'required',
                'in:' . implode(',', $paymentPeriods)
            ],
            'users_number' => [
                'required',
                'integer',
                'min:1'
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'pricing_plan_id' => 'pricing plan',
        ];
    }
}
