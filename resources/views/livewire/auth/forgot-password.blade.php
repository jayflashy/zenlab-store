@section('title', 'Forgot Password')
@include('layouts.meta')

<div>
    <h4 class="account-content__title mb-48 text-capitalize">Forgot Password</h4>
    <p class="mb-4 font-14 text-muted">Enter your email to receive a password reset link</p>

    @if (session('status'))
        <div class="alert alert-success font-14 text-center">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit.prevent="sendPasswordResetLink">
        <div class="row gy-4">
            <div class="col-12">
                <label for="email" class="form-label mb-2 font-18 font-heading fw-600">Email Address</label>
                <div class="position-relative">
                    <input type="email" id="email" class="common-input common-input--bg common-input--withIcon"
                        placeholder="email@example.com" wire:model="email" autofocus>
                    <span class="input-icon">
                        <img src="{{ static_asset('images/icons/envelope-icon.svg') }}" alt="">
                    </span>
                    @error('email')
                        <span class="text-danger mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-main btn-lg w-100 pill" wire:loading.attr="disabled">
                    <span wire:loading.remove>Email Password Reset Link</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>

            <div class="col-sm-12 mb-0">
                <div class="have-account text-center">
                    <p class="text font-14">Or, return to
                        <a class="link text-main text-decoration-underline fw-500" href="{{ route('login') }}">Log in</a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
