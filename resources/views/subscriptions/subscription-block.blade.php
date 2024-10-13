<div>
    @if($subscription['pricing_plan_id'])
        <h4>{{ $status ?? 'Current' }} Subscription</h4>
        <div>
            <p>Pricing Plan: {{ $subscription['pricing_plan_name'] }}</p>
            <p>Monthly Price Per User: {{ $subscription['monthly_price_per_user'] .  $subscription['currency']}}</p>
            <p>Users Number: {{ $subscription['users_number'] }}</p>
            <p>Price: {{ $subscription['monthly_price'] .  $subscription['currency'] }}</p>
            <p>Payment Period: {{ $subscription['payment_period_type'] }}</p>
            <p>Active From: {{ $subscription['active_from'] }}</p>
            <p>Active Until: {{ $subscription['active_until'] }}</p>
        </div>
    @else
        <h4>No {{ $status ?? 'Current' }} Subscription</h4>
    @endif
</div>
