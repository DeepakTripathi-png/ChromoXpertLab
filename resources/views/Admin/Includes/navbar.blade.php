<style>
    /* Custom scrollbar for sidebar */
    .left-side-menu::-webkit-scrollbar {
        width: 8px;
    }
    .left-side-menu::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .left-side-menu::-webkit-scrollbar-thumb {
        background: #ac7fb6;
        border-radius: 4px;
    }
    .left-side-menu::-webkit-scrollbar-thumb:hover {
        background: #cc235e;
    }
    /* Sidebar Styling */
    .left-side-menu {
        background: linear-gradient(180deg, #6267ae 0%, #cc235e 100%);
        box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.2);
    }
    #sidebar-menu ul li a {
        display: flex;
        align-items: center;
        padding: 12px 18px;
        font-size: 15px;
        font-weight: 500;
        color: #e0e7ff;
        border-radius: 8px;
        margin: 4px 10px;
        transition: all 0.3s ease;
    }
    #sidebar-menu ul li a i {
        font-size: 18px;
        margin-right: 10px;
        color: #f6b51d;
    }
    #sidebar-menu ul li a:hover {
        background: #fff;
        color: #1f2937;
        transform: scale(1.02);
    }
    #sidebar-menu ul li a:hover i {
        color: #6267ae;
    }
    #sidebar-menu ul li.active > a {
        background: #fff;
        color: #1f2937;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transform: translateX(4px);
    }
    #sidebar-menu ul li.active > a i {
        color: #6267ae;
    }
    /* Submenu Styling */
    #sidebar-menu .nav-second-level li a {
        padding: 10px 18px 10px 40px;
        font-size: 14px;
        color: #e0e7ff;
        border-radius: 8px;
        margin: 2px 10px;
        transition: all 0.3s ease;
    }
    #sidebar-menu .nav-second-level li a:hover {
        background: #fff;
        color: #1f2937;
    }
    #sidebar-menu .nav-second-level li.active a {
        background: #fff;
        color: #1f2937;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
    .menu-arrow {
        color: #f6b51d;
        margin-left: auto;
        font-size: 14px;
    }
    .menu-arrow::before {
        content: '\f078';
        font-family: 'Material Design Icons';
    }
    /* Navbar Styling */
    .navbar-custom {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0px 1px 8px rgba(0, 0, 0, 0.1);
    }
    .navbar-custom .topnav-menu > li > a {
        color: #6267ae;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    .navbar-custom .topnav-menu > li > a:hover {
        background: #f6b51d;
        color: #1f2937;
    }
    /* Profile Image */
    .nav-user img {
        border: 2px solid #f6b51d;
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 50%;
    }
    /* Notification Badge */
    .noti-icon-badge {
        font-size: 10px;
        padding: 3px 5px;
        background: #cc235e;
        color: #fff;
        border-radius: 50%;
    }
    /* Dropdown Menu */
    .dropdown-menu {
        background: #fff;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .dropdown-menu .dropdown-item {
        color: #6267ae;
        padding: 8px 16px;
        transition: background 0.3s ease;
    }
    .dropdown-menu .dropdown-item:hover {
        background: #f6b51d;
        color: #1f2937;
    }
    .dropdown-header h6 {
        color: #6267ae;
    }
    .dropdown-header small {
        color: #ac7fb6;
    }
</style>

{{-- Topbar --}}
<div class="navbar-custom">
    <div class="d-flex align-items-center">
        <a href="{{ url('/admin/dashboard') }}" class="ms-3">
            <img src="{{ !empty(App\Helpers\Helpers\Helper::getVisualImages()->logo_image_path) && Storage::exists(App\Helpers\Helpers\Helper::getVisualImages()->logo_image_path) ? url('/').Storage::url(App\Helpers\Helpers\Helper::getVisualImages()->logo_image_path) : URL::asset('package_assets/images/logo.png') }}" height="40" alt="ChromoXpert Logo">
        </a>
    </div>
    <ul class="list-unstyled topnav-menu float-end mb-0">
        {{-- Notifications --}}
        @if(Auth::guard('master_admins')->check() && str_contains(Auth::guard('master_admins')->user()->role->privileges ?? '', 'notifications_view'))
            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link waves-effect waves-light" href="{{ url('admin/notification') }}" aria-label="Notifications">
                    <i class="fe-bell noti-icon text-[#6267ae] text-lg"></i>
                    <span class="badge bg-danger rounded-circle noti-icon-badge">9</span>
                </a>
            </li>
        @endif

        {{-- Profile --}}
        @if(Auth::guard('master_admins')->check())
            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" aria-label="User profile">
                    <img src="{{ !empty(Auth::guard('master_admins')->user()->user_profile_image_path) && Storage::exists(Auth::guard('master_admins')->user()->user_profile_image_path) ? url('/').Storage::url(Auth::guard('master_admins')->user()->user_profile_image_path) : URL::asset('package_assets/images/default-images/profile-image.png') }}" class="rounded-circle">
                    <span class="pro-user-name ms-1 text-[#6267ae]">
                        {{ Auth::guard('master_admins')->user()->user_name ?? '' }}
                        <i class="mdi mdi-chevron-down text-[#f6b51d]"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                    <div class="dropdown-header text-center">
                        <h6>
                            Welcome, {{ Auth::guard('master_admins')->user()->user_name ?? '' }}
                        </h6>
                        <small>{{ App\Helpers\Helpers\Helper::getRoleName() }}</small>
                    </div>
                    <a href="javascript:;" class="dropdown-item"><i class="fe-user text-[#6267ae] me-2"></i> My Account</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ url('admin/logout') }}" class="dropdown-item"><i class="fe-log-out text-[#6267ae] me-2"></i> Logout</a>
                </div>
            </li>
        @endif
    </ul>
</div>

{{-- Sidebar --}}
@php
$role_id = null;
$RolesPrivileges = null;
if (Auth::guard('master_admins')->check()) {
    $role_id = Auth::guard('master_admins')->user()->role_id;
    $RolesPrivileges = App\Models\Master\Role_privilege::where('status', 'active')->where('id', $role_id)->select('privileges')->first();
}
@endphp

<div class="left-side-menu">
    <div class="h-100" data-simplebar>
        <div id="sidebar-menu">
            <ul id="side-menu">
                @if(Auth::guard('master_admins')->check())
                    {{-- Admin Dashboard --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'dashboard_view'))
                    <li class="{{ Request::is('admin/dashboard*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/dashboard') }}">
                            <i class="mdi mdi-monitor-dashboard"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    @endif

                    {{-- Appointments --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'appointments_view'))
                    <li class="{{ Request::is('admin/appointments*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/appointments') }}">
                            <i class="mdi mdi-calendar-clock"></i>
                            <span> New Registration </span>
                        </a>
                    </li>
                    @endif

                    {{-- Test Reports --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view'))
                    <li class="{{ Request::is('admin/report*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/report') }}">
                            <i class="mdi mdi-file-chart-outline"></i>
                            <span> Reports </span>
                        </a>
                    </li>
                    @endif


                    {{-- Test Reports --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'reports_view'))
                    <li class="{{ Request::is('admin/sample*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/sample') }}">
                            <i class="mdi mdi-file-chart-outline"></i>
                            <span> Sample </span>
                        </a>
                    </li>
                    @endif
                    

                    {{-- Branches --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'branch_view'))
                    <li class="{{ Request::is('admin/branches*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/branches') }}">
                            <i class="mdi mdi-map-marker-radius"></i>
                            <span> Branches/Collection Center/Hospitals </span>
                        </a>
                    </li>
                    @endif

                    {{-- Departments --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'departments_view'))
                    <li class="{{ Request::is('admin/departments*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/departments') }}">
                            <i class="mdi mdi-domain"></i>
                            <span> Departments </span>
                        </a>
                    </li>
                    @endif

                    {{-- Doctors --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'doctors_view'))
                    <li class="{{ Request::is('admin/doctors*', 'admin/internal-doctors*', 'admin/referee-doctors*') ? 'active' : '' }}">
                        <a href="#doctors" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/doctors*', 'admin/internal-doctors*', 'admin/referee-doctors*') ? 'true' : 'false' }}">
                            <i class="mdi mdi-stethoscope"></i>
                            <span> Doctors </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/doctors*', 'admin/internal-doctors*', 'admin/referee-doctors*') ? 'show' : '' }}" id="doctors">
                            <ul class="nav-second-level">
                                <li class="{{ Request::is('admin/internal-doctors*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/internal-doctors') }}">
                                        <span> Internal Doctors </span>
                                    </a>
                                </li>
                                <li class="{{ Request::is('admin/referee-doctors*') ? 'active' : '' }}">
                                    <a href="{{ url('/admin/referee-doctors') }}">
                                        <span> Referee Doctors </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    {{-- Pet Parents --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_owners_view'))
                    <li class="{{ Request::is('admin/parent*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/parent') }}">
                            <i class="mdi mdi-account-heart"></i>
                            <span> Pet Parent / Care Of </span>
                        </a>
                    </li>
                    @endif

                    {{-- Pets --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'pet_view'))
                    <li class="{{ Request::is('admin/pet*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/pet') }}">
                            <i class="mdi mdi-paw"></i>
                            <span> Pets </span>
                        </a>
                    </li>
                    @endif

                    {{-- Test Management --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'test_view'))
                    <li class="{{ Request::is('admin/test-case*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/test-case') }}">
                            <i class="mdi mdi-flask-outline"></i>
                            <span> Tests </span>
                        </a>
                    </li>
                    @endif

                    {{-- Revenue --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'revenue_view'))
                    <li class="{{ Request::is('admin/revenu*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/revenu') }}">
                            <i class="mdi mdi-cash-multiple"></i>
                            <span> Revenue </span>
                        </a>
                    </li>
                    @endif

                    {{-- System Users --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'system_users_view'))
                    <li class="{{ Request::is('admin/system-user*', 'admin/roles-privileges*') ? 'active' : '' }}">
                        <a href="#system-user" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/system-user*', 'admin/roles-privileges*') ? 'true' : 'false' }}">
                            <i class="mdi mdi-account-group-outline"></i>
                            <span> System Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/system-user*', 'admin/roles-privileges*') ? 'show' : '' }}" id="system-user">
                            <ul class="nav-second-level">
                                @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'user_view'))
                                <li class="{{ Request::is('admin/system-user*') ? 'active' : '' }}">
                                    <a href="{{ url('admin/system-user') }}">
                                        <span> Users </span>
                                    </a>
                                </li>
                                @endif
                                @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'role_privileges_view'))
                                <li class="{{ Request::is('admin/roles-privileges*') ? 'active' : '' }}">
                                    <a href="{{ url('/admin/roles-privileges') }}">
                                        <span> Role Privileges </span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                    @endif

                    {{-- Settings --}}
                    @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'settings_view'))
                    <li class="{{ Request::is('admin/general-setting*', 'admin/visual-setting*', 'admin/change-password*') ? 'active' : '' }}">
                        <a href="#setting" data-bs-toggle="collapse" aria-expanded="{{ Request::is('admin/general-setting*', 'admin/visual-setting*', 'admin/change-password*') ? 'true' : 'false' }}">
                            <i class="mdi mdi-cog-outline"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse {{ Request::is('admin/general-setting*', 'admin/visual-setting*', 'admin/change-password*') ? 'show' : '' }}" id="setting">
                            <ul class="nav-second-level">
                                @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'general_setting_view'))
                                <li class="{{ Request::is('admin/general-setting*') ? 'active' : '' }}">
                                    <a href="{{ url('/admin/general-setting') }}">
                                        <span> General Settings </span>
                                    </a>
                                </li>
                                @endif
                                @if(!empty($RolesPrivileges) && str_contains($RolesPrivileges->privileges, 'visual_setting_view'))
                                <li class="{{ Request::is('admin/visual-setting*') ? 'active' : '' }}">
                                    <a href="{{ url('/admin/visual-setting') }}">
                                        <span> Visual Settings </span>
                                    </a>
                                </li>
                                @endif
                                <li class="{{ Request::is('admin/change-password*') ? 'active' : '' }}">
                                    <a href="{{ url('/admin/change-password') }}">
                                        <span> Change Password </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @endif

                    {{-- Notifications --}}
                    <li>
                        <a href="{{ url('admin/notification') }}">
                            <i class="mdi mdi-bell-outline"></i>
                            <span> Notifications </span>
                        </a>
                    </li>

                    {{-- Logout --}}
                    <li>
                        <a href="{{ url('admin/logout') }}">
                            <i class="mdi mdi-logout"></i>
                            <span> Logout </span>
                        </a>
                    </li>
                @else
                    {{-- Guest Links --}}
                    <li>
                        <a href="{{ url('/admin') }}">
                            <i class="mdi mdi-login"></i>
                            <span> Admin Login </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all Bootstrap dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });

    // Initialize collapse components for sidebar menus
    var collapseElementList = [].slice.call(document.querySelectorAll('[data-bs-toggle="collapse"]'))
    var collapseList = collapseElementList.map(function (collapseToggleEl) {
        return new bootstrap.Collapse(collapseToggleEl, {
            toggle: false
        })
    });
});
</script>