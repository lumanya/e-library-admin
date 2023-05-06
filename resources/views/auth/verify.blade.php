@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>{{ __('Verify Your Email Address') }}</h2></div>

                <div class="card-body text-center">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('You didn\'t receive the email?') }}
                        <br>
                        <div class="mall-20 text-center">
                            <a href="{{ route('verification.resend') }}" class="btn btn-sm btn-primary"><i class="fas fa-paper-plane"></i> {{ __('Click here to request another') }}</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
