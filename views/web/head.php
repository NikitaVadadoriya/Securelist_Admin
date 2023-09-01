<!doctype html>

<head>


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
</head>
