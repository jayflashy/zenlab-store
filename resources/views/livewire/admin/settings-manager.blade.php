@section('title', 'General Settings')
<div>
    <div class="card common-card">
        <div class="card-header h4">Website Information </div>
        <div class="card-body">
            <form action="{{route('admin.settings.update')}}" method="post" class="row ajaxForm">
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
                    <label for="meta_description" class="form-label">@lang('Website About')</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="common-input border" placeholder="Meta description">{{ $settings->meta_description }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label for="meta_keywords" class="form-label">@lang('Website Keywords')</label>
                    <textarea name="meta_keywords" id="meta_keywords" rows="3" class="common-input border" placeholder="Enter website meta_keywords">{{ $settings->meta_keywords }}</textarea>
                </div>

                <button class="btn btn-primary w-100" type="submit">Save Settings</button>
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
                    <button class="btn btn-primary w-100" type="submit">@lang('Update Setting')</button>
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
                    <button class="btn btn-primary w-100" type="submit">Update Settings</button>
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
                    <input type="text" class="common-input border" name="currency_code" value="{{ $settings->currency_code }}" required
                        placeholder="Currency Code" />
                </div>
                <div class="form-group col-sm-4">
                    <label class="form-label">Currency Rate</label>
                    <input type="text" class="common-input border" name="currency_rate" value="{{ $settings->currency_rate }}" required
                        placeholder="Currency rate" />
                </div>
                <div class="w-100">
                    <button class="btn btn-primary w-100" type="submit">@lang('Update Setting')</button>
                </div>
            </form>
        </div>
    </div>
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
