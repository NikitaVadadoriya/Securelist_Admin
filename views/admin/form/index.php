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
                <li class="inline-block relative text-sm text-primary-500 font-Inter ">
                    Utility
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative top-[3px] text-slate-500 rtl:rotate-180"></iconify-icon>
                </li>
                <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                    Blank-Page</li>
            </ul>
        </div>
        <!-- END: BreadCrumb -->
        <div class="grid xl:grid-cols-2 grid-cols-1 gap-6">
            <div class="card">
                <div class="card-body flex flex-col p-6">
                    <header
                        class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                        <div class="flex-1">
                            <div class="card-title text-slate-900 dark:text-white">Horizontal Form</div>
                        </div>
                    </header>
                    <div class="card-text h-full ">
                        <form class="space-y-4">
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Full Name</label>
                                <input type="text" class="form-control" placeholder="Full Name">
                            </div>
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Email</label>
                                <input type="email" class="form-control" placeholder="Enter Your Email">
                            </div>
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Phone</label>
                                <input type="tel" class="form-control" placeholder="Phone Number" pattern="[0-9]">
                            </div>
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Password</label>
                                <input type="password" class="form-control"
                                    placeholder="8+ characters, 1 capitat letter">
                            </div>
                            <div class="input-area relative pl-28">
                                <label for="largeInput" class="inline-inputLabel">Select2</label>
                                <!-- <label for="select2basic" class="form-label">Basic Select</label> -->
                                <select name="select2basic" id="select2basic"
                                    class="select2 form-control w-full mt-2 py-2">
                                    <option value="option1"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 1
                                    </option>
                                    <option value="option2"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 2
                                    </option>
                                    <option value="option3"
                                        class=" inline-block font-Inter font-normal text-sm text-slate-600">Option 3
                                    </option>
                                </select>
                            </div>
                            <div class="checkbox-area ltr:pl-28 rtl:pr-28">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="hidden" name="checkbox">
                                    <span class="h-4 w-4 border flex-none border-slate-100 dark:border-slate-800 rounded inline-flex ltr:mr-3 rtl:ml-3 relative
                                        transition-all duration-150 bg-slate-100 dark:bg-slate-900">
                                        <img src="<?=URL?>public/admin/images/icon/ck-white.svg" alt=""
                                            class="h-[10px] w-[10px] block m-auto opacity-0">
                                    </span>
                                    <span class="text-slate-500 dark:text-slate-400 text-sm leading-6">Remember
                                        me</span>
                                </label>
                            </div>
                            <button class="btn inline-flex justify-center btn-dark ml-28">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
