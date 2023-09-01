<div class="transition-all duration-150 container-fluid" id="page_layout">
    <div id="content_layout">
        <!-- BEGIN: Breadcrumb -->
        <div class="mb-5">
            <ul class="m-0 p-0 list-none">
                <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                    <a href="<?= URL . admin_link ?>">
                        <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                        <iconify-icon icon="heroicons-outline:chevron-right"
                            class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                    </a>
                </li>
                <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                    Change Password</li>
            </ul>
        </div>
        <?php $this->check_errors(); ?>
        <!-- END: BreadCrumb -->
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header
                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Change Password</div>
                        </div>
                    </header>
                    <div class="card-text h-full ">
                        <form class="space-y-4" method="post"
                            action="<?=URL . admin_link?>/change_password/change_pass">
                            <div class="input-area">
                                <label class="block capitalize form-label" for="curr_pass">Current Password</label>
                                <div class="relative">
                                    <input type="password" name="curr_pass" id="curr_pass"
                                        class="form-control py-2 password">
                                    <button
                                        class="passIcon absolute top-2.5 right-3 text-slate-300 text-xl p-0 leading-none"
                                        type="button">
                                        <iconify-icon class="hidden" icon="heroicons-solid:eye-off">
                                        </iconify-icon>
                                        <iconify-icon class="inline-block" icon="heroicons-outline:eye"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="input-area">
                                <label class="block capitalize form-label" for="new_pass">New Password</label>
                                <div class="relative">
                                    <input type="password" name="new_pass" id="new_pass"
                                        class="form-control py-2 password">
                                    <button
                                        class="passIcon absolute top-2.5 right-3 text-slate-300 text-xl p-0 leading-none"
                                        type="button">
                                        <iconify-icon class="hidden" icon="heroicons-solid:eye-off">
                                        </iconify-icon>
                                        <iconify-icon class="inline-block" icon="heroicons-outline:eye"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                            <div class="input-area">
                                <label class="block capitalize form-label" for="confirm_pass">Confirm New
                                    Password</label>
                                <div class="relative">
                                    <input type="password" name="confirm_pass" id="confirm_pass"
                                        class="form-control py-2 password">
                                    <button
                                        class="passIcon absolute top-2.5 right-3 text-slate-300 text-xl p-0 leading-none"
                                        type="button">
                                        <iconify-icon class="hidden" icon="heroicons-solid:eye-off">
                                        </iconify-icon>
                                        <iconify-icon class="inline-block" icon="heroicons-outline:eye"></iconify-icon>
                                    </button>
                                </div>
                            </div>

                            <!-- <div class="input-area relative">
                                <label for="curr_pass" class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="curr_pass" id="curr_pass">
                                value="Admin@123#"
                            </div>
                            <div class="input-area relative">
                                <label for="new_pass" class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_pass" id="new_pass">
                                value="Admin@123"
                            </div>
                            <div class="input-area relative">
                                <label for="confirm_pass" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_pass" id="confirm_pass">
                                value="Admin@123"
                            </div> -->
                            <button class="btn inline-flex justify-center btn-dark">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
