<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">نظام ادارة المبيعات</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

                {{-- @if (check_permission_main_menue(1) == true)    --}}
                <li
                    class="nav-item has-treeview {{ request()->is('admin/setting*') || request()->is('admin/treasuries*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/setting*') || request()->is('admin/treasuries*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الضبط العام
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- @if (check_permission_sub_menue(1) == true)   --}}
                        <li class="nav-item">
                            <a href="{{ route('settings.index') }}"
                                class="nav-link {{ request()->is('admin/setting*') ? 'active' : '' }}">
                                <p>الضبط العام</p>
                            </a>
                        </li>
                        {{-- @endif --}}
                        {{-- @if (check_permission_sub_menue(2) == true)   --}}
                        <li class="nav-item">
                            <a href="{{ route('treasury.index') }}" class="nav-link {{ request()->is('admin/treasuries*') ? 'active' : '' }}">
                                <p>بيانات الخزن</p>
                            </a>
                        </li>
                        {{-- @endif --}}
                    </ul>
                </li>
                {{-- @endif --}}

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/accountTypes*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/accountTypes*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الحسابات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('admin/accountTypes*') ? 'active' : '' }}">
                                <p>
                                    انواع الحسابات المالية
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}">
                                <p>
                                    الشجرة ( الحسابات المالية )
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->is('admin/customer*') ? 'active' : '' }}">
                                <p>
                                    حسابات العملاء
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link {{ request()->is('admin/delegates*') ? 'active' : '' }}">
                                <p>
                                    حسابات المناديب
                                </p>
                            </a>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    المراقبة والدعم الفني
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            </ul>
                        </li>
                    </ul>
                </li>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
