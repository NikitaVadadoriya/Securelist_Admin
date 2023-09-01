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
                    All Users
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
                        <div class="card-title text-slate-900 dark:text-white">Registered Users</div>
                        <small>You have the ability to filter registered users based on the user name and date
                            range.</small>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <form id="users_filter_form" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="input-area relative">
                                <label for="user" class="form-label">User</label>
                                <select name="user" id="user" class="select2 form-control w-full mt-2 py-2">
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
                                <label for="date_range" class="form-label">Date Range (Registration Date)</label>
                                <input class="form-control py-2 flatpickr flatpickr-input active date_range"
                                    id="date_range" data-mode="range" type="text" name="date_range">
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
                <header class="card-header">
                    <h4 class="card-title">User's Info</h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="-mx-6 dashcode-data-table px-6">
                        <span class="col-span-8 hidden"></span>
                        <span class="col-span-4 hidden"></span>
                        <div class="block min-w-full align-middle px-6">
                            <div class="overflow-hidden">
                                <table
                                    class="overflow-x-auto min-w-full border-collapse border border-slate-100 divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table whitespace-nowrap"
                                    id="example">
                                    <thead class="bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th bg-slate-200"
                                                style="position: sticky; left: 0; z-index: 1;">No.</th>
                                            <th scope="col" class="table-th bg-slate-200"
                                                style="position: sticky; left: 50px; z-index: 1;">Name</th>
                                            <th scope="col" class="table-th">Profile</th>
                                            <th scope="col" class="table-th">Email</th>
                                            <th scope="col" class="table-th">Dial Code</th>
                                            <th scope="col" class="table-th">Phone Number</th>
                                            <th scope="col" class="table-th">Address</th>
                                            <th scope="col" class="table-th">Country</th>
                                            <th scope="col" class="table-th">Email Verification</th>
                                            <th scope="col" class="table-th">Phone Verification</th>
                                            <th scope="col" class="table-th">Jobseeker</th>
                                            <th scope="col" class="table-th">Registration Date</th>
                                            <th scope="col" class="table-th bg-slate-200 dark:bg-slate-700">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        <?php foreach ($this->today_data as $index => $data) { ?>
                                        <tr
                                            class="even:bg-slate-50 dark:even:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700">
                                            <td class="table-td bg-white sticky" style="left: 0;"><?=$index+1?></td>
                                            <td class="table-td bg-white sticky" style="left: 50px;">
                                                <?=$data["user_name"]?></td>
                                            <td class="table-td">
                                                <?php
                                                if($data['user_profile']) {
                                                    ?>
                                                <img src="<?=api_url . $data['user_profile']?>" alt="Profile"
                                                    class="data-table-img w-full h-full cursor-pointer"
                                                    onclick="openModal(this)">
                                                <?php
                                                } else {
                                                    echo '-';
                                                }
                                            ?>
                                            </td>
                                            <td class="table-td"><?=$data["user_email"]?></td>
                                            <td class="table-td"><?=$data["dial_code"]?></td>
                                            <td class="table-td"><?=$data["user_phone"]?></td>
                                            <td class="table-td"><?=$data["user_address"]?></td>
                                            <td class="table-td"><?=$data["country_name"]?></td>
                                            <td class="table-td">
                                                <?=$data["is_email_verified"] == 0 ? '<span class="text-danger-500">Pending</span>' : ($data["is_email_verified"] == 1 ? '<span class="text-success-500">Done</span>' : "-") ?>
                                            </td>
                                            <td class="table-td">
                                                <?=$data["is_phone_verified"] == 0 ? '<span class="text-danger-500">Pending</span>' : ($data["is_phone_verified"] == 1 ? '<span class="text-success-500">Done</span>' : "-") ?>
                                            </td>
                                            <td class="table-td">
                                                <?=$data["is_jobseeker"] == 0 ? "No" : ($data["is_jobseeker"] == 1 ? "Yes" : "-") ?>
                                            </td>
                                            <td class="table-td"><?= date('d/m/Y', strtotime($data["createdAt"])) ?>
                                            </td>
                                            <td class="table-td bg-white">
                                                <?php
                                                                                            if($data['isDeleted'] == 1) {
                                                                                                ?>
                                                <button class="btn btn-success btn-sm block w-full text-center"
                                                    type="button"
                                                    onclick="openConfirmationModal('<?= $data['id'] ?>', 1)">
                                                    Activate
                                                </button>
                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                <button class="btn btn-danger btn-sm block w-full text-center"
                                                    type="button"
                                                    onclick="openConfirmationModal('<?= $data['id'] ?>', 2)">
                                                    Block
                                                </button>
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
    id="user_modal" tabindex="-1" aria-labelledby="user_modal" aria-hidden="true">
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
                <form method="post" action="<?=URL . admin_link?>/users/change_user_status">
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
                            class="btn inline-flex justify-center text-white bg-black-500 btn-disabled">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modals -->
</div>

<!-- Image Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="imageModal" tabindex="-1" aria-labelledby="imageModal" aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                <div class="flex items-center justify-end rounded-t dark:border-slate-600">
                    <button type="button"
                        class="absolute top-0 right-0 p-2 m-2 text-slate-400 bg-black hover:text-slate-900 rounded-lg text-sm inline-flex items-center dark:hover:bg-slate-600 dark:hover:text-white"
                        data-bs-dismiss="modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="#000000" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <img class="modal-image object-cover w-full h-full" alt="Profile">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
