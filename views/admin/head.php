<!DOCTYPE html>
<html lang="zxx" dir="ltr" class="light">

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


        <!-- BEGIN: Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet">
        <!-- END: Google Font -->
        <!-- BEGIN: Theme CSS-->
        <link rel="stylesheet" href="<?=URL?>public/admin/css/rt-plugins.css">
        <link rel="stylesheet" href="<?=URL?>public/admin/css/app.css">
        <!-- END: Theme CSS-->
        <script src="<?=URL?>public/admin/js/settings.js" sync></script>
        <?php

        if (isset($this->head_file)) {

            foreach ($this->head_file as $headfile) {
                include 'views/'.$headfile;
            }
        }
        ?>
        <!-- <?php
            if (isset($this->js)) {

                foreach ($this->js as $js) {
                    echo '<script src="' . URL . 'views/' . $js . '"></script>';
                }
            }
        ?> -->

        <script type="text/javascript">
        const base_url = '<?=URL?>';
        const api_url = '<?=api_url?>';
        const admin_link = '<?= admin_link ?>';
        </script>
    </head>

    <body class=" font-inter dashcode-app" id="body_class">
        <main class="app-wrapper">
