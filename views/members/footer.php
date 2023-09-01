<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> 3.0.1
    </div>
    <strong>Copyright &copy; 2019 <a href="https://calienteitech.com">Caliente iTech</a>.</strong> All rights reserved.
</footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="<?=URL?>public/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=URL?>public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=URL?>public/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=URL?>public/admin/dist/js/demo.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnleDOCI9wy5Jg_yFLQygfZ2UyACj9n8I"></script>



<?php
if (isset($this->fjs)) {

    foreach ($this->fjs as $js) {

        echo '<script  src="' . URL . 'public/admin/plugins/' . $js . '"></script>';
    }
}

if (isset($this->sjs)) {

    foreach ($this->sjs as $js) {

        echo '<script  src="' . URL . 'views/' . $js . '"></script>';
    }
}

if (isset($this->onlineCDN)) {

    foreach ($this->onlineCDN as $js) {

        echo '<script  src="' . $js . '"></script>';
    }
}
?>
</body>

</html>
