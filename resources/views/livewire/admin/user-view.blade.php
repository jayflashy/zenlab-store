@section('title', $metaTitle)
<div class=" py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-3"></h1>
            <p class="text-muted small"></p>
        </div>
    </div>

    <div class="dashboard-body__content profile-content-wrapper z-index-1 position-relative mt--100">
        <!-- Profile Content Start -->
        <div class="profile">
            <div class="row gy-4">
                <div class="col-xxl-3 col-xl-4">
                    <div class="profile-info">
                        <div class="profile-info__inner mb-40 text-center">
                            <div class="avatar-upload mb-24">
                                <div class="avatar-edit">
                                    <input type="file" id="imageUpload" wire:model="image"
                                        accept=".png, .jpg, .jpeg">
                                    <label for="imageUpload">
                                        <img src="{{ static_asset('images/icons/camera.svg') }}" alt="Upload Image">
                                    </label>
                                </div>
                                <div class="avatar-preview prof-img"
                                    style="background-image: url({{ $imageUrl }});">
                                    <div id="imagePreview">
                                    </div>
                                </div>
                            </div>

                            <h5 class="profile-info__name mb-1">{{ $name }}</h5>
                            <span class="profile-info__designation font-14">Buyer</span>
                        </div>

                        <ul class="profile-info-list">
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ static_asset('images/icons/profile-info-icon1.svg') }}" alt=""
                                        class="icon">
                                    <span class="text text-heading fw-500">Username</span>
                                </span>
                                <span class="profile-info-list__info">{{ $username }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ static_asset('images/icons/profile-info-icon2.svg') }}" alt=""
                                        class="icon">
                                    <span class="text text-heading fw-500">Email</span>
                                </span>
                                <span class="profile-info-list__info">{{ $email }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ static_asset('images/icons/profile-info-icon3.svg') }}" alt=""
                                        class="icon">
                                    <span class="text text-heading fw-500">Phone</span>
                                </span>
                                <span class="profile-info-list__info">{{ $phone }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ static_asset('images/icons/profile-info-icon4.svg') }}" alt=""
                                        class="icon">
                                    <span class="text text-heading fw-500">Country</span>
                                </span>
                                <span class="profile-info-list__info">{{ $country }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ static_asset('images/icons/profile-info-icon6.svg') }}" alt=""
                                        class="icon">
                                    <span class="text text-heading fw-500">Member Since</span>
                                </span>
                                <span
                                    class="profile-info-list__info">{{ show_date($user->created_at, 'M d, Y') }}</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="{{ static_asset('images/icons/profile-info-icon7.svg') }}" alt=""
                                        class="icon">
                                    <span class="text text-heading fw-500">Purchased</span>
                                </span>
                                <span class="profile-info-list__info">{{ $purchases_count ?? 0 }} items</span>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8">
                    <div class="dashboard-card">
                        <div class="dashboard-card__header pb-0">
                            <ul class="nav tab-bordered nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link font-18 font-heading {{ $tab == 'statistics' ? 'active' : '' }}"
                                        wire:click="setTab('statistics')" id="pills-statistics-tab" type="button"
                                        role="tab" aria-controls="pills-statistics" aria-selected="true">Statistics
                                        Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link font-18 font-heading {{ $tab == 'personalInfo' ? 'active' : '' }}"
                                        wire:click="setTab('personalInfo')" id="pills-personalInfo-tab" type="button"
                                        role="tab" aria-controls="pills-personalInfo" aria-selected="true">Personal
                                        Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link font-18 font-heading {{ $tab == 'notifications' ? 'active' : '' }}"
                                        wire:click="setTab('notifications')" id="pills-notifications-tab" type="button"
                                        role="tab" aria-controls="pills-notifications" aria-selected="false"
                                        tabindex="-1">Notifications</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button
                                        class="nav-link font-18 font-heading {{ $tab == 'changePassword' ? 'active' : '' }}"
                                        wire:click="setTab('changePassword')" id="pills-changePassword-tab"
                                        type="button" role="tab" aria-controls="pills-changePassword"
                                        aria-selected="false" tabindex="-1">Change
                                        Password</button>
                                </li>
                            </ul>
                        </div>

                        <div class="profile-info-content">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade {{ $tab == 'statistics' ? 'show active' : '' }}"
                                    id="pills-statistics" role="tabpanel" aria-labelledby="pills-statistics-tab"
                                    tabindex="0">
                                    <div class="row gy-3 widgets_bg pb-3">
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $purchases_count ?? 0 }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Total Orders
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->orders()->count() }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Total Orders
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ format_price($user->orders()->where('payment_status', 'completed')->sum('total')) }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Total Spent
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->orders()->whereIn('order_status', ['pending', 'processing'])->count() }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Active Orders
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->orders()->where('order_status', 'completed')->count() }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Completed Orders
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->orders()->with('items')->get()->flatMap->items->unique('product_id')->count() }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Unique Products
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->reviews()->count() }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Reviews Submitted
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->wishlists()->count() }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Wishlist Items
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->comments()->count() + $user->comments()->withCount('replies')->get()->sum('replies_count') }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Total Comments
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h4 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->orders()->with('items')->get()->flatMap->items->where('extended_support', true)->count() }}
                                                        </h4>
                                                        <span class="dashboard-widget__text font-14">
                                                            Support Subscriptions
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h5 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ $user->orders()->latest()->first()?->created_at->format('M d, Y') ?? 'N/A' }}
                                                        </h5>
                                                        <span class="dashboard-widget__text font-14">
                                                            Last Order
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h5 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ number_format($user->reviews()->avg('stars') ?? 0, 1) }}
                                                            ★
                                                        </h5>
                                                        <span class="dashboard-widget__text font-14">
                                                            Avg. Rating Given
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="dashboard-widget">
                                                <div
                                                    class="dashboard-widget__content flx-between gap-1 align-items-end">
                                                    <div>
                                                        <h5 class="dashboard-widget__number mb-1 mt-3">
                                                            {{ number_format($user->created_at->diffInDays(now())) }}
                                                        </h5>
                                                        <span class="dashboard-widget__text font-14">
                                                            Account Age (Days)
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade {{ $tab == 'personalInfo' ? 'show active' : '' }}"
                                    id="pills-personalInfo" role="tabpanel" aria-labelledby="pills-personalInfo-tab"
                                    tabindex="0">
                                    <form wire:submit.prevent="updateProfile">
                                        <div class="row gy-4">
                                            <div class="col-sm-6">
                                                <label for="name"
                                                    class="form-label mb-2 font-18 font-heading fw-600">
                                                    Full Name
                                                </label>
                                                <input type="text" class="common-input border" id="name"
                                                    wire:model="name" required placeholder="Full Name">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="username"
                                                    class="form-label mb-2 font-18 font-heading fw-600">
                                                    Username
                                                </label>
                                                <input type="text" class="common-input border" id="username"
                                                    wire:model="username" placeholder="Username">
                                                @error('username')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="email"
                                                    class="form-label mb-2 font-18 font-heading fw-600">Email
                                                    Address</label>
                                                <input type="email" class="common-input border" id="email"
                                                    wire:model="email" placeholder="Email Address">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="phone"
                                                    class="form-label mb-2 font-18 font-heading fw-600">Phone
                                                    Number</label>
                                                <input type="tel" class="common-input border" id="phone"
                                                    wire:model="phone" placeholder="Phone Number">
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="country"
                                                    class="form-label mb-2 font-18 font-heading fw-600">Country</label>
                                                <div class="select-has-icon">
                                                    <select class="common-input border" id="country"
                                                        wire:model="country">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $key => $country)
                                                            <option value="{{ $country['name'] }}">
                                                                {{ $country['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('country')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-12 text-end">
                                                <button type="submit" class="btn btn-main btn-lg pill mt-4">Update
                                                    Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade {{ $tab == 'notifications' ? 'show active' : '' }}"
                                    id="pills-notifications" role="tabpanel"
                                    aria-labelledby="pills-notifications-tab" tabindex="0">
                                    <form wire:submit.prevent="updateNotifications">
                                        <div class="row gy-3">
                                            <div class="col-sm-6">
                                                <div class="common-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="updateNotification" wire:model="update_notify">
                                                    <label class="form-check-label" for="updateNotification">Item
                                                        update
                                                        notification</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="common-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="trxNootification" wire:model="trx_notify">
                                                    <label class="form-check-label" for="trxNootification">Transaction
                                                        notification</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 text-end">
                                                <button type="submit" class="btn btn-main btn-lg pill mt-4">Save
                                                    Notification
                                                    Settings</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade {{ $tab == 'changePassword' ? 'show active' : '' }}"
                                    id="pills-changePassword" role="tabpanel"
                                    aria-labelledby="pills-changePassword-tab" tabindex="0">
                                    <form wire:submit.prevent="updatePassword">
                                        <div class="row gy-4">
                                            <div class="col-12">
                                                <label for="current-password"
                                                    class="form-label mb-2 font-18 font-heading fw-600">Current
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        class="common-input common-input--withIcon common-input--withLeftIcon"
                                                        id="current-password" wire:model="current_password"
                                                        placeholder="************">
                                                    <span class="input-icon input-icon--left">
                                                        <img src="{{ static_asset('images/icons/key-icon.svg') }}"
                                                            alt="">
                                                    </span>
                                                    <span
                                                        class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two"
                                                        id="#current-password"></span>
                                                </div>
                                                @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="new-password"
                                                    class="form-label mb-2 font-18 font-heading fw-600">New
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        class="common-input common-input--withIcon common-input--withLeftIcon"
                                                        id="new-password" wire:model="new_password"
                                                        placeholder="************">
                                                    <span class="input-icon input-icon--left">
                                                        <img src="{{ static_asset('images/icons/lock-two.svg') }}"
                                                            alt="">
                                                    </span>
                                                    <span
                                                        class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two"
                                                        id="#new-password"></span>
                                                </div>
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-6">
                                                <label for="confirm-password"
                                                    class="form-label mb-2 font-18 font-heading fw-600">Confirm
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        class="common-input common-input--withIcon common-input--withLeftIcon"
                                                        id="confirm-password" wire:model="confirm_password"
                                                        placeholder="************">
                                                    <span class="input-icon input-icon--left">
                                                        <img src="{{ static_asset('images/icons/lock-two.svg') }}"
                                                            alt="">
                                                    </span>
                                                    <span
                                                        class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two"
                                                        id="#confirm-password"></span>
                                                </div>
                                                @error('confirm_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-sm-12 text-end">
                                                <button type="submit" class="btn btn-main btn-lg pill mt-4">Update
                                                    Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Profile Content End -->
    </div>
    <style>
        [data-theme=light] .widgets_bg {
            background-color: #0f131c;
        }

        [data-theme=dark] .widgets_bg {
            background-color: #d7d0d0;
        }
    </style>
</div>


@include('layouts.meta')
