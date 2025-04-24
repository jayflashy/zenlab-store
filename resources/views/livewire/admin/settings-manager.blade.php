@section('title', 'General Settings')
<div>
    @if ($view == 'index')
        <div class="card common-card">
            <div class="card-header h4">Website Information </div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="post" class="row ajaxForm">
                    @csrf
                    <div class="form-group col-md-6">
                        <label for="title" class="form-label">@lang('Website Name')</label>
                        <input type="text" name="title" id="title" class="common-input border" value="{{ $settings->title }}"
                            placeholder="Enter website name">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="email" class="form-label">@lang('Website Email')</label>
                        <input type="email" name="email" id="email" class="common-input border" value="{{ $settings->email }}"
                            placeholder="Enter website email">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="admin_email" class="form-label">@lang('Admin Email')</label>
                        <input type="email" name="admin_email" id="admin_email" class="common-input border"
                            value="{{ $settings->admin_email }}" placeholder="Enter admin email">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="phone" class="form-label">@lang('Website Phone')</label>
                        <input type="tel" name="phone" id="phone" class="common-input border" value="{{ $settings->phone }}"
                            placeholder="Enter phone number">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="description" class="form-label">@lang('Website About')</label>
                        <textarea name="description" id="description" rows="3" class="common-input border" placeholder="Enter website description">{{ $settings->description }}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="meta_description" class="form-label">@lang('Meta Description')</label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="common-input border" placeholder="Meta description">{{ $settings->meta_description }}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="meta_keywords" class="form-label">@lang('Website Keywords')</label>
                        <textarea name="meta_keywords" id="meta_keywords" rows="2" class="common-input border" placeholder="Enter website meta_keywords">{{ $settings->meta_keywords }}</textarea>
                    </div>

                    <button class="btn btn-main w-100" type="submit">Save Settings</button>
                </form>
            </div>
        </div>

        <div class="common-card card">
            <div class="card-header h4">Logo/Image Settings</div>
            <div class="card-body">
                <form class="row" action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-lg-6">
                        <label class="form-label">@lang('Site Logo')</label>
                        <div class="col-sm-12 row">
                            <input type="file" class="common-input border" name="logo" accept="image/*" />
                            <img class="primage mt-2" src="{{ my_asset($settings->logo) }}" alt="Site Logo">
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="form-label">@lang('Favicon')</label>
                        <div class="col-sm-12">
                            <input type="file" class="common-input border" name="favicon" accept="image/*" />
                            <img class="primage mt-2" src="{{ my_asset($settings->favicon) }}" alt="Favicon">
                        </div>
                    </div>
                    <div class="w-100">
                        <button class="btn btn-main w-100" type="submit">@lang('Update Settings')</button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Social Settings --}}
        <div class="common-card card">
            <div class="card-header h4">Social Links</div>
            <div class="card-body">
                <form class="row ajaxForm" action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Facebook')</label>
                        <input name="facebook" type="text" class="common-input border" value="{{ $settings->facebook }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Twitter')</label>
                        <input name="twitter" type="text" class="common-input border" value="{{ $settings->twitter }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Instagram')</label>
                        <input name="instagram" type="text" class="common-input border" value="{{ $settings->instagram }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('Telegram')</label>
                        <input name="telegram" type="text" class="common-input border" value="{{ $settings->telegram }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('LinkedIn')</label>
                        <input name="linkedin" type="text" class="common-input border" value="{{ $settings->linkedin }}">
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">@lang('WhatsApp')</label>
                        <input name="whatsapp" type="text" class="common-input border" value="{{ $settings->whatsapp }}">
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-main w-100" type="submit">Update Settings</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="common-card card">
            <div class="card-header h4">Currency Settings</div>
            <div class="card-body">
                <form class="row ajaxForm" action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group col-sm-4 ">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" class="common-input border" name="currency" value="{{ $settings->currency }}" required
                            placeholder="Currency Symbol" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="form-label">Currency Code</label>
                        <input type="text" class="common-input border" name="currency_code" value="{{ $settings->currency_code }}"
                            required placeholder="Currency Code" />
                    </div>
                    <div class="form-group col-sm-4">
                        <label class="form-label">Currency Rate</label>
                        <input type="text" class="common-input border" name="currency_rate" value="{{ $settings->currency_rate }}"
                            required placeholder="Currency rate" />
                    </div>
                    <div class="w-100">
                        <button class="btn btn-main w-100" type="submit">@lang('Update Setting')</button>
                    </div>
                </form>
            </div>
        </div>
    @elseif ($view == 'payments')
        <div class="row g-4">
            @foreach ($gateways as $gateway)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card common-card shadow-sm">
                        <div class="card-header">
                            <h5 class="mb-0 fw-bold">{{ $gateway['name'] }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="form-label mb-0">Status</label>
                                <label class="jdv-switch jdv-switch-success mb-0">
                                    <input type="checkbox" wire:model.lazy="sysSettings.{{ $gateway['key'] }}">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="card common-card">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold ">Paystack Credentials</h5>
                    </div>
                    <div class="card-body">
                        <form class="ajaxForm" action="{{ route('admin.settings.env_key') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" value="paystack">
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="PAYSTACK_PUBLIC_KEY">
                                <label class="form-label">{{ __('PUBLIC KEY') }}</label>
                                <input type="text" class="common-input border" name="PAYSTACK_PUBLIC_KEY"
                                    value="{{ env('PAYSTACK_PUBLIC_KEY') }}" placeholder="PUBLIC KEY" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="PAYSTACK_SECRET_KEY">
                                <label class="form-label">{{ __('SECRET KEY') }}</label>
                                <input type="text" class="common-input border" name="PAYSTACK_SECRET_KEY"
                                    value="{{ env('PAYSTACK_SECRET_KEY') }}" placeholder="SECRET KEY" required>
                            </div>
                            <div class="form-group mb-0 text-end">
                                <button type="submit" class="btn btn-sm w-100 btn-main">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card common-card">
                    <div class="card-header">
                        <h5 class="mb-0 fw-bold ">Flutter Credentials</h5>
                    </div>
                    <div class="card-body">
                        <form class="ajaxForm" action="{{ route('admin.settings.env_key') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" value="flutter">
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="FLW_PUBLIC_KEY">
                                <label class="form-label">{{ __('FLW PUBLIC KEY') }}</label>
                                <input type="text" class="common-input border" name="FLW_PUBLIC_KEY"
                                    value="{{ env('FLW_PUBLIC_KEY') }}" placeholder="FLUTTERWAVE PUBLIC KEY" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="FLW_SECRET_KEY">
                                <label class="form-label">{{ __('FLW SECRET KEY') }}</label>
                                <input type="text" class="common-input border" name="FLW_SECRET_KEY" <input type="text"
                                    class="common-input border" name="FLW_SECRET_KEY" value="{{ env('FLW_SECRET_KEY') }}"
                                    placeholder="FLUTTERWAVE SECRET KEY" required>
                            </div>
                            <div class="form-group mb-0 text-end">
                                <button type="submit" class="btn btn-sm w-100 btn-main">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 ">
                <div class="card common-card ">
                    <div class="card-header">
                        <h5 class="fw-bold mb-0">{{ __('Paypal Credential') }}</h5>
                    </div>
                    <form action="{{ route('admin.settings.env_key') }}" method="POST" class=" ajaxForm">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="payment_method" value="paypal">
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="PAYPAL_CLIENT_ID">
                                <label class="form-label">{{ __('Paypal Client Id') }}</label>
                                <input type="text" class="common-input border" name="PAYPAL_CLIENT_ID"
                                    value="{{ env('PAYPAL_CLIENT_ID') }}" placeholder="Paypal Client ID" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="PAYPAL_CLIENT_SECRET">
                                <label class="form-label">{{ __('Paypal Client Secret') }}</label>
                                <input type="text" class="common-input border" name="PAYPAL_CLIENT_SECRET"
                                    value="{{ env('PAYPAL_CLIENT_SECRET') }}" placeholder="Paypal Client Secret" required>
                            </div>
                            <div class="mt-2">
                                <button class="btn btn-main w-100" type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 ">
                <div class="card common-card mb-2">
                    <div class="card-header">
                        <h5 class="fw-bold mb-0">{{ __('Cryptomus Credentials') }}</h5>
                    </div>
                    <form action="{{ route('admin.settings.env_key') }}" method="POST" class=" ajaxForm">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="CRYPTOMUS_KEY">
                                <label class="form-label">{{ __('CRYPTOMUS KEY') }}</label>
                                <input type="text" class="common-input border" name="CRYPTOMUS_KEY"
                                    value="{{ env('CRYPTOMUS_KEY') }}" placeholder="CRYPTOMUS KEY" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="CRYPTOMUS_MERCHANT">
                                <label class="form-label">{{ __('CRYPTOMUS MERCHANT KEY') }}</label>
                                <input type="text" class="common-input border" name="CRYPTOMUS_MERCHANT"
                                    value="{{ env('CRYPTOMUS_MERCHANT') }}" placeholder="CRYPTOMUS MERCHANT KEY" required>
                            </div>
                            <button class="btn btn-main mt-2 w-100" type="submit">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="card common-card">
                    <div class="card-header">
                        <h5 class="fw-bold mb-0">Bank Payment Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.store_settings') }}" method="post" class="ajaxForm">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="bank_name">
                                <label class="form-label">Bank Name</label>
                                <input type="text"class="common-input border" name="bank_name" placeholder="Bank Name"
                                    value="{{ sys_setting('bank_name') }}" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="account_name">
                                <label class="form-label">Account Name</label>
                                <input type="text"class="common-input border" name="account_name" placeholder="Account Name"
                                    value="{{ sys_setting('account_name') }}" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="types[]" value="account_number">
                                <label class="form-label">Account Number</label>
                                <input type="text"class="common-input border" name="account_number" placeholder="Account Number"
                                    value="{{ sys_setting('account_number') }}" required>
                            </div>
                            <div class="form-group text-end mb-0">
                                <button class="btn w-100 btn-main" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@include('layouts.meta')

@push('styles')
    <style>
        .primage {
            min-height: 80px;
            max-height: 120px !important;
            max-width: 150px !important;
            margin: 0;
        }
    </style>
@endpush
