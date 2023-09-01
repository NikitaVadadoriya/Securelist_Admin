<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Calienteitech | Admin</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php

        if (isset($this->head_file)) {

            foreach ($this->head_file as $headfile) {
                include 'views/'.$headfile;
            }
        }
        ?>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=URL?>public/admin/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?=URL?>public/admin/dist/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">




        <!-- <?php
            if (isset($this->js)) {

                foreach ($this->js as $js) {
                    echo '<script src="' . URL . 'views/' . $js . '"></script>';
                }
            }
        ?> -->

        <script type="text/javascript">
        var base_url = '<?=URL?>';
        var user_type = '<?=str_replace(' ', '', $this->utype)?>';
        </script>



    </head>

    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
        <!-- Site wrapper -->
        <div class="wrapper">
