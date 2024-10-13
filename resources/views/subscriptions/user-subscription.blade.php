@extends('index')

@section('content')
    <section class="jumbotron text-center">
        <div class="container">
            @if (session('status'))
                <p class="alert alert-{{ session('status') }}">{{ session('message') }}</p>
                <hr>
            @endif
            @include('subscriptions.subscription-block', ['subscription' => $data['current_subscription']])
            <hr>
            @include('subscriptions.subscription-block', [
                'subscription' => $data['next_subscription'],
                'status' => 'Next'
            ])
            <hr>
            @include('subscriptions.subscription-form')
        </div>
    </section>
@endsection
