<div>

    <h4 class="account-content__title mb-48 text-capitalize">Login to {{$settings->name}}</h4>

    <form wire:submit.prevent="login">
        <div class="row gy-4">
            <div class="col-12">
                <label for="email" class="form-label mb-2 font-18 font-heading fw-600">Email</label>
                <div class="position-relative">
                    <input type="email" class="common-input common-input--bg common-input--withIcon" id="email"
                        placeholder="infoname@mail.com" wire:model.lazy="email">
                    <span class="input-icon"><img src="{{ static_asset('images/icons/envelope-icon.svg') }}" alt=""></span>
                    @error('email')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <label for="your-password" class="form-label mb-2 font-18 font-heading fw-600">Password</label>
                <div class="position-relative">
                    <input type="password" class="common-input common-input--bg common-input--withIcon" id="password"
                        placeholder="6+ characters, 1 Capital letter" wire:model.lazy="password">
                    <span class="input-icon cursor-pointer password-toggle" data-target="password">
                        <img src="{{ static_asset('images/icons/lock-icon.svg') }}" alt="">
                    </span>
                    @error('password')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="flx-between gap-1">
                    <div class="common-check my-2">
                        <input class="form-check-input" type="checkbox" wire:model="remember" name="checkbox" id="keepMe">
                        <label class="form-check-label mb-0 fw-400 font-14 text-body" for="keepMe">Keep me signed in</label>
                    </div>
                    <a href="{{ route('password.request') }}"
                        class="forgot-password text-decoration-underline text-main text-poppins font-14">Forgot password?</a>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-main btn-lg w-100 pill" wire:loading.attr="disabled">
                    <span wire:loading.remove>Login Account</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
            <div class="col-sm-12 mb-0">
                <div class="have-account">
                    <p class="text font-14">New User? <a class="link text-main text-decoration-underline fw-500"
                            href="{{ route('register') }}">Sign Up</a></p>
                </div>
            </div>
        </div>
    </form>
</div>

@section('title', 'Login')
@include('layouts.meta')
