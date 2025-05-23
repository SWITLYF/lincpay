@extends('frontend::layouts.user')
@section('title')
{{ __('Deposit Success') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="transaction-success-block success">
                <div class="icon"><i data-lucide="droplet"></i></div>
                <div class="headding">{{$notify['title']}}</div>
                <div class="text">{{$notify['p']}}</div>
                <div class="trx">{{ $notify['strong'] }}</div>
                <a href="{{ $notify['action'] }}" class="site-btn polis-btn">{{ __('Deposit Again') }}</a>
            </div>
        </div>
    </div>
@endsection

