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
                    App Variables
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative top-[3px] text-slate-500 rtl:rotate-180"></iconify-icon>
                </li>
                <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                    Reject Reasons</li>
            </ul>
        </div>
        <!-- END: BreadCrumb -->
        <div class="jserror"></div>
        <?php $this->check_errors(); ?>
        <div class="card xl:col-span-2 mb-4">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Add New Reject Reason</div>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <form class="space-y-4" method="post" id="add_reject_reason_form"
                        action="<?=URL . admin_link?>/reject_reason/add_reject_reason">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="input-area relative">
                                <label for="rejectReason" class="form-label">Reject Reason</label>
                                <input type="text" class="form-control" name="rejectReason" id="rejectReason"
                                    placeholder="Enter reject reason">
                            </div>
                        </div>
                        <button type="submit" class="btn inline-flex justify-center btn-dark">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid xl:grid-cols-1 grid-cols-1 gap-6">
            <div class="card">
                <header class="card-header">
                    <h4 class="card-title">Reject Reason List</h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="-mx-6 dashcode-data-table px-6">
                        <span class="col-span-8 hidden"></span>
                        <span class="col-span-4 hidden"></span>
                        <div class="block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th">No.</th>
                                            <th scope="col" class="table-th">Reject reasons</th>
                                            <th scope="col" class="table-th">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        <?php foreach ($this->reject_reasons as $index => $data) { ?>
                                        <tr data-no.="<?= $index + 1 ?>"
                                            data-id="<?= $this->encrypt_string($data['id']) ?>"
                                            data-reason-name="<?= $data['reject_reason_name']; ?>">
                                            <td class="table-td">
                                                <?= $index + 1 ?>
                                            </td>
                                            <td class="table-td">
                                                <?= $data['reject_reason_name']; ?>
                                            </td>
                                            <td class="table-td ">
                                                <?php
                                                    if($data['isDeleted'] === 1) {
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
    id="reject_reason_modal" tabindex="-1" aria-labelledby="reject_reason_modal" aria-hidden="true">
    <!-- BEGIN: Modal -->
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-3 border-b rounded-t dark:border-slate-600 bg-black-500">
                    <h4 class="text-xl font-medium text-white dark:text-white capitalize header"></h4>
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
                <form method="post" action="<?=URL . admin_link?>/reject_reason/change_reject_reason_status">
                    <div class="p-6 space-y-4">
                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
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
                        Edit Reason
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
                <form id="EditRejectReason">
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-7">
                            <div class="input-area relative">
                                <label for="EditrejectReason" class="form-label">Reject Reason</label>
                                <input type="text" class="form-control" name="EditrejectReason" id="EditrejectReason"
                                    placeholder="Enter Reject Reason">
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
