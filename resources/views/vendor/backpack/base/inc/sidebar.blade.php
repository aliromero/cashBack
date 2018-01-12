@if (Auth::check())
    <?php $user = Auth::user(); ?>
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-right image">
                    <img src="http://placehold.it/160x160/00a65a/ffffff/&text={{ Auth::user()->name[0] }}"
                         class="img-circle" alt="User Image">
                </div>
                <div class="pull-right info">
                    <p>{{ Auth::user()->name }}</p>
                    <a href="#"><i class="fa fa-circle text-success"></i> آنلاین</a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">مدیریت</li>
                <!-- ================================================ -->
                <!-- ==== Recommended place for admin menu items ==== -->
                <!-- ================================================ -->


                @if ($user->can('area') || $user->can('city'))
                    <li class="treeview">
                        <a href="#"><i class="fa fa-angle-left pull-left"></i><i class="fa fa-map-marker"></i>
                            <span>شهر ها و محله ها</span></a>
                        <ul class="treeview-menu">

                            @if ($user->can('city'))
                                <li><a href="{{ url(config('backpack.base.route_prefix').'/city') }}">
                                        <i class="fa fa-angle-left"></i> <span>شهر ها</span></a></li>

                            @endif
                            @if ($user->can('area'))
                                <li><a href="{{ url(config('backpack.base.route_prefix').'/area') }}">
                                        <i class="fa fa-angle-left"></i> <span>محله ها</span></a></li>
                            @endif


                        </ul>
                    </li>
                @endif

                @if ($user->can('shop'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/shop') }}"><i
                                    class="fa fa-shopping-bag"
                                    aria-hidden="true"></i> <span>فروشگاه ها</span></a>
                    </li>
                @endif


                @if ($user->can('category'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/category') }}">
                            <i class="fa fa-list"></i> <span>دسته بندی ها</span></a></li>
                @endif


                @if ($user->can('product'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/product') }}">
                            <i class="fa fa-shopping-basket"></i> <span>محصولات</span></a></li>
                @endif


                @if ($user->can('vote'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/page') }}">
                            <i class="fa fa-gear"></i> <span>صفحات سایت</span></a></li>
                @endif


                @if ($user->can('vote'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/vote') }}">
                            <i class="fa fa-gear"></i> <span>نظر سنجی ها</span></a></li>
                @endif



                @if ($user->can('video'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/video') }}">
                            <i class="fa fa-gear"></i> <span>کلیپ های تبلیغاتی</span></a></li>
                @endif


                @if ($user->can('banner'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/banner') }}">
                            <i class="fa fa-image"></i> <span>بنرهای فروشگاهی</span></a></li>
                @endif


                @if ($user->can('setting'))
                    <li><a href="{{ url(config('backpack.base.route_prefix').'/setting') }}">
                            <i class="fa fa-gear"></i> <span>تنظیمات</span></a></li>
                @endif

                @if ($user->can('user') || $user->can('role') || $user->can('permission') || $user->can('elfinder') || $user->can('backup') || $user->can('log'))
                    <li class="header">تنظیمات</li>


                    @if ($user->can('user') || $user->can('role') || $user->can('permission'))
                        <li class="treeview">
                            <a href="#"><i class="fa fa-angle-left pull-left"></i><i
                                        class="fa fa-group"></i>
                                <span>مدیران</span> </a>
                            <ul class="treeview-menu">
                                @if ($user->can('role'))
                                    <li>
                                        <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i
                                                    class="fa fa-group"></i> <span>نقش ها</span></a></li>
                                @endif
                                @if ($user->can('permission'))
                                    <li>
                                        <a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i
                                                    class="fa fa-key"></i> <span>دسترسی ها</span></a></li>
                                @endif
                                @if ($user->can('user'))
                                    <li><a href="{{ url(config('backpack.base.route_prefix').'/user') }}"><i
                                                    class="fa fa-users"></i> <span>مدیران</span></a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    @if ($user->can('elfinder') || $user->can('backup') || $user->can('log'))
                        <li class="treeview">
                            <a href="#"><i class="fa fa-angle-left pull-left"></i><i class="fa fa-cogs"></i>
                                <span>پیشرفته</span></a>
                            <ul class="treeview-menu">
                                @if ($user->can('elfinder'))
                                    <li><a href="{{ url(config('backpack.base.route_prefix').'/elfinder') }}"><i
                                                    class="fa fa-files-o"></i> <span>مدیریت فایل</span></a></li>
                                @endif
                                @if ($user->can('backup'))
                                    <li><a href="{{ url(config('backpack.base.route_prefix').'/backup') }}"><i
                                                    class="fa fa-hdd-o"></i> <span>پشتیبان ها</span></a></li>
                                @endif
                                @if ($user->can('log'))
                                    <li><a href="{{ url(config('backpack.base.route_prefix').'/log') }}"><i
                                                    class="fa fa-terminal"></i> <span>لاگ ها</span></a></li>
                                @endif
                            </ul>
                        </li>
                    @endif
                @endif
                <li><a href="{{ url(config('backpack.base.route_prefix').'/logout') }}"><i
                                class="fa fa-sign-out"></i>
                        <span>{{ trans('backpack::base.logout') }}</span></a></li>


            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
@endif
