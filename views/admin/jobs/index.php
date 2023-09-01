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
                    Job List
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
                        <div class="card-title text-slate-900 dark:text-white">Filter Jobs</div>
                        <small>You have the ability to filter jobs based on the business name, subcategories, and date
                            range.</small>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <form class="space-y-4" id="job_filter">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="input-area relative">
                                <label for="business" class="form-label">Business Name</label>
                                <select name="business" id="business" class="select2 form-control w-full mt-2 py-2">
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>
                                        Select Business</option>
                                    <option value="All"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        All</option>
                                    <?php foreach ($this->business_list as $data) { ?>
                                    <option value="<?= $this->encrypt_string($data['id']); ?>"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        <?= $data['full_name']; ?></option>
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
                                    id="date_range" data-mode="range" value="" type="text" readonly="readonly">
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
                    <h4 class="card-title">Posted Job List</h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="-mx-6 dashcode-data-table px-6">
                        <span class="col-span-8 hidden"></span>
                        <span class="col-span-4 hidden"></span>
                        <div class="block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table
                                    class="overflow-x-auto min-w-full border-collapse border border-slate-100 divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table whitespace-nowrap"
                                    id="example">
                                    <thead class="bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th">No.</th>
                                            <th scope="col" class="table-th">Business Name</th>
                                            <th scope="col" class="table-th">Subcategory Name</th>
                                            <th scope="col" class="table-th">Job Title</th>
                                            <th scope="col" class="table-th">Description</th>
                                            <th scope="col" class="table-th">Vacancy</th>
                                            <th scope="col" class="table-th">City</th>
                                            <th scope="col" class="table-th">Address</th>
                                            <th scope="col" class="table-th">Min Experience</th>
                                            <th scope="col" class="table-th">Min Qualification</th>
                                            <th scope="col" class="table-th">Job Type</th>
                                            <th scope="col" class="table-th">Applied</th>
                                            <th scope="col" class="table-th">Hired</th>
                                            <th scope="col" class="table-th">Created At</th>
                                            <th scope="col" class="table-th">Job Status</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        <?php
                                        foreach($this->today_jobs as $index => $data) {
                                            ?>
                                        <tr data-no.="<?= $index + 1 ?>" data-jid="<?= $data['id'] ?>">
                                            <td class="table-td"><?=$index+1?></td>
                                            <td class="table-td"><?= $data['business_name'] ?></td>
                                            <td class="table-td"><?= $data['sub_cat_name'] ?></td>
                                            <td class="table-td"><?= $data['title'] ?></td>
                                            <td class="table-td"><?= $data['description'] ?></td>
                                            <td class="table-td"><?= $data['vacancy'] ?></td>
                                            <td class="table-td"><?= $data['city_name'] ? $data['city_name'] : '-' ?>
                                            </td>
                                            <td class="table-td"><?= $data['address'] ? $data['address'] : '-' ?>
                                            </td>
                                            <td class="table-td">
                                                <?= $data['min_experience'] ? $data['min_experience'] : '-' ?></td>
                                            <td class="table-td">
                                                <?= $data['min_qualification'] ? $data['min_qualification'] : '-' ?>
                                            </td>
                                            <td class="table-td"><?= $data['job_type'] ?></td>
                                            <td class="table-td">
                                                <?php
                                            if($data['applied_user_count'] != 0) {
                                                ?>
                                                <button type="button" class="text-primary-500"
                                                    onclick="openUserListModal(this,1)">
                                                    <?= $data['applied_user_count'] ?>
                                                </button>
                                                <?php
                                            } else {
                                                echo '0';
                                            }
                                            ?>
                                            </td>
                                            <td class="table-td">
                                                <?php
                                            if($data['hired_user_count'] != 0) {
                                                ?>
                                                <button type="button" class="text-primary-500"
                                                    onclick="openUserListModal(this,2)">
                                                    <?= $data['hired_user_count'] ?>
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
                                                <?= $data['status'] == 0 ? '<span class="text-danger-500">Deleted</span>' : ($data['status'] == 1 ? '<span class="text-success-500">Active</span>' : ($data['status'] == 2 ? '<span class="text-primary-500">Draft</span>' : '-')) ?>
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
    id="user_list_modal" tabindex="-1" aria-labelledby="user_list_modal" aria-hidden="true">
    <!-- BEGIN: Modal -->
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                    <h3 class="text-xl font-medium text-white dark:text-white capitalize header">
                        Applid User Li
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
                        <div class="grid grid-cols-1" id="user_list"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modals -->
</div>
