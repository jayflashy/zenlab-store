<div>
    {{-- breadcrumb --}}
    <section class="breadcrumb breadcrumb-one padding-y-60 section-bg position-relative z-index-1 overflow-hidden">
        <img src="{{ static_asset('images/gradients/breadcrumb-gradient-bg.png') }}" alt="" class="bg--gradient">
        <img src="{{ static_asset('images/shapes/element-moon3.png') }}" alt="" class="element one">
        <img src="{{ static_asset('images/shapes/element-moon1.png') }}" alt="" class="element three">

        <div class="container container-two">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="breadcrumb-one-content">
                        <h3 class="breadcrumb-one-content__title text-center mb-3 text-capitalize">58,000+ products available for purchase
                        </h3>
                        <p class="breadcrumb-one-content__desc text-center text-black-three">Explore the best premium themes and plugins
                            available for sale. Our unique collection is hand-curated by experts. Find and buy the perfect premium theme.
                        </p>

                        <form action="#" class="search-box">
                            <input type="text" class="common-input common-input--lg pill shadow-sm"
                                placeholder="Search theme, plugins &amp; more...">
                            <button type="submit" class="btn btn-main btn-icon icon border-0">
                                <img src="{{ static_asset('images/icons/search.svg') }}" alt="">
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Products section --}}
    <section class="all-product padding-y-120">
        <div class="container container-two">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-tab gap-3 flx-between">
                        <button type="button" class="filter-tab__button btn btn-outline-light pill d-flex align-items-center">
                            <span class="icon icon-left"><img src="{{static_asset('images/icons/filter.svg')}}" alt=""></span>
                            <span class="font-18 fw-500">Filters</span>
                        </button>

                        <div class="list-grid d-flex align-items-center gap-2">
                            <button class="list-grid__button list-button d-sm-flex d-none text-body"><i class="las la-list"></i></button>
                            <button class="list-grid__button grid-button d-sm-flex d-none active text-body">
                                <i class="las la-border-all"></i>
                            </button>
                            <button class="list-grid__button sidebar-btn text-body d-lg-none d-flex"><i class="las la-bars"></i></button>
                        </div>
                    </div>
                    <form action="#" class="filter-form pb-4 ">
                        <div class="row gy-3">
                            <div class="col-sm-4 col-xs-6">
                                <div class="flx-between gap-1">
                                    <label for="tag" class="form-label font-16">Tag</label>
                                    <button type="reset" class="text-body font-14">Clear</button>
                                </div>
                                <div class="position-relative">
                                    <input type="text" class="common-input border-gray-five common-input--withLeftIcon" id="tag"
                                        placeholder="Search By Tag...">
                                    <span class="input-icon input-icon--left"><img src="{{static_asset('images/icons/search-two.svg')}}"
                                            alt=""></span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6">
                                <div class="flx-between gap-1">
                                    <label for="Price" class="form-label font-16">Price</label>
                                    <button type="reset" class="text-body font-14">Clear</button>
                                </div>
                                <div class="position-relative">
                                    <input type="text" class="common-input border-gray-five" id="Price" placeholder="$7 - $29">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="flx-between gap-1">
                                    <label for="time" class="form-label font-16">Time Frame</label>
                                    <button type="reset" class="text-body font-14">Clear</button>
                                </div>
                                <div class="position-relative select-has-icon">
                                    <select id="time" class="common-input border-gray-five">
                                        <option value="1">Now</option>
                                        <option value="2">Yesterday</option>
                                        <option value="2">1 Month Ago</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- Filter Sidebar  --}}
                <div class="col-xl-3 col-lg-4">
                    <div class="filter-sidebar">
                        <button type="button"
                            class="filter-sidebar__close p-2 position-absolute end-0 top-0 z-index-1 text-body hover-text-main font-20 d-lg-none d-block"><i
                                class="las la-times"></i></button>
                        <div class="filter-sidebar__item">
                            <button type="button" class="filter-sidebar__button font-16 text-capitalize fw-500">Category</button>
                            <div class="filter-sidebar__content">
                                <ul class="filter-sidebar-list">
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            All Categories <span class="qty">25489</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            Site Template <span class="qty">12,501</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            WordPress <span class="qty">1258</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            UI Template <span class="qty">1520</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            Templates Kits <span class="qty">210</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            eCommerce <span class="qty">158</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            Marketing <span class="qty">178</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            CMS Template <span class="qty">122</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            Muse Themes <span class="qty">450</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            Blogging <span class="qty">155</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            Courses <span class="qty">125</span>
                                        </a>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <a href="" class="filter-sidebar-list__text">
                                            Forums <span class="qty">35</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="filter-sidebar__item">
                            <button type="button" class="filter-sidebar__button font-16 text-capitalize fw-500">Rating</button>
                            <div class="filter-sidebar__content">
                                <ul class="filter-sidebar-list">
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="veiwAll">
                                                <label class="form-check-label" for="veiwAll"> View All</label>
                                            </div>
                                            <span class="qty">(1859)</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="oneStar">
                                                <label class="form-check-label" for="oneStar"> 1 Star and above</label>
                                            </div>
                                            <span class="qty">(785)</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="twoStar">
                                                <label class="form-check-label" for="twoStar"> 2 Star and above</label>
                                            </div>
                                            <span class="qty">(1250)</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="threeStar">
                                                <label class="form-check-label" for="threeStar"> 3 Star and above</label>
                                            </div>
                                            <span class="qty">(7580)</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="fourStar">
                                                <label class="form-check-label" for="fourStar"> 4 Star and above</label>
                                            </div>
                                            <span class="qty">(1450)</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="fiveStar">
                                                <label class="form-check-label" for="fiveStar"> 5 Star Rating</label>
                                            </div>
                                            <span class="qty">(2530)</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="filter-sidebar__item">
                            <button type="button" class="filter-sidebar__button font-16 text-capitalize fw-500">Date Updated</button>
                            <div class="filter-sidebar__content">
                                <ul class="filter-sidebar-list">
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="anyDate">
                                                <label class="form-check-label" for="anyDate"> Any Date</label>
                                            </div>
                                            <span class="qty"> 5,203</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="lastYear">
                                                <label class="form-check-label" for="lastYear"> In the last year</label>
                                            </div>
                                            <span class="qty">1,258</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="lastMonth">
                                                <label class="form-check-label" for="lastMonth"> In the last month</label>
                                            </div>
                                            <span class="qty">2450</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="LastWeek">
                                                <label class="form-check-label" for="LastWeek"> In the last week</label>
                                            </div>
                                            <span class="qty">325</span>
                                        </div>
                                    </li>
                                    <li class="filter-sidebar-list__item">
                                        <div class="filter-sidebar-list__text">
                                            <div class="common-check common-radio">
                                                <input class="form-check-input" type="radio" name="radio" id="lastDay">
                                                <label class="form-check-label" for="lastDay"> In the last day</label>
                                            </div>
                                            <span class="qty">745</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                            <div class="row gy-4 list-grid-wrapper">
                                @include('partials.product.list')
                            </div>
                        <!-- Pagination Start -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination common-pagination">
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item">
                                    <a class="page-link flx-align gap-2 flex-nowrap" href="#">Next
                                        <span class="icon line-height-1 font-20"><i class="las la-arrow-right"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                </div>
            </div>
        </div>
    </section>
</div>
