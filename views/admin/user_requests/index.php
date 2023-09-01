<?php
// $country = $this->country;
?>

<div class="transition-all duration-150 container-fluid" id="page_layout">
    <div id="content_layout">
        <!-- BEGIN: Breadcrumb -->
        <div class="mb-5">
            <ul class="m-0 p-0 list-none">
                <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter ">
                    <a href="index.html">
                        <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                        <iconify-icon icon="heroicons-outline:chevron-right"
                            class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                    </a>
                </li>
                <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                    User requests
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
                        <div class="card-title text-slate-900 dark:text-white">Filter Request</div>
                        <small>You have the ability to filter request based on the user name, subcategories, and date
                            range.</small>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <form class="space-y-4" id="user_request_filter">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="input-area relative">
                                <label for="userName" class="form-label">User</label>
                                <select name="userName" id="userName" class="select2 form-control w-full mt-2 py-2">
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>
                                        Select User</option>
                                    <option value="All"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        All</option>
                                    <?php foreach ($this->users as $data) { ?>
                                    <option value="<?= $data['id']; ?>"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        <?= $data['user_name']; ?></option>
                                    <?php
                                    }
?>
                                </select>
                            </div>
                            <div class="input-area relative">
                                <label for="subCategory" class="form-label">Sub category</label>
                                <select name="subCategory" id="subCategory"
                                    class="select2 form-control w-full mt-2 py-2">
                                    <option selected disabled
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        Select Category
                                    </option>
                                    <option value="All"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        All</option>
                                    <?php foreach ($this->sub_cat_list as $data) { ?>
                                    <option value="<?= $this->encrypt_string($data['id']); ?>"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        <?= $data['name']; ?></option>
                                    <?php
                                    }
?>
                                </select>
                            </div>

                            <div class="input-area relative">
                                <label for="date_range" class="form-label">Date Range (Created At)</label>
                                <input class="form-control py-2 flatpickr flatpickr-input active date_range"
                                    id="date_range" data-mode="range" value="" type="text">
                            </div>
                        </div>
                        <button type="submit"
                            class="btn inline-flex justify-center btn-dark btn-disabled">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-6">
            <div class="card">
                <header class="card-header noborder">
                    <h4 class="card-title">User Requests
                    </h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="-mx-6 dashcode-data-table px-6">
                        <span class="col-span-8  hidden"></span>
                        <span class="col-span-4 hidden"></span>
                        <div class="block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table
                                    class="overflow-x-auto min-w-full border-collapse border border-slate-100 divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table whitespace-nowrap"
                                    id="example">
                                    <thead class="bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th">No.</th>
                                            <th scope="col" class="table-th">User Name</th>
                                            <th scope="col" class="table-th">Service Name</th>
                                            <th scope="col" class="table-th">Requested Answers Details</th>
                                            <th scope="col" class="table-th">Hired Business</th>
                                            <th scope="col" class="table-th">Hired Date</th>
                                            <th scope="col" class="table-th">Responded Businesses</th>
                                            <th scope="col" class="table-th">Rejected Business</th>
                                            <th scope="col" class="table-th">Created At</th>
                                            <th scope="col" class="table-th">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        <?php
                                        foreach($this->today_requests as $index => $data) {
                                            ?>
                                        <tr data-no.="<?= $index + 1 ?>" data-rid="<?= $data['id'] ?>">
                                            <td class="table-td"><?=$index+1?></td>
                                            <td class="table-td"><?= $data['user_name'] ?></td>
                                            <td class="table-td">
                                                <?= $data['sub_cat_name'] ?>
                                            </td>
                                            <td class="table-td">
                                                <button type="button" class="text-primary-500 btn-disabled"
                                                    onclick="openRequestAnswerModal(this)"> View Answers
                                                </button>
                                            </td>
                                            <td class="table-td">
                                                <?= $data['business_name'] ? $data['business_name'] : '-' ?>
                                            </td>
                                            <td class="table-td">
                                                <?= $data['hired_date'] ? date('d/m/Y', strtotime($data['hired_date'])) : '-' ?>
                                            </td>
                                            <td class="table-td">
                                                <?php
                                            if($data['responded_business'] != 0) {
                                                ?>
                                                <button type="button" class="text-primary-500 btn-disabled"
                                                    onclick="openBusinessListModal(this,1)">
                                                    <?= $data['responded_business'] ?>
                                                </button>
                                                <?php
                                            } else {
                                                echo '0';
                                            }
                                            ?>
                                            </td>
                                            <td class="table-td">
                                                <?php
                                            if($data['rejected_business'] != 0) {
                                                ?>
                                                <button type="button" class="text-primary-500 btn-disabled"
                                                    onclick="openBusinessListModal(this,2)">
                                                    <?= $data['rejected_business'] ?>
                                                </button>
                                                <?php
                                            } else {
                                                echo '0';
                                            }
                                            ?>
                                            </td>
                                            <td class="table-td"><?= date('d/m/Y', strtotime($data['createdAt'])) ?>
                                            </td>
                                            <td class="table-td">
                                                <?= $data['status'] == 0 ? '<span class="text-danger-500">Deleted</span>' : ($data['status'] == 1 ? '<span class="text-primary-500">Intiated</span>' : ($data['status'] == 2 ? '<span class="text-success-500">Hired</span>' : '-')) ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }
?>
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

<!-- edit model -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="requestAnswers_modal" tabindex="-1" aria-labelledby="requestAnswers_modal" aria-hidden="true">
    <!-- BEGIN: Modal -->
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                    <h3 class="text-xl font-medium text-white dark:text-white capitalize header">
                        Requested Question Answers List
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
                <form>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-7" id="qa_list"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modals -->
</div>
