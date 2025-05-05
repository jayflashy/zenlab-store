<div>
    <h4 class="account-content__title mb-48 text-capitalize">Reset Password</h4>

    <form wire:submit.prevent="resetPassword">
        <div class="row gy-4">
            <div class="col-12">
                <label for="email" class="form-label mb-2 font-18 font-heading fw-600">Email</label>
                <div class="position-relative">
                    <input type="email" id="email" class="common-input common-input--bg common-input--withIcon"
                        placeholder="infoname@mail.com" wire:model.lazy="email">
                    <span class="input-icon">
                        <img src="{{ static_asset('images/icons/envelope-icon.svg') }}" alt="">
                    </span>
                    @error('email')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="password" class="form-label mb-2 font-18 font-heading fw-600">New Password</label>
                <div class="position-relative">
                    <input type="password" id="password" class="common-input common-input--bg common-input--withIcon"
                        placeholder="Enter new password" wire:model.lazy="password">
                    <span class="input-icon">
                        <img src="{{ static_asset('images/icons/lock-icon.svg') }}" alt="">
                    </span>
                    @error('password')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="password_confirmation" class="form-label mb-2 font-18 font-heading fw-600">Confirm Password</label>
                <div class="position-relative">
                    <input type="password" id="password_confirmation" class="common-input common-input--bg common-input--withIcon"
                        placeholder="Confirm new password" wire:model.lazy="password_confirmation">
                    <span class="input-icon">
                        <img src="{{ static_asset('images/icons/lock-icon.svg') }}" alt="">
                    </span>
                    @error('password_confirmation')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-main btn-lg w-100 pill" wire:loading.attr="disabled">
                    <span wire:loading.remove>Reset Password</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
            <div class="col-sm-12 mb-0">
                <div class="have-account">
                    <p class="text font-14">Back to <a class="link text-main text-decoration-underline fw-500"
                            href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </form>
</div>
@section('title', 'Reset Password')
@include('layouts.meta')
