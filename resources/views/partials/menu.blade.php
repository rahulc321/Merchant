<style>
.app-sidebar .main-sidebar-header .header-logo img {
    height: 5.5rem;
    line-height: 9.75rem;
}

.app-sidebar .main-sidebar-header {
    height: 7.25rem;
}

/* New changes color schema change */
.btn-primary {
    background-color: rgb(59 94 182) !important;
    border-color: rgb(77 68 184) !important;
    /* color: #fff !important; */
}

.btn-primary:hover {
    background-color: rgb(59 94 182) !important;
    border-color: rgb(77 68 184) !important;
}

.btn-info {
    background-color: rgb(59 94 182) !important;
    border-color: rgb(77 68 184) !important;
    /* color: #fff !important; */
}

.btn-info:hover {
    background-color: rgb(59 94 182) !important;
    border-color: rgb(77 68 184) !important;
}

.btn-secondary {

    color: #fff !important;
    background-color: #8a96ab !important;
    border-color: #8c93ac !important;
}


.page-item.active .page-link {
    color: #fff;
    background-color: rgb(59 94 182) !important;
    border-color: rgb(77 68 184) !important;
}

.btn-secondary:hover {
    background-color: #8a96ab !important;
    border-color: #8c93ac !important;

}

/* //////////////////// */
.card-header:first-child {
    color: white !important;
    border-radius: 0.625rem 0.625rem 0 0;
    background: url(../images/bg-modal.png) repeat, linear-gradient(to right, #26D0CE, #1A2980);
}


.select2-container--default .select2-selection--multiple .select2-selection__choice {
    /* background-color: var(--primary-color) !important; */

    background: rgb(59 94 182) !important;

}

html[data-theme-mode="dark"] .c_color {
    color: white !important;
}

html[data-theme-mode="dark"] #comboChart svg text {
    fill: white !important;
}


.bg-1 {
    background-image: linear-gradient(45deg, #1a2a6c, #121329);
    color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.bg-2 {
    background: rgb(131, 58, 180);
    background-image: linear-gradient(45deg, #1a2a6c, #27cace);
}

.bg-3 {
    background: rgb(34, 193, 195);
    background-image: linear-gradient(-20deg, #2b5876 0%, #4e4376 100%) !important;
}

.bg-4 {
    background: rgb(191 215 216);
    background: radial-gradient(circle, rgb(230 123 230) 0%, rgb(224 125 226) 33%, rgb(253 45 251 / 36%) 100%);
}

.bg-5 {
    background: rgb(131, 58, 180);
    background-image: linear-gradient(45deg, #000000, #6c757d);
}
</style>
<div class="main-sidebar" id="sidebar-scroll">

    <!-- Start::nav -->
    <nav class="main-menu-container nav nav-pills flex-column sub-open">
        <div class="slide-left" id="slide-left">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
            </svg>
        </div>
        <ul class="main-menu">
            <!-- Start::slide__category -->
            <li class="slide__category"><span class="category-name">Dashboards</span></li>
            <!-- End::slide__category -->

            <li class="slide">
                <a href="{{ route('admin.home') }}" class="side-menu__item {{ request()->is('admin') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z" />
                        <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3" />
                    </svg>
                    <span class="side-menu__label">Dashboard</span>
                </a>
            </li>




            @if (Auth::user()->roles->contains('title', 'Admin'))
            <!-- Start::slide -->
            <li
                class="d-none slide has-sub {{ request()->is('admin/permissions*') ? 'open' : '' }} {{ request()->is('admin/roles*') ? 'open' : '' }} {{ request()->is('admin/admin*') ? 'open' : '' }}">
                <a href="javascript:void(0);"
                    class="side-menu__item {{ request()->is('admin/permissions*') ? 'active' : '' }} {{ request()->is('admin/roles*') ? 'active' : '' }} {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM8 13c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-2.33 4.67-3.5 7-3.5H8z" />
                    </svg>
                    <span class="side-menu__label">User Management</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">

                    <li class="slide">
                        <a href='{{ route("admin.permissions.index") }}'
                            class="side-menu__item {{ request()->is('admin/permissions*') ? 'active' : '' }}">Permissions</a>
                    </li>

                    <li class="slide">
                        <a href='{{ route("admin.roles.index") }}'
                            class="side-menu__item {{ request()->is('admin/roles*') ? 'active' : '' }}">Roles</a>
                    </li>

                    <li class="slide">
                        <a href='{{ route("admin.admin") }}'
                            class="side-menu__item {{ request()->is('admin/admin*') ? 'active' : '' }}">Admin</a>
                    </li>



                </ul>
            </li>

            <li class="slide d-none">
                <a href="{{ route('admin.users.index', ['type' => 'end_user']) }}"
                    class="side-menu__item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM8 13c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-2.33 4.67-3.5 7-3.5H8z" />
                    </svg>
                    <span class="side-menu__label">Students</span>
                </a>
            </li>

            <li class="slide has-sub {{ request()->is('admin/users*') ? 'open' : '' }}">
                <a href="javascript:void(0);"
                    class="side-menu__item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM8 13c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-2.33 4.67-3.5 7-3.5H8z" />
                    </svg>
                    <span class="side-menu__label">Users</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">
                    <li class="slide">
                        <a href="{{ route('admin.users.index', ['type' => 'student']) }}"
                            class="side-menu__item {{ request()->query('type', 'student') === 'student' ? 'active' : '' }}">Student</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.users.index', ['type' => 'teacher']) }}"
                            class="side-menu__item {{ request()->query('type') === 'teacher' ? 'active' : '' }}">Teacher</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.users.index', ['type' => 'youth']) }}"
                            class="side-menu__item {{ request()->query('type') === 'youth' ? 'active' : '' }}">Youth</a>
                    </li>
                    <li class="slide">
                        <a href="{{ route('admin.users.index', ['type' => 'normal']) }}"
                            class="side-menu__item {{ request()->query('type') === 'normal' ? 'active' : '' }}">Normal User</a>
                    </li>
                </ul>
            </li>

            <li class="slide">
                <a href='{{ route("admin.task.index") }}'
                    class="side-menu__item {{ request()->is('admin/task*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-4h16v4zm0-10H4V6h16v2z" />
                    </svg>
                    <span class="side-menu__label">Merchants</span>
                </a>
            </li>

            <li class="slide d-none">
                <a href='{{ route("admin.spin.index") }}?key=object'
                    class="side-menu__item {{ request()->is('admin/spin*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-4h16v4zm0-10H4V6h16v2z" />
                    </svg>
                    <span class="side-menu__label">Spin Objects</span>
                </a>
            </li>


            <li class="slide d-none">
                <a href='{{ route("admin.spin.index") }}?key=spin'
                    class="side-menu__item {{ request()->is('admin/spin*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-4h16v4zm0-10H4V6h16v2z" />
                    </svg>
                    <span class="side-menu__label">Spin</span>
                </a>
            </li>







            @if(Auth::user()->can('user_access'))
            <!--  -->
            <li
                class="d-none slide has-sub {{ request()->is('admin/permissions*') ? 'open' : '' }} {{ request()->is('admin/roles*') ? 'open' : '' }} {{ request()->is('admin/users*') ? 'open' : '' }} {{ request()->is('admin/contacts*') ? 'open' : '' }}">
                <a href="javascript:void(0);"
                    class="side-menu__item {{ request()->is('admin/permissions*') ? 'active' : '' }} {{ request()->is('admin/roles*') ? 'active' : '' }} {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM8 13c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-2.33 4.67-3.5 7-3.5H8z" />
                    </svg>
                    <span class="side-menu__label">Users</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">


                    <?php
                        $roles = DB::table('roles')->where('title','!=','Admin')->get();
                    ?>
                    @foreach($roles as $role)
                    <li class="slide">
                        @php
                        // Assuming $role->name contains the role name
                        $roleName = is_object($role) ? $role->title : $role;
                        $displayRole = ucfirst(str_replace('end_user_', '', $roleName));
                        @endphp
                        <a href="{{ route('admin.users.index', ['type' => $roleName]) }}"
                            class="side-menu__item {{ request()->query('type') === $roleName ? 'active' : '' }}">
                            {{ $displayRole }}
                        </a>

                        @if($role->title == 'distributor')
                        <ul class="sub-menu">
                            <li>
                                <a href="{{ route('admin.contacts') }}"
                                    class="side-menu__item {{ request()->is('admin/contacts*') ? 'active' : '' }}">
                                    Contacts
                                </a>
                            </li>
                        </ul>
                        @endif

                    </li>
                    @endforeach

                    <!-- <li class="slide">
                        <a href="{{ route('admin.contacts') }}"
                            class="side-menu__item {{ request()->is('admin/contacts*') ? 'active' : '' }}">
                            Contacts
                        </a>

                    </li> -->





                </ul>
            </li>
            @endif



            @if(Auth::user()->can('message_access'))
            <!-- MESSAGE -->
            <li class="slide d-none">
                <a href='{{ route("admin.message.index") }}'
                    class="side-menu__item {{ request()->is('admin/message*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-4h16v4zm0-10H4V6h16v2z" />
                    </svg>
                    <span class="side-menu__label">Messages</span>
                </a>
            </li>

            @endif



            @endif
            @if(Auth::user()->can('task_access'))
            <!-- Task -->

            @endif

            @if(Auth::user()->can('training_access'))
            <!-- <li class="slide">
                <a href='{{ route("admin.training") }}'
                    class="side-menu__item {{ request()->is('admin/training*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 2L1 9l11 7 9-5.9V17h2V9L12 2zm0 2.75L18.14 9 12 13.25 5.86 9 12 4.75zM4 19h16v2H4v-2z" />
                    </svg>
                    <span class="side-menu__label">Training</span>
                </a>
            </li> -->
            @endif
            @if(Auth::user()->can('training_access'))
            <!-- New change -->
            <li
                class="d-none slide has-sub {{ request()->is('admin/training*') ? 'open' : '' }} {{ request()->is('admin/category*') ? 'open' : '' }} {{ request()->is('admin/listCategory*') ? 'open' : '' }}">
                <a href="javascript:void(0);"
                    class="side-menu__item {{ request()->is('admin/permissions*') ? 'active' : '' }} {{ request()->is('admin/roles*') ? 'active' : '' }} {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM8 13c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-2.33 4.67-3.5 7-3.5H8z" />
                    </svg>
                    <span class="side-menu__label">Training</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">

                    <li class="slide">
                        <a href='{{ route("admin.listCategory") }}'
                            class="side-menu__item {{ request()->is('admin/listCategory*') ? 'active' : '' }}">Training</a>
                    </li>

                    <li class="slide">
                        <a href='{{ route("admin.category.index") }}'
                            class="side-menu__item {{ request()->is('admin/category*') ? 'active' : '' }}">Training
                            Category</a>
                    </li>





                </ul>
            </li>
            <!-- New chhange -->
            @endif
            @if (Auth::user()->roles->contains('title', 'Admin'))
            <li class="slide">
                <a href='{{ route("admin.plans.index") }}'
                    class="side-menu__item {{ request()->is('admin/plans*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-1 16H6V5h12v14zM8 7h8v2H8V7zm0 4h8v2H8v-2zm0 4h5v2H8v-2z" />
                    </svg>
                    <span class="side-menu__label">Plans</span>
                </a>
            </li>
            <li class="slide">
                <a href='{{ route("admin.subscriptions.index") }}'
                    class="side-menu__item {{ request()->is('admin/subscriptions*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v2h20V6c0-1.1-.9-2-2-2zm0 6H2v8c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-8zm-11 6H5v-2h4v2zm6 0h-4v-2h4v2z" />
                    </svg>
                    <span class="side-menu__label">Subscriptions</span>
                </a>
            </li>
            <li class="slide">
                <a href='{{ route("admin.payment-settings.edit") }}'
                    class="side-menu__item {{ request()->is('admin/payment-settings*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M19.43 12.98c.04-.32.07-.65.07-.98s-.02-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.37-.31-.6-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98L14.5 2.42C14.47 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.5.42L9.12 5.07c-.61.25-1.18.59-1.69.98l-2.49-1c-.23-.08-.48 0-.6.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.08.65-.08.98s.03.66.08.98l-2.11 1.65c-.19.15-.24.42-.12.64l2 3.46c.12.22.37.31.6.22l2.49-1c.52.4 1.08.73 1.69.98l.38 2.65c.04.24.25.42.5.42h4c.25 0 .47-.18.5-.42l.38-2.65c.61-.25 1.18-.59 1.69-.98l2.49 1c.23.08.48 0 .6-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5A3.5 3.5 0 1 1 12 8a3.5 3.5 0 0 1 0 7.5z" />
                    </svg>
                    <span class="side-menu__label">Settings</span>
                </a>
            </li>
            <li class="slide">
                <a href='{{ route("admin.maintenance.index") }}'
                    class="side-menu__item {{ request()->is('admin/maintenance*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3l4.1 4.1-2.9 2.9-4.2-4.1C.7 7 .9 10 3 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.4-.4.4-1 0-1.4z" />
                    </svg>
                    <span class="side-menu__label">Maintenance</span>
                </a>
            </li>
            <li class="slide d-none">
                <a href='{{ route("admin.orders") }}'
                    class="side-menu__item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-4h16v4zm0-10H4V6h16v2z" />
                    </svg>
                    <span class="side-menu__label">All Orders</span>
                </a>
            </li>
            @else
            <li class="slide">
                <a href='{{ route("admin.plans.browse") }}'
                    class="side-menu__item {{ request()->is('admin/purchase-plans*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 2L4 5v6c0 5.55 3.84 10.74 8 12 4.16-1.26 8-6.45 8-12V5l-8-3zm0 2.18L18 6v5c0 4.52-2.98 8.69-6 9.88-3.02-1.19-6-5.36-6-9.88V6l6-1.82zM11 7h2v6h-2V7zm0 8h2v2h-2v-2z" />
                    </svg>
                    <span class="side-menu__label">Subscriptions</span>
                </a>
            </li>
            <li class="slide d-none">
                <a href='{{ route("admin.orders") }}'
                    class="side-menu__item {{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-4h16v4zm0-10H4V6h16v2z" />
                    </svg>
                    <span class="side-menu__label">All Orders</span>
                </a>
            </li>

            @endif

            <li class="slide">
                <a href='{{ route("admin.userProfile") }}'
                    class="side-menu__item {{ request()->is('admin/userProfile*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4v-4h16v4zm0-10H4V6h16v2z" />
                    </svg>
                    <span class="side-menu__label">Profile</span>
                </a>
            </li>

            <li class="slide">
                <a class="dropdown-item d-flex align-items-center" href="javascript:;"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();"
                    style="color:white"><i class="ti ti-logout me-2 fs-18 text-white"></i>Log Out</a>
            </li>


            @if(Auth::user()->can('product_access'))
            <li class="slide d-none">
                <a href='{{ route("admin.products") }}'
                    class="side-menu__item {{ request()->is('admin/products*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M21 8V7l-3-2V3c0-1.1-.9-2-2-2H8C6.9 1 6 1.9 6 3v2L3 7v1H2v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8h-1zM8 3h8v2H8V3zm11 16H5V9h14v10zm-4-8H7v2h8v-2zm2 4H7v2h10v-2z" />
                    </svg>
                    <span class="side-menu__label">Products</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('device_access'))
            <li class="slide d-none">
                <a href='{{ route("admin.devices") }}'
                    class="side-menu__item {{ request()->is('admin/devices*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M16 10H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2zm0 8H4v-6h12v6zM22 5h-8c-1.1 0-2 .9-2 2v2h2V7h8v10h-8v-2h-2v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2z" />
                    </svg>
                    <span class="side-menu__label">Devices</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('training_access_user'))
            @if (!Auth::user()->roles->contains('title', 'Admin'))
            <li class="slide d-none">
                <a href='{{ route("admin.listCategoryUser") }}'
                    class="side-menu__item {{ request()->is('admin/listCategoryUser*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 2L1 9l11 7 9-5.9V17h2V9L12 2zm0 2.75L18.14 9 12 13.25 5.86 9 12 4.75zM4 19h16v2H4v-2z" />
                    </svg>
                    <span class="side-menu__label">Training</span>
                </a>
            </li>
            @endif
            @endif


            @if(Auth::user()->can('map_access'))
            <li class="slide d-none">
                <a href="{{route('admin.deviceOverMap')}}"
                    class="side-menu__item {{ request()->is('admin/deviceOverMap*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M16 10H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2zm0 8H4v-6h12v6zM22 5h-8c-1.1 0-2 .9-2 2v2h2V7h8v10h-8v-2h-2v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2z" />
                    </svg>
                    <span class="side-menu__label">Device Map</span>
                </a>
            </li>
            @endif

            @if(Auth::user()->can('fault_access'))
            <!-- <li class="slide">
                <a href="{{route('admin.fault.index')}}"
                    class="side-menu__item {{ request()->is('admin/fault*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M16 10H4c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-6c0-1.1-.9-2-2-2zm0 8H4v-6h12v6zM22 5h-8c-1.1 0-2 .9-2 2v2h2V7h8v10h-8v-2h-2v2c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2z" />
                    </svg>
                    <span class="side-menu__label">Fault Analysis</span>
                </a>
            </li> -->

            <li class="d-none slide has-sub {{ request()->is('admin/fault*') ? 'open' : '' }}">
                <a href="javascript:void(0);"
                    class="side-menu__item {{ request()->is('admin/fault*') ? 'active' : '' }} {{ request()->is('admin/fault*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm8 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zM8 13c-2.33 0-7 1.17-7 3.5V19h7v-2.5c0-2.33 4.67-3.5 7-3.5H8z" />
                    </svg>
                    <span class="side-menu__label">Fault Management</span>
                    <i class="ri-arrow-right-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1 pages-ul">

                    <li class="slide">
                        <a href='{{ route("admin.faultDevice") }}'
                            class="side-menu__item {{ request()->is('admin/faultDevice*') ? 'active' : '' }}">Active
                            Fault</a>
                    </li>

                    <li class="slide">
                        <a href='{{ route("admin.fault.index") }}'
                            class="side-menu__item {{ request()->is('admin/fault*') ? 'active' : '' }}">Error Code &
                            Fixes</a>
                    </li>




                </ul>
            </li>
            @endif

            @if(Auth::user()->can('download_access'))
            <li class="slide d-none">
                <a href="{{ route('admin.download.index') }}"
                    class="side-menu__item {{ request()->is('admin/download*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" height="24px" viewBox="0 0 24 24"
                        width="24px" fill="#5f6368">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 20h14v-2H5v2zM13 4h-2v8H8l4 4 4-4h-3z" />
                    </svg>
                    <span class="side-menu__label">Downloads</span>
                </a>
            </li>
            @endif


        </ul>
        <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24"
                height="24" viewBox="0 0 24 24">
                <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"></path>
            </svg></div>
    </nav>
    <!-- End::nav -->

</div>
