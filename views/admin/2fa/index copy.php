<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <title>Securlists | Admin</title>
        <link rel="icon" type="image/png" href="<?=URL?>public/admin/images/logo/favicon.svg">
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
        <!-- <script src="<?=URL?>public/admin/js/settings.js" sync></script> -->
        <!-- END : Theme Config js-->
    </head>

    <body class="font-inter skin-default">
        <?php $udata = $this->user_data; ?>
        <div class="loginwrapper">
            <div class="lg-inner-column">
                <div class=" right-column relative">
                    <div class="inner-content h-full flex flex-col bg-white dark:bg-slate-800">
                        <div class="w-80 container h-full flex flex-col justify-center">
                            <div class="mobile-logo text-center mb-6 lg:hidden block">
                                <a href="<?=URL . admin_link?>">
                                    <img src="<?=URL?>public/admin/images/logo/logo.svg" alt="" class="mb-10 dark_logo">
                                    <img src="<?=URL?>public/admin/images/logo/logo-white.svg" alt=""
                                        class="mb-10 white_logo">
                                </a>
                            </div>
                            <div class="text-center 2xl:mb-10 mb-4">
                                <h4 class="font-medium"><a href="<?=URL?>index"><b>Securlists</b></a></h4>
                                <div class="text-slate-500 text-base">
                                    Two Factor Authentication
                                </div>
                            </div>
                            <?php $this->check_errors(); ?>
                            <!-- BEGIN: Login Form -->

                            <div class="card shadow-inner rounded-md bg-white dark:bg-slate-800 shadow-base">
                                <div class="card-body flex flex-col p-6">
                                    <form class="space-y-4" action="<?=URL?><?=admin_link?>/login/user_login"
                                        method="post" id="loginForm">
                                        <div class="col-lg-12">
                                            <p><b>Step 1.</b> Install this app from <a target="_blank"
                                                    href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Google
                                                    Play </a> store or <a target="_blank"
                                                    href="https://itunes.apple.com/us/app/google-authenticator/id388497605">App
                                                    Store</a></p>
                                            <p><b>Step 2.</b> Scan the below QR code by your Google Authenticator
                                                app, or you can
                                                add account manually </p>
                                            <p><b>Step 3.</b> <strong>Manually add Account:</strong><br>Account
                                                Name: <strong class="text-head">Profiler</strong> <br> Key:
                                                <strong class="text-head"><?=$udata["google_code"]?></strong>
                                            </p>
                                        </div>
                                        <div class="grid md:grid-cols-2 gap-6">
                                            <div class="text-center">
                                                <img class="img-thumbnail" src="<?=$udata['google_code_url']?>"
                                                    alt="QR code" width='150'>
                                            </div>
                                            <div class="mt-2">
                                                <div class="input-item form-group">
                                                    <label for="google2fa_code">Enter Google Authenticator Code</label>
                                                    <input id="google2fa_code" type="number"
                                                        class="input-bordered form-control" name="google2fa_code"
                                                        placeholder="Enter the Code to verify">
                                                </div>
                                                <input type="hidden" name="google2fa_secret"
                                                    value="<?=$udata["google_code"]?>">
                                                <input type="hidden" name="tx_hash" value="<?=$udata["tx_hash"]?>">
                                                <button type="submit" class="btn btn-primary mt-3">Confirm 2FA</button>
                                            </div>
                                        </div>
                                        <div class="grid mt-3">
                                            <div>
                                                <p class="text-danger"><strong>Note:</strong> If you lost your phone or
                                                    uninstall the
                                                    Google Authenticator app, then you will lost access of your account.
                                                </p>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- <header class="flex mb-5 items-center">
                                        <div class="flex-1">
                                            <div class="card-title font-Inter text-slate-900 dark:text-white">Card title
                                            </div>
                                            <div class="card-subtitle font-Inter">This is a subtitle</div>
                                        </div>
                                    </header>
                                    <div class="image-box mb-6">
                                        <img src="/assets/images/all-img/card-1.png" alt=""
                                            class="block w-full h-full object-cover rounded-md">
                                    </div>
                                    <div class="card-text h-full">
                                        <p>Lorem ipsum dolor sit amet, consec tetur adipiscing elit, sed do eiusmod
                                            tempor incididun ut .</p>
                                        <div class="mt-4 space-x-4 rtl:space-x-reverse">
                                            <a href="card.html" class="underline  btn-link">Learn more</a>
                                            <a href="card.html" class="underline  btn-link">Another link</a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
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
