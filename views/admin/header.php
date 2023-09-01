<?php
$action = $_GET['url'];
$url = explode('/', $action);
// echo "<pre>";
// print_r($action);
// die;
?>
<div class="sidebar-wrapper group">
    <div id="bodyOverlay" class="w-screen h-screen fixed top-0 bg-slate-900 bg-opacity-50 backdrop-blur-sm z-10 hidden">
    </div>
    <div class="logo-segment">
        <a class="flex items-center" href="<?= URL . admin_link ?>">
            <!-- <img src="<?=URL?>public/admin/images/logo/logo-c.svg" class="black_logo" alt="logo"> -->
            <!-- <img src="<?=URL?>public/admin/images/logo/logo-c-white.svg" class="white_logo" alt="logo"> -->
            <img src="<?=URL?>public/favicon/favicon-32x32.png" class="black_logo" alt="logo">
            <img src="<?=URL?>public/favicon/favicon-32x32.png" class="white_logo" alt="logo">
            <span class="ltr:ml-3 rtl:mr-3 text-xl font-Inter font-bold text-slate-900 dark:text-white">Admin</span>
        </a>
        <!-- Sidebar Type Button -->
        <div id="sidebar_type" class="cursor-pointer text-slate-900 dark:text-white text-lg">
            <iconify-icon class="sidebarDotIcon extend-icon text-slate-900 dark:text-slate-200"
                icon="fa-regular:dot-circle"></iconify-icon>
            <iconify-icon class="sidebarDotIcon collapsed-icon text-slate-900 dark:text-slate-200"
                icon="material-symbols:circle-outline"></iconify-icon>
        </div>
        <button class="sidebarCloseIcon text-2xl">
            <iconify-icon class="text-slate-900 dark:text-slate-200" icon="clarity:window-close-line">
            </iconify-icon>
        </button>
    </div>
    <div id="nav_shadow"
        class="nav_shadow h-[60px] absolute top-[80px] nav-shadow z-[1] w-full transition-all duration-200 pointer-events-none opacity-0">
    </div>
    <div class="sidebar-menus bg-white dark:bg-slate-800 py-2 px-4 h-[calc(100%-80px)] overflow-y-auto z-50"
        id="sidebar_menus">
        <ul class="sidebar-menu">
            <li class="sidebar-menu-title">MENU</li>
            <!-- <li class="">
                <a href="<?= URL ?><?= admin_link ?>"
                    class="navItem<?= ($action == admin_link || $action == admin_link.'/' || $action == admin_link.'/index') ? ' active' : ''; ?>">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="heroicons-outline:home"></iconify-icon>
                        <span>Home</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/form"
                    class="navItem<?= ($action == admin_link.'/form') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="heroicons-outline:chat"></iconify-icon>
                        <span>Form</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/table"
                    class="navItem<?= ($action == admin_link.'/table') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="uiw:table"></iconify-icon>
                        <span>Table</span>
                    </span>
                </a>
            </li> -->
            <li>
                <a href="javascript:void(0)" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="bx:user">
                        </iconify-icon>
                        <span>User</span>
                    </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul
                    class="sidebar-submenu<?= ($action == admin_link.'/users' || $action == admin_link.'/user_requests') ? ' menu-open' : ''; ?>">
                    <li>
                        <a href="<?=URL . admin_link ?>/users"
                            class="<?= ($action == admin_link.'/users') ? 'active' : '' ?>">All Users</a>
                    </li>
                    <li>
                        <a href="<?=URL . admin_link?>/user_requests"
                            class="<?= ($action == admin_link.'/user_requests') ? 'active' : '' ?>">User Requests</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/business"
                    class="navItem<?= ($action == admin_link.'/business') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="ion:business-outline">
                        </iconify-icon>
                        <span>Business</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="material-symbols:domain-verification-outline-rounded">
                        </iconify-icon>
                        <span>KYC</span>
                    </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul
                    class="sidebar-submenu<?= ($action == admin_link.'/kyc' || $action == admin_link.'/kyc/pending') ? ' menu-open' : ''; ?>">
                    <li>
                        <a href="<?=URL . admin_link ?>/kyc"
                            class="<?= ($action == admin_link.'/kyc') ? 'active' : '' ?>">All</a>
                    </li>
                    <li>
                        <a href="<?=URL . admin_link?>/kyc/pending"
                            class="<?= ($action == admin_link.'/kyc/pending') ? 'active' : '' ?>">New KYC Requests</a>
                    </li>
                </ul>
            </li>
            <!-- <li>
                <a href="<?= URL ?><?= admin_link ?>/leads"
                    class="navItem<?= ($action == admin_link.'/leads') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="clarity:list-line">
                        </iconify-icon>
                        <span>Leads</span>
                    </span>
                </a>
            </li> -->
            <li>
                <a href="<?= URL ?><?= admin_link ?>/jobs"
                    class="navItem<?= ($action == admin_link.'/jobs') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="clarity:list-line">
                        </iconify-icon>
                        <span>Jobs</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/sub_categories"
                    class="navItem<?= ($action == admin_link.'/sub_categories') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="mdi:category-plus-outline">
                        </iconify-icon>
                        <span>Sub Categories</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/questions"
                    class="navItem<?= ($action == admin_link.'/questions') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="ri:question-line">
                        </iconify-icon>
                        <span>Questions</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/answers"
                    class="navItem<?= ($action == admin_link.'/answers') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="clarity:list-line">
                        </iconify-icon>
                        <span>Answers</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/reject_reason"
                    class="navItem<?= ($action == admin_link.'/reject_reason') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="clarity:list-line">
                        </iconify-icon>
                        <span>KYC Reject Reason</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/job_fee_packages"
                    class="navItem<?= ($action == admin_link.'/job_fee_packages') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="clarity:list-line">
                        </iconify-icon>
                        <span>Job's Fee Packages</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= URL ?><?= admin_link ?>/change_password"
                    class="navItem<?= ($action == admin_link.'/change_password') ? ' active' : '' ?>">
                    <span class="flex items-center">
                        <iconify-icon class="nav-icon" icon="solar:lock-password-broken">
                        </iconify-icon>
                        <span>Change Password</span>
                    </span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="navItem">
                    <span class="flex items-center">
                        <iconify-icon class=" nav-icon" icon="icon-park-solid:setting-two"></iconify-icon>
                        <span>Settings</span>
                    </span>
                    <iconify-icon class="icon-arrow" icon="heroicons-outline:chevron-right"></iconify-icon>
                </a>
                <ul
                    class="sidebar-submenu<?= ($action == admin_link.'/country' || $action == admin_link.'/state' || $action == admin_link.'/city') ? ' menu-open' : ''; ?>">
                    <li>
                        <a href="<?=URL . admin_link ?>/country"
                            class="<?= ($action == admin_link.'/country') ? 'active' : '' ?>">Country</a>
                    </li>
                    <li>
                        <a href="<?=URL . admin_link?>/state"
                            class="<?= ($action == admin_link.'/state') ? 'active' : '' ?>">State</a>
                    </li>
                    <li>
                        <a href="<?=URL . admin_link?>/city"
                            class="<?= ($action == admin_link.'/city') ? 'active' : '' ?>">City</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="flex flex-col justify-between min-h-screen">
    <div>
        <!-- BEGIN: Header -->
        <div class="z-[9]" id="app_header">
            <div
                class="app-header z-[999] ltr:ml-[248px] rtl:mr-[248px] bg-white dark:bg-slate-800 shadow-sm dark:shadow-slate-700">
                <div class="flex justify-between items-center h-full">
                    <div class="flex items-center md:space-x-4 space-x-2 xl:space-x-0 rtl:space-x-reverse vertical-box">
                        <a href="<?= URL . admin_link ?>" class="mobile-logo xl:hidden inline-block">
                            <img src="<?=URL?>public/admin/images/logo/logo-c.svg" class="black_logo" alt="logo">
                            <img src="<?=URL?>public/admin/images/logo/logo-c-white.svg" class="white_logo" alt="logo">
                        </a>
                        <button class="smallDeviceMenuController hidden md:inline-block xl:hidden">
                            <iconify-icon
                                class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                                icon="heroicons-outline:menu-alt-3"></iconify-icon>
                        </button>
                    </div>
                    <!-- end vertcial -->
                    <div class="items-center space-x-4 rtl:space-x-reverse horizental-box">
                        <a href="<?= URL . admin_link ?>">
                            <span class="xl:inline-block hidden">
                                <img src="<?=URL?>public/admin/images/logo/logo.svg" class="black_logo " alt="logo">
                                <img src="<?=URL?>public/admin/images/logo/logo-white.svg" class="white_logo"
                                    alt="logo">
                            </span>
                            <span class="xl:hidden inline-block">
                                <img src="<?=URL?>public/admin/images/logo/logo-c.svg" class="black_logo " alt="logo">
                                <img src="<?=URL?>public/admin/images/logo/logo-c-white.svg" class="white_logo "
                                    alt="logo">
                            </span>
                        </a>
                        <button class="smallDeviceMenuController  open-sdiebar-controller xl:hidden inline-block">
                            <iconify-icon
                                class="leading-none bg-transparent relative text-xl top-[2px] text-slate-900 dark:text-white"
                                icon="heroicons-outline:menu-alt-3"></iconify-icon>
                        </button>

                    </div>
                    <!-- end horizental -->
                    <!-- end top menu -->
                    <div class="nav-tools flex items-center lg:space-x-5 space-x-3 rtl:space-x-reverse leading-0">

                        <!-- Theme Changer -->
                        <!-- BEGIN: Toggle Theme -->
                        <div>
                            <button id="themeMood"
                                class="h-[28px] w-[28px] lg:h-[32px] lg:w-[32px] lg:bg-gray-500-f7 bg-slate-50 dark:bg-slate-900 lg:dark:bg-slate-900 dark:text-white text-slate-900 cursor-pointer rounded-full text-[20px] flex flex-col items-center justify-center">
                                <iconify-icon class="text-slate-800 dark:text-white text-xl dark:block hidden"
                                    id="moonIcon" icon="line-md:sunny-outline-to-moon-alt-loop-transition">
                                </iconify-icon>
                                <iconify-icon class="text-slate-800 dark:text-white text-xl dark:hidden block"
                                    id="sunIcon" icon="line-md:moon-filled-to-sunny-filled-loop-transition">
                                </iconify-icon>
                            </button>
                        </div>
                        <!-- END: TOggle Theme -->
                        <!-- BEGIN: Profile Dropdown -->
                        <!-- Profile DropDown Area -->
                        <div class="md:block hidden w-full">
                            <button
                                class="text-slate-800 dark:text-white focus:ring-0 focus:outline-none font-medium rounded-lg text-sm text-center inline-flex items-center"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="lg:h-8 lg:w-8 h-7 w-7 rounded-full flex-1 ltr:mr-[10px] rtl:ml-[10px]">
                                    <img src="<?=URL?>public/admin/images/all-img/user.png" alt="user"
                                        class="block w-full h-full object-cover rounded-full">
                                </div>
                                <span
                                    class="flex-none text-slate-600 dark:text-white text-sm font-normal items-center lg:flex hidden overflow-hidden text-ellipsis whitespace-nowrap"><?=ucwords($this->admin_user_name)?></span>
                                <svg class="w-[16px] h-[16px] dark:text-white hidden lg:inline-block text-base inline-block ml-[10px] rtl:mr-[10px]"
                                    aria-hidden="true" fill="none" stroke="currentColor" viewbox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Dropdown menu -->
                            <div
                                class="dropdown-menu z-10 hidden bg-white divide-y divide-slate-100 shadow w-44 dark:bg-slate-800 border dark:border-slate-700 !top-[23px] rounded-md overflow-hidden">
                                <ul class="py-1 text-sm text-slate-800 dark:text-slate-200">
                                    <li>
                                        <a href="<?= URL . admin_link ?>/logout"
                                            class="block px-4 py-2 hover:bg-slate-100 dark:hover:bg-slate-600 dark:hover:text-white font-inter text-sm text-slate-600 dark:text-white font-normal">
                                            <iconify-icon icon="heroicons-outline:logout"
                                                class="relative top-[2px] text-lg ltr:mr-1 rtl:ml-1"></iconify-icon>
                                            <span class="font-Inter">Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- END: Header -->
                        <button class="smallDeviceMenuController md:hidden block leading-0">
                            <iconify-icon class="cursor-pointer text-slate-900 dark:text-white text-2xl"
                                icon="heroicons-outline:menu-alt-3"></iconify-icon>
                        </button>
                        <!-- end mobile menu -->
                    </div>
                    <!-- end nav tools -->
                </div>
            </div>
        </div>
        <!-- END: Header -->
        <!-- END: Header -->



        <div class="content-wrapper transition-all duration-150 ltr:ml-[248px] rtl:mr-[248px]" id="content_wrapper">
            <div class="page-content">
