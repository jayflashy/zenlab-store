@section('title', 'Account Settings')
<div>
    <div class="cover-photo position-relative z-index-1 overflow-hidden">
        <div class="avatar-upload">
            <div class="avatar-preview">
                <div id="imagePreviewTwo">
                </div>
            </div>
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
                                    <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg">
                                    <label for="imageUpload">
                                        <img src="{{ static_asset('images/icons/camera.svg') }}" alt="">
                                    </label>
                                </div>
                                <div class="avatar-preview"
                                    style="background-image: url({{ my_asset($user->image ?? 'users/default.jpg') }});">
                                    <div id="imagePreview">
                                    </div>
                                </div>
                            </div>

                            <h5 class="profile-info__name mb-1">Michel Smith</h5>
                            <span class="profile-info__designation font-14">Buyer</span>
                        </div>

                        <ul class="profile-info-list">
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="assets/images/icons/profile-info-icon1.svg" alt="" class="icon">
                                    <span class="text text-heading fw-500">Username</span>
                                </span>
                                <span class="profile-info-list__info">michel15</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="assets/images/icons/profile-info-icon2.svg" alt="" class="icon">
                                    <span class="text text-heading fw-500">Email</span>
                                </span>
                                <span class="profile-info-list__info">michel15@gmail.com</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="assets/images/icons/profile-info-icon3.svg" alt="" class="icon">
                                    <span class="text text-heading fw-500">Phone</span>
                                </span>
                                <span class="profile-info-list__info">+880 15589 236 45</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="assets/images/icons/profile-info-icon4.svg" alt="" class="icon">
                                    <span class="text text-heading fw-500">Country</span>
                                </span>
                                <span class="profile-info-list__info">Bangladesh</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="assets/images/icons/profile-info-icon6.svg" alt="" class="icon">
                                    <span class="text text-heading fw-500">Member Since</span>
                                </span>
                                <span class="profile-info-list__info">Jan, 01, 2024</span>
                            </li>
                            <li class="profile-info-list__item">
                                <span class="profile-info-list__content flx-align flex-nowrap gap-2">
                                    <img src="assets/images/icons/profile-info-icon7.svg" alt="" class="icon">
                                    <span class="text text-heading fw-500">Purchased</span>
                                </span>
                                <span class="profile-info-list__info">0 items</span>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="col-xxl-9 col-xl-8">
                    <div class="dashboard-card">
                        <div class="dashboard-card__header pb-0">
                            <ul class="nav tab-bordered nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link font-18 font-heading active" id="pills-personalInfo-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-personalInfo" type="button" role="tab"
                                        aria-controls="pills-personalInfo" aria-selected="true">Personal Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link font-18 font-heading" id="pills-notifications-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-notifications" type="button" role="tab"
                                        aria-controls="pills-notifications" aria-selected="false" tabindex="-1">Notifications</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link font-18 font-heading" id="pills-changePassword-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-changePassword" type="button" role="tab"
                                        aria-controls="pills-changePassword" aria-selected="false" tabindex="-1">Change
                                        Password</button>
                                </li>
                            </ul>
                        </div>

                        <div class="profile-info-content">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-personalInfo" role="tabpanel"
                                    aria-labelledby="pills-personalInfo-tab" tabindex="0">
                                    <form action="#" autocomplete="off">
                                        <div class="row gy-4">
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="fName" class="form-label mb-2 font-18 font-heading fw-600">
                                                    Full Name
                                                </label>
                                                <input type="text" class="common-input border" id="fName" value="" required
                                                    placeholder="Full Name">
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="lastNamee" class="form-label mb-2 font-18 font-heading fw-600">
                                                    Username
                                                </label>
                                                <input type="text" class="common-input border" id="lastNamee" value=""
                                                    placeholder="Username">
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="emailAdddd" class="form-label mb-2 font-18 font-heading fw-600">Email
                                                    Address</label>
                                                <input type="email" class="common-input border" id="emailAdddd"
                                                    value="" placeholder="Email Address">
                                            </div>
                                            <div class="col-sm-6 col-xs-6">
                                                <label for="phonee" class="form-label mb-2 font-18 font-heading fw-600">Phone
                                                    Number</label>
                                                <input type="tel" class="common-input border" id="phonee" value=""
                                                    placeholder="Phone Number">
                                            </div>

                                            <div class="col-sm-6 col-xs-6">
                                                <label for="Countryyy" class="form-label mb-2 font-18 font-heading fw-600">Country</label>
                                                <div class="select-has-icon">
                                                    <select class="common-input border" id="Countryyy">
                                                        <option value="1">USA</option>
                                                        <option value="1">Bangladesh</option>
                                                        <option value="1">India</option>
                                                        <option value="1">Pakistan</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 text-end">
                                                <button class="btn btn-main btn-lg pill mt-4"> Update Profile</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-notifications" role="tabpanel"
                                    aria-labelledby="pills-notifications-tab" tabindex="0">
                                    <div class="row gy-3">
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="common-check">
                                                <input class="form-check-input" type="checkbox" id="updateNotification">
                                                <label class="form-check-label" for="updateNotification"> Item update notification</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <div class="common-check">
                                                <input class="form-check-input" type="checkbox" id="trxNootification">
                                                <label class="form-check-label" for="trxNootification"> Transaction notification</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-changePassword" role="tabpanel"
                                    aria-labelledby="pills-changePassword-tab" tabindex="0">
                                    <form action="#" autocomplete="off">
                                        <div class="row gy-4">

                                            <div class="col-12">
                                                <label for="current-password" class="form-label mb-2 font-18 font-heading fw-600">Current
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        class="common-input common-input--withIcon common-input--withLeftIcon "
                                                        id="current-password" placeholder="************">
                                                    <span class="input-icon input-icon--left"><img src="assets/images/icons/key-icon.svg"
                                                            alt=""></span>
                                                    <span class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two"
                                                        id="#current-password"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-xs-6">
                                                <label for="new-password" class="form-label mb-2 font-18 font-heading fw-600">New
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        class="common-input common-input--withIcon common-input--withLeftIcon "
                                                        id="new-password" placeholder="************">
                                                    <span class="input-icon input-icon--left"><img src="assets/images/icons/lock-two.svg"
                                                            alt=""></span>
                                                    <span class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two"
                                                        id="#new-password"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 col-xs-6">
                                                <label for="confirm-password" class="form-label mb-2 font-18 font-heading fw-600">Current
                                                    Password</label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        class="common-input common-input--withIcon common-input--withLeftIcon "
                                                        id="confirm-password" placeholder="************">
                                                    <span class="input-icon input-icon--left"><img src="assets/images/icons/lock-two.svg"
                                                            alt=""></span>
                                                    <span class="input-icon password-show-hide fas fa-eye la-eye-slash toggle-password-two"
                                                        id="#confirm-password"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 text-end">
                                                <button class="btn btn-main btn-lg pill mt-4"> Update Password</button>
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
</div>

@include('layouts.meta')
