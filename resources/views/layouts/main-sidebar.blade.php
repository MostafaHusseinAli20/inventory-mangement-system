<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">نظام ادارة المخازن</span>
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
                            <a href="{{ route('treasury.index') }}"
                                class="nav-link {{ request()->is('admin/treasuries*') ? 'active' : '' }}">
                                <p>بيانات الخزن</p>
                            </a>
                        </li>
                        {{-- @endif --}}
                    </ul>
                </li>
                {{-- @endif --}}

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/account-types*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/account-types*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الحسابات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('account-types.index') }}"
                                class="nav-link {{ request()->is('admin/account-types*') ? 'active' : '' }}">
                                <p>
                                    انواع الحسابات المالية
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('accounts.index') }}" 
                                class="nav-link {{ request()->is('admin/accounts*') ? 'active' : '' }}">
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
                    </ul>
                </li>

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/sales-matrial-types*') || request()->is('admin/stores*') || request()->is('admin/uoms*') || request()->is('admin/item-card-categories*') || request()->is('admin/item-cards*') and !request()->is('admin/itemcardBalance*') and !request()->is('admin/stores_inventory*')) ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/sales-matrial-types*') || request()->is('admin/stores*') || request()->is('admin/uoms*') || request()->is('admin/item-card-categories*') || request()->is('admin/item-cards*') and !request()->is('admin/itemcardBalance*') and !request()->is('admin/stores_inventory*')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            ضبط المخازن
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales-matrial-types.index') }}"
                                class="nav-link {{ request()->is('admin/sales-matrial-types*') ? 'active' : '' }}">

                                <p>
                                    بيانات فئات الفواتير
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('stores.index') }}"
                                class="nav-link {{ request()->is('admin/stores*') ? 'active' : '' }}">

                                <p>
                                    بيانات المخازن
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('uoms.index') }}"
                                class="nav-link {{ request()->is('admin/uoms*') ? 'active' : '' }}">

                                <p>
                                    بيانات الوحدات
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('item-card-categories.index') }}"
                                class="nav-link {{ request()->is('admin/item-card-categories*') ? 'active' : '' }}">
                                <p>
                                    فئات الاصناف
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('item-cards.index') }}"
                                class="nav-link {{ request()->is('admin/item-cards*') ? 'active' : '' }}">
                                <p>
                                    الاصناف
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- <li
                    class="nav-item has-treeview {{ (request()->is('admin/accountTypes*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/accountTypes*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            حركات مخزنية
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

                 <li
                    class="nav-item has-treeview {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            المبيعات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('admin/0*') ? 'active' : '' }}">
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

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            خدمات داخلية وخارجية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('admin/0*') ? 'active' : '' }}">
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

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            حركة شفت الخزينة
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('admin/0*') ? 'active' : '' }}">
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

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            الصلاحيات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('admin/0*') ? 'active' : '' }}">
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

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            التقارير
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('admin/0*') ? 'active' : '' }}">
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

                <li
                    class="nav-item has-treeview {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'menu-open' : '' }}     ">
                    <a href="#"
                        class="nav-link {{ (request()->is('admin/0*') || request()->is('admin/accounts*') || request()->is('admin/customer*') || request()->is('admin/suppliers_categories*') || request()->is('admin/supplier*') || (request()->is('admin/collect_transaction*') || request()->is('admin/exchange_transaction*') || request()->is('admin/delegates*'))) && !request()->is('admin/suppliers_orders*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            المراقبة والدعم الفني
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href=""
                                class="nav-link {{ request()->is('admin/0*') ? 'active' : '' }}">
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
                </li> --}}

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
