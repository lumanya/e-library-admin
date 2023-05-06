@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-header bg-transparent text-center">
                    <?php $setting =settingSession('set');?>
                    <div class="row">
                        <div class="col-md-12">
                            
                            <img width="100px" src="{{ getSingleMedia($setting,'site_logo',null,'image',false) }}">
                        </div>
                        <div class="col-md-12">
                            <h2>{{ config('app.name') }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body py-lg-5">
                    <form method="POST" data-toggle="validator" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('E-mail') }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input id="password" type="password" placeholder="{{ __('Password') }}" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-block btn-primary my-4"><i class="fas fa-sign-in-alt"></i> Sign in</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
