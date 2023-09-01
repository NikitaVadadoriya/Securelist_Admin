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
                    Job Fee Packages
                </li>
            </ul>
        </div>
        <!-- END: BreadCrumb -->
        <div class="jserror"></div>
        <?php $this->check_errors(); ?>
        <div class="card xl:col-span-2 mb-4">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Add New Package</div>
                    </div>
                </header>
                <div class="card-text h-full">
                    <form class="space-y-4" method="post" id="add_job_fee_packages_form"
                        action="<?=URL . admin_link?>/job_fee_packages/add_job_fee_packages">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="input-area relative">
                                <label for="packageName" class="form-label">Package Name</label>
                                <input type="text" class="form-control" name="packageName" id="packageName"
                                    placeholder="Enter Package Name" required>
                            </div>
                            <div class="input-area relative">
                                <label for="credits" class="form-label">Credits</label>
                                <input type="number" class="form-control" name="credits" id="credits" min=1
                                    placeholder="Enter Credits" required>
                            </div>
                            <div class="input-area relative">
                                <label for="expireIn" class="form-label">Expiring Period (Month)</label>
                                <input type="number" class="form-control" name="expireIn" id="expireIn" min=1
                                    placeholder="Enter expiring periods" required>
                            </div>
                            <div class="basicRadio input-area relative">
                                <label class="form-label">Allowed Candidates</label>
                                <!-- <input type="number" class="form-control" name="candidates" id="candidates" min=1
                                    placeholder="Enter Candidates" required> -->

                                <label class="flex items-center cursor-pointer" for="unlimited_candidate">
                                    <input type="radio" class="hidden" value="unlimited_candidate"
                                        name="candidates_radio" id="unlimited_candidate">
                                    <span
                                        class="flex-none bg-white dark:bg-slate-500 rounded-full border inline-flex ltr:mr-2 rtl:ml-2 relative transition-all
                                        duration-150 h-[16px] w-[16px] border-slate-400 dark:border-slate-600 dark:ring-slate-700"></span>
                                    <span class="text-secondary-500 text-sm leading-6 capitalize">Unlimited</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" class="hidden" value="limited_candidate"
                                        name="candidates_radio">
                                    <span
                                        class="flex-none bg-white dark:bg-slate-500 rounded-full border inline-flex ltr:mr-2 rtl:ml-2 relative transition-all
                                        duration-150 h-[16px] w-[16px] border-slate-400 dark:border-slate-600 dark:ring-slate-700"></span>
                                    <input type="number" class="form-control" name="candidates" id="candidates" min=1
                                        placeholder="Enter Candidates">
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn inline-flex justify-center btn-dark">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-6">
            <div class="card">
                <header class="card-header noborder">
                    <h4 class="card-title">Advanced Table Two</h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="-mx-6 dashcode-data-table px-6">
                        <span class="col-span-8 hidden"></span>
                        <span class="col-span-4 hidden"></span>
                        <div class="block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th">No.</th>
                                            <th scope="col" class="table-th">Package Name</th>
                                            <th scope="col" class="table-th">Credits</th>
                                            <th scope="col" class="table-th">Allowed Candidates</th>
                                            <th scope="col" class="table-th">Expiring Period (Month)</th>
                                            <th scope="col" class="table-th">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        <?php foreach ($this->job_fee_packages as $index => $data) { ?>
                                        <tr data-no.="<?= $index + 1 ?>"
                                            data-pid="<?= $this->encrypt_string($data['id']) ?>"
                                            data-package-name="<?= $data['package_name']; ?>"
                                            data-credits="<?= $data['credits']; ?>"
                                            data-candidates="<?= $data['candidates']; ?>"
                                            data-expiring-month="<?= $data['expired_month']; ?>">
                                            <td class="table-td"><?= $index + 1 ?></td>
                                            <td class="table-td"><?= $data['package_name']; ?></td>
                                            <td class="table-td">
                                                <?= $data['credits']; ?>
                                            </td>
                                            <td class="table-td">
                                                <?= $data['candidates'] ? $data['candidates'] : ($data['candidates'] == null ? 'Unlimited' : '-')  ?>
                                            </td>
                                            <td class="table-td"><?= $data['expired_month']; ?></td>
                                            <td class="table-td ">
                                                <?php
                                                    if($data['isDeleted'] == 1) {
                                                        ?>
                                                <button type="button"
                                                    onclick="handleBtnClick('<?= $this->encrypt_string($data['id']) ?>', 1)">
                                                    Activate
                                                </button>
                                                <?php
                                                    } else {
                                                        ?>
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <button class="action-btn" type="button"
                                                        onclick="openEditModal(this)">
                                                        <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                    </button>
                                                    <button class="action-btn" type="button"
                                                        onclick="handleBtnClick('<?= $this->encrypt_string($data['id']) ?>', 2)">
                                                        <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                    </button>
                                                </div>
                                                <?php
                                                    }
                                            ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="job_fee_packages_modal" tabindex="-1" aria-labelledby="job_fee_packages_modal" aria-hidden="true">
    <!-- BEGIN: Modal -->
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-3 border-b rounded-t dark:border-slate-600 bg-black-500">
                    <h4 class="text-xl font-medium text-white dark:text-white capitalize header">
                        Type "YES" to Delete this Package
                    </h4>
                    <button type="button"
                        class="text-slate-400 bg-transparent hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-slate-600 dark:hover:text-white"
                        data-bs-dismiss="modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form method="post" action="<?=URL . admin_link?>/job_fee_packages/change_job_fee_packages_status">
                    <div class="p-6 space-y-4">
                        <div class="form-group">
                            <input type="hidden" name="pid" id="pid">
                            <input type="hidden" name="type" id="type">
                            <input type="text" id="msg" name="msg" class="form-control" placeholder="Enter here...">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-end p-3 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <button type="submit" id="confirm_btn"
                            class="btn inline-flex justify-center text-white bg-black-500">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modals -->
</div>

<!-- edit model -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="edit_modal" tabindex="-1" aria-labelledby="edit_model" aria-hidden="true">
    <!-- BEGIN: Modal -->
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                    <h3 class="text-xl font-medium text-white dark:text-white capitalize">
                        Edit Job Fee Packages
                    </h3>
                    <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm p-1.5 ml-auto inline-flex
                            items-center dark:hover:bg-slate-600 dark:hover:text-white" data-bs-dismiss="modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="#ffffff" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10
                                    11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="jsmodalerror mt-1"></div>
                <form id="EditJobPackageData">
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-7">
                            <div class="input-area relative">
                                <label for="EditPackageName" class="form-label">Package Name</label>
                                <input type="text" class="form-control" name="PackageName" id="EditPackageName"
                                    placeholder="Enter Package Name" required>
                            </div>
                            <div class="input-area relative">
                                <label for="EditCredits" class="form-label">credits</label>
                                <input type="number" class="form-control" name="EditCredits" id="EditCredits" min=1
                                    placeholder="Enter Credits" required>
                            </div>
                            <div class="input-area relative">
                                <label for="EditExpireIn" class="form-label">Expiring Period (Month)</label>
                                <input type="number" class="form-control" name="EditExpireIn" id="EditExpireIn" min=1
                                    placeholder="Enter expiring periods" required>
                            </div>
                            <div class="basicRadio input-area relative">
                                <label class="form-label">Allowed Candidates</label>
                                <!-- <input type="number" class="form-control" name="candidates" id="candidates" min=1
                                    placeholder="Enter Candidates" required> -->

                                <label class="flex items-center cursor-pointer" for="edit_unlimited_candidate">
                                    <input type="radio" class="hidden" value="unlimited_candidate"
                                        name="edit_candidates_radio" id="edit_unlimited_candidate">
                                    <span
                                        class="flex-none bg-white dark:bg-slate-500 rounded-full border inline-flex ltr:mr-2 rtl:ml-2 relative transition-all
                                        duration-150 h-[16px] w-[16px] border-slate-400 dark:border-slate-600 dark:ring-slate-700"></span>
                                    <span class="text-secondary-500 text-sm leading-6 capitalize">Unlimited</span>
                                </label>
                                <label class="flex items-center cursor-pointer" for="edit_limited_candidate">
                                    <input type="radio" class="hidden" value="limited_candidate"
                                        name="edit_candidates_radio" id="edit_limited_candidate">
                                    <span
                                        class="flex-none bg-white dark:bg-slate-500 rounded-full border inline-flex ltr:mr-2 rtl:ml-2 relative transition-all
                                        duration-150 h-[16px] w-[16px] border-slate-400 dark:border-slate-600 dark:ring-slate-700"></span>
                                    <input type="number" class="form-control" name="EditCandidates" id="EditCandidates"
                                        min=1 placeholder="Enter Candidates">
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <button data-modal-hide="edit_modal" data-bs-dismiss="modal" type="button"
                            class="btn inline-flex justify-center btn-outline-dark">Cancel</button>
                        <button data-modal-hide="edit_modal" type="submit"
                            class="btn inline-flex justify-center text-white bg-black-500 btn-disabled">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modals -->
</div>
