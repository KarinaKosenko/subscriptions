<h4>Adjust Subscription</h4>
<small>*The newly created subscription will be applied after the current one finishes.</small>
<hr>
<form method="POST"
      action="{{ route('subscriptions.store-user-subscription', ['user' => $data['user']]) }}"
      id="subscription-form"
      name="subscription-form">
    @csrf

    <div class="form-group">
        <label for="pricing_plan_id">Pricing Plan</label>
        <select class="form-control" id="pricing_plan_id" name="pricing_plan_id">
            @foreach($data['pricing_plan_options'] as $planOption)
                <option value="{{ $planOption['value'] }}" @if($data['current_subscription']['pricing_plan_id'] == $planOption['value']) selected @endif>
                    {{ $planOption['label'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="payment_period_id">Payment Period</label>
        <select class="form-control" id="payment_period_id" name="payment_period_id">
            @foreach($data['payment_period_options'] as $periodOption)
                <option value="{{ $periodOption['value'] }}" @if($data['current_subscription']['payment_period_id'] == $periodOption['value']) selected @endif>
                    {{ $periodOption['label'] }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="users_number">Number of Users</label>
        <input type="number"
               name="users_number"
               step="1"
               min="0"
               id="users_number"
               value="{{ old('users_number') ?? $data['current_subscription']['users_number'] }}"
               class="form-control @error('users_number') is-invalid @enderror"
        >
        @error('users_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
