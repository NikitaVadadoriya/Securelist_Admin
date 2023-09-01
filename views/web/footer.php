<?php
if (isset($this->fjs)) {

    foreach ($this->fjs as $js) {

        echo '<script  src="' . URL . 'public/web/js/' . $js . '"></script>';
    }
}

if (isset($this->sjs)) {

    foreach ($this->sjs as $js) {

        echo '<script  src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>

</body>

</html>
