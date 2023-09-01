    </div>
    </div>
    </div>

    <!-- BEGIN: Footer For Desktop and tab -->
    <footer class="md:block hidden" id="footer">
        <div
            class="site-footer px-6 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-300 py-4 ltr:ml-[248px] rtl:mr-[248px]">
            <div class="grid md:grid-cols-2 grid-cols-1 md:gap-5">
                <div class="text-center ltr:md:text-start rtl:md:text-right text-sm">
                    COPYRIGHT ©
                    <span id="thisYear"></span>
                    Securlists Admin, All rights Reserved
                </div>
                <div class="ltr:md:text-right rtl:md:text-end text-center text-sm">
                    Hand-crafted &amp; Made by
                    <a href="https://calienteitech.com" target="_blank" class="text-primary-500 font-semibold">
                        Caliente iTech
                    </a>
                </div>
            </div>
        </div>
    </footer>
    </div>
    </main>
    <!-- scripts -->
    <script src="<?=URL?>public/admin/js/jquery-3.6.0.min.js"></script>
    <script src="<?=URL?>public/admin/js/rt-plugins.js"></script>
    <script src="<?=URL?>public/admin/js/app.js"></script>
    <script src="<?=URL?>public/admin/js/alert.js"></script>
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
