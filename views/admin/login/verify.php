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

    <body class=" font-inter skin-default">
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
                            <?php $this->check_errors(); ?>
                            <!-- BEGIN: Login Form -->
                            <form class="space-y-4" action="<?=URL . admin_link?>/login/user_login" method="post">
                                <div class="fromGroup">
                                    <label class="block capitalize form-label" id="user_2fa_code">Enter Google
                                        Authentication Code</label>
                                    <div class="relative">
                                        <input type="number" class="form-control" name="user_2fa_code"
                                            id="user_2fa_code" placeholder="Enter GA Code here">
                                    </div>
                                </div>
                                <button class="btn btn-dark block w-full text-center">Verify</button>
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
