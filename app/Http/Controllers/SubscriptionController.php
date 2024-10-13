<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use Exception;
use App\Repositories\Interfaces\{PaymentPeriodRepositoryInterface,
    PricingPlanRepositoryInterface,
    SubscriptionRepositoryInterface};
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SubscriptionController extends Controller
{
    /**
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     * @param PricingPlanRepositoryInterface $pricingPlanRepository
     * @param PaymentPeriodRepositoryInterface $paymentPeriodRepository
     */
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptionRepository,
        private PricingPlanRepositoryInterface $pricingPlanRepository,
        private PaymentPeriodRepositoryInterface $paymentPeriodRepository
    )
    {}

    /**
     * @param User $user
     * @return View
     */
    public function getUserSubscription(User $user): View
    {
        $data['user'] = $user;
        $data['current_subscription'] = $this->subscriptionRepository->getCurrentSubscriptionArrayByUserId($user->id);
        $data['next_subscription'] = $this->subscriptionRepository->getNextSubscriptionArrayByUserId($user->id);
        $data['pricing_plan_options'] = $this->pricingPlanRepository->getOptionsArray();
        $data['payment_period_options'] = $this->paymentPeriodRepository->getOptionsArray();

        return view('subscriptions.user-subscription', ['data' => $data]);
    }

    /**
     * @param User $user
     * @param StoreSubscriptionRequest $request
     * @return RedirectResponse
     */
    public function storeUserSubscription(User $user, StoreSubscriptionRequest $request): RedirectResponse
    {
        try {
            $this->subscriptionRepository->storeSubscriptionByUserId(
                userId: $user->id,
                pricingPlanId: $request->input('pricing_plan_id'),
                paymentPeriodId: $request->input('payment_period_id'),
                usersNumber: $request->input('users_number')
            );

            return redirect()
                ->route('subscriptions.get-user-subscription', ['user' => $user])
                ->withInput()
                ->with([
                    'status' => 'success',
                    'message' => 'Subscription has been updated'
                ]);
        } catch (Exception $e) {
            return redirect()
                ->route('subscriptions.get-user-subscription', ['user' => $user])
                ->withInput()
                ->with([
                    'status' => 'danger',
                    'message' => $e->getMessage()
                ]);
        }
    }
}
