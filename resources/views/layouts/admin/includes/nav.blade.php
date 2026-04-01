<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
    <div class="topbar">
        <div class="topbar-menu d-flex align-items-center gap-1">
            <!-- Topbar Brand Logo -->
            <div class="logo-box">
                <!-- Brand Logo Light -->
                <a  href="{{route('admin.dashboard')}}" class="logo-light">
                    <img src="{{asset('assets/images/logo-light.png')}}" alt="logo" class="logo-lg">
                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="small logo" class="logo-sm">
                </a>
                <!-- Brand Logo Dark -->
                <a  href="{{route('admin.dashboard')}}" class="logo-dark">
                    <img src="{{asset('assets/images/logo-dark.png')}}" alt="dark logo" class="logo-lg">
                    <img src="{{asset('assets/images/logo-sm.png')}}" alt="small logo" class="logo-sm">
                </a>
            </div>
            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>
        <ul class="topbar-menu d-flex align-items-center">
            <!-- Topbar Search Form -->
            <li class="app-search dropdown me-3 d-none d-lg-block">
                <form class="navbar-form navbar-left" action="./pages-search-results.html" method="get">
                    <div class="search-group d-flex ">
                        <div class="relative d-flex align-items-center search-input-container">
                            <input type="text" id="searchbox" name="keyword" class="form-control search-input input-lg" placeholder="ابحث بإسم المنتج ، اسم التصنيف ، وصف المنتج  "  />
                            <i id="tippy-trigger" type="button" class="multi-order-search-tooltip sicon-info"></i>
                        </div>
                        <select class="search-select hidden" id="search_input_type" name="search_type" data-width="100px" data-dropup-auto="false">
                            <option value="orders">الطلبات
                            </option>
                            <option value="products" selected>المنتجات
                            </option>
                            <option value="customers">العملاء
                            </option>
                            <option value="place-owners"> المحلات
                            </option>
                        </select>
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-tiffany btn-lg"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>
            <!-- Fullscreen Button -->
            <li class="d-none d-md-inline-block">
                <a class="nav-link waves-effect waves-light" href="" data-toggle="fullscreen">
                    <i class="fe-maximize font-22"></i>
                </a>
            </li>
            <!-- Search Dropdown (for Mobile/Tablet) -->
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line font-22"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3">
                        <input type="search" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                    </form>
                </div>
            </li>
            <!-- Notofication dropdown -->
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" href="{{ route('admin.message.list') }}" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="dripicons-message font-22 cart-icon"></i>
                </a>
            </li>
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle waves-effect waves-light arrow-none" href="{{route('admin.order.index')}}" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="dripicons-cart font-22 cart-icon"></i>
                </a>
            </li>
            <!-- Light/Dark Mode Toggle Button -->
            <li class="d-none d-sm-inline-block">
                <div class="nav-link waves-effect waves-light" id="light-dark-mode">
                    <i class="ri-moon-line font-22"></i>
                </div>
            </li>
            <!-- customer Dropdown -->
            <li class="dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{isset(auth("admin")->user()->image)?asset(auth("admin")->user()->image):''}}" alt="user-image" class="rounded-circle" onerror="this.src='{{asset('assets/images/avatar.svg')}}'">
                    <span class="ms-1 d-none d-md-inline-block"> {{isset(auth("admin")->user()->f_name)?auth("admin")->user()->f_name:''}}  {{isset(auth("admin")->user()->l_name)?auth("admin")->user()->l_name:''}}<i class="mdi mdi-chevron-down"></i>
                  </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <a href="{{route('admin.employee.edit',['id'=>\Illuminate\Support\Facades\Auth::guard('admin')->user()->id])}}" class="dropdown-item notify-item">
                        <i class="fe-settings"></i>
                        <span>الإعدادات</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <!-- item-->
                    <a href="{{route('admin.auth.logout')}}" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>تسجيل الخروج</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->
