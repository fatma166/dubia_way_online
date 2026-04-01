<!-- ========== Menu ========== -->
<div class="app-menu" style="background: #ad9173 !important">
    <!-- Brand Logo -->
    <div class="logo-box">
        <!-- Brand Logo Light -->
        <a href="{{route('vendor.dashboard')}}" class="logo-light">
            <img src="{{asset('website/assets/images/DubaiWay.png')}}" alt="logo" class="logo-lg">
            <img src="{{asset('website/assets/images/DubaiWay.png')}}" alt="small logo" class="logo-sm">
        </a>
        <!-- Brand Logo Dark -->
        <a href="{{route('vendor.dashboard')}}" class="logo-dark">
            <img src="{{asset('website/assets/images/DubaiWay.png')}}" alt="dark logo" class="logo-lg">
            <img src="{{asset('website/assets/images/DubaiWay.png')}}" alt="small logo" class="logo-sm">
        </a>
    </div>
    <!-- menu-left -->
    <div class="scrollbar">
        <!-- customer box -->
        <div class="user-box text-center">
            <img src="{{asset('assets/images/users/user-1.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="dropdown-toggle h5 mb-1 d-block" data-bs-toggle="dropdown"></a>
                <div class="dropdown-menu user-pro-dropdown">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>الإعدادات</span>
                    </a>
                    <!-- item-->
                    <a href="{{route('vendor.auth.logout')}}" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>تسجيل الخروج</span>
                    </a>
                </div>
            </div>
        </div>
        <!--- Menu -->
        <ul class="menu">
            <li class="menu-item">
                  <a href="{{route('vendor.dashboard')}}" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="airplay"></i>
                </span>
                    <span class="menu-text"> الرئيسية</span>
                </a>
            </li>
            <li class="menu-title"> العروض الترويجية</li>


          <!--  <li class="menu-title"> إدارة أصحاب المحلات</li>-->
            <li class="menu-item">
                <a href="{{route('vendor.category.index')}}" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="briefcase"></i>
                </span>
                    <span class="menu-text"> التصنيفات</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('vendor.category.create')}}"class="menu-link">
                <span class="menu-icon">
                  <i data-feather="folder-plus"></i>
                </span>
                    <span class="menu-text"> إضافة تصنيف</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('vendor.product.index')}}" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="grid"></i>
                </span>
                    <span class="menu-text"> المنتجات</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('vendor.product.create')}}" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="target"></i>
                </span>
                    <span class="menu-text"> إضافة منتج</span>
                </a>
            </li>
            <li class="menu-title">إدارة العملاء</li>
            <li class="menu-item">
                <a href="{{route('vendor.order.index')}}" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="shopping-bag"></i>
                </span>
                    <span class="menu-text"> الطلبات</span>
                    <span class="badge bg-success rounded-pill ms-auto">4</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('vendor.customer.index')}}" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="users"></i>
                </span>
                    <span class="menu-text"> العملاء</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{route('vendor.order.index',['status'=>'refunded'])}}"  class="menu-link">
                <span class="menu-icon">
                  <i data-feather="gift"></i>
                </span>
                    <span class="menu-text"> الطلبات المستردة</span>
                    <span class="badge bg-success rounded-pill ms-auto">4</span>
                </a>
            </li>

            <li class="menu-title"> المساعدة</li>
            <li class="menu-item">
                <a href="{{ route('vendor.message.list') }}"  class="menu-link">
                <span class="menu-icon">
                  <i data-feather="message-square"></i>
                </span>
                    <span class="menu-text"> التواصل</span>
                    <span class="badge bg-success rounded-pill ms-auto">4</span>
                </a>
            </li>
            <!--<li class="menu-title">إدارة عمليات البيع</li>
            <li class="menu-item">
                <a href="withdraw-transaction.html" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="dollar-sign"></i>
                </span>
                    <span class="menu-text"> طلبات سحب الأموال</span>
                    <span class="badge bg-success rounded-pill ms-auto">4</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="#" class="menu-link">
                <span class="menu-icon">
                  <i data-feather="credit-card"></i>
                </span>
                    <span class="menu-text"> وسائل الدفع</span>
                </a>
            </li>-->
            
        </ul>
        <!--- End Menu -->
        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left menu End ========== -->
