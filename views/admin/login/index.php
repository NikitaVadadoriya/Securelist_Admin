<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <title>Securlists | Admin</title>
        <!-- <link rel="icon" type="image/png" href="<?=URL?>public/admin/images/logo/favicon.svg"> -->
        <link rel="apple-touch-icon" sizes="180x180" href="<?=URL?>public/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?=URL?>public/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?=URL?>public/favicon/favicon-16x16.png">
        <link rel="manifest" href="<?=URL?>public/favicon/site.webmanifest">
        <link rel="mask-icon" href="<?=URL?>public/favicon/safari-pinned-tab.svg" color="#009a99">
        <meta name="msapplication-TileColor" content="#009a99">
        <meta name="theme-color" content="#ffffff">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" href="<?=URL?>public/admin/css/rt-plugins.css">
        <link href="https://unpkg.com/aos@2.3.0/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
            integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="">
        <link rel="stylesheet" href="<?=URL?>public/admin/css/app.css">
        <!-- START : Theme Config js-->
        <script src="<?=URL?>public/admin/js/settings.js" sync></script>
        <!-- END : Theme Config js-->
    </head>

    <body class="font-inter skin-default">
        <div class="loginwrapper">
            <div class="lg-inner-column">
                <div class="right-column  relative">
                    <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                        <div class="auth-box h-full flex flex-col justify-center">
                            <div class="mobile-logo text-center mb-6 lg:hidden block">
                                <a href="<?=URL . admin_link?>">
                                    <img src="<?=URL?>public/admin/images/logo/logo.svg" alt="" class="mb-10 dark_logo">
                                    <img src="<?=URL?>public/admin/images/logo/logo-white.svg" alt=""
                                        class="mb-10 white_logo">
                                </a>
                            </div>
                            <div class="text-center 2xl:mb-10 mb-4">
                                <h4 class="font-medium">Admin Sign in</h4>
                                <div class="text-slate-500 text-base">
                                    Sign in to your account to start using Securlists
                                </div>
                            </div>
                            <?php $this->check_errors(); ?>
                            <!-- BEGIN: Login Form -->
                            <form class="space-y-4" action="<?=URL . admin_link?>/login/user_login" method="post"
                                id="loginForm">
                                <div class="fromGroup">
                                    <label for="username" class="block capitalize form-label">Username</label>
                                    <div class="relative">
                                        <input type="text" id="username" name="user_name" value="admin"
                                            class="form-control py-2" placeholder="Enter username">
                                    </div>
                                </div>
                                <div class="input-area">
                                    <label class="block capitalize form-label" for="password">Password</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" class="form-control py-2"
                                            value="Admin@123#" placeholder="Enter Password">
                                        <button id="passIcon"
                                            class="passIcon absolute top-2.5 right-3 text-slate-300 text-xl p-0 leading-none"
                                            type="button">
                                            <iconify-icon class="hidden" icon="heroicons-solid:eye-off"></iconify-icon>
                                            <iconify-icon class="inline-block" icon="heroicons-outline:eye">
                                            </iconify-icon>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" class="hiddens">
                                        <span
                                            class="text-slate-500 dark:text-slate-400 text-sm leading-6 capitalize pl-2">Keep
                                            me signed in</span>
                                    </label>
                                    <a class="text-sm text-slate-800 dark:text-slate-400 leading-6 font-medium"
                                        href="<?= URL . admin_link ?>/forgot_password">Forgot
                                        Password?
                                    </a>
                                </div>
                                <button class="btn btn-dark block w-full text-center" type="submit">Sign in</button>
                            </form>
                        </div>
                        <div class="auth-footer text-center">
                            Copyright 2021, Securlists All Rights Reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- scripts -->
        <script src="<?=URL?>public/admin/js/jquery-3.6.0.min.js"></script>
        <script src="<?=URL?>public/admin/js/rt-plugins.js"></script>
        <script src="<?=URL?>public/admin/js/app.js"></script>
        <script src="<?=URL?>public/admin/js/alert.js"></script>
        <script src="<?=URL?>/views/admin/login/js/default.js"></script>
    </body>

</html>
