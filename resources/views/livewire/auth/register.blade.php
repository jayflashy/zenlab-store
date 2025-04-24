<div>

    <h4 class="account-content__title mb-48 text-capitalize">Create An Account</h4>

    <form wire:submit.prevent="register">
        <div class="row gy-4">
            <div class="col-12">
                <label for="name" class="form-label mb-2 font-18 font-heading fw-600">Full Name</label>
                <div class="position-relative">
                    <input type="text" class="common-input common-input--bg common-input--withIcon" id="name"
                        placeholder="Your full name" wire:model.lazy="name">
                    <span class="input-icon"><img src="{{ static_asset('images/icons/user-icon.svg') }}" alt=""></span>
                    @error('name')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
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
                <label for="username" class="form-label mb-2 font-18 font-heading fw-600">Username</label>
                <div class="position-relative">
                    <input type="text" class="common-input common-input--bg common-input--withIcon" id="username"
                        placeholder="Choose a username" wire:model.lazy="username">
                    <span class="input-icon"><img src="{{ static_asset('images/icons/user-icon.svg') }}" alt=""></span>
                    @error('username')
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
                <div class="common-check my-2">
                    <input class="form-check-input" type="checkbox" wire:model="terms" id="agree">
                    <label class="form-check-label mb-0 fw-400 font-16 text-body" for="agree">
                        I agree to the terms &amp; conditions
                    </label>
                    @error('terms')
                        <span class="d-block text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-main btn-lg w-100 pill" wire:loading.attr="disabled">
                    <span wire:loading.remove>Create An Account</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
            <div class="col-sm-12 mb-0">
                <div class="have-account">
                    <p class="text font-14">Already a member? <a class="link text-main text-decoration-underline fw-500"
                            href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </form>
</div>

@section('title', 'Register')
@include('layouts.meta')
