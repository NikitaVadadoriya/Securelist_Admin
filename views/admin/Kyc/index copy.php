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
                    KYC
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative top-[3px] text-slate-500 rtl:rotate-180"></iconify-icon>
                </li>
                <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                    All</li>
            </ul>
        </div>
        <!-- END: BreadCrumb -->
        <?php $this->check_errors(); ?>
        <div class="card xl:col-span-2 mb-4">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Filter KYC Request</div>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <form id="kyc_req_filter_form" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="input-area relative">
                                <label for="business" class="form-label">Business name</label>
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
                                <label for="date_range" class="form-label">Range</label>
                                <input class="form-control py-2 flatpickr flatpickr-input active date_range"
                                    id="date_range" data-mode="range" type="text" name="date_range">
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
                    <h4 class="card-title"> Business KYC Info</h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="-mx-6 dashcode-data-table px-6">
                        <span class="col-span-8  hidden"></span>
                        <span class="col-span-4 hidden"></span>
                        <div class="block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table
                                    class="overflow-x-auto min-w-full border-collapse border border-slate-100 divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table whitespace-nowrap"
                                    id="example">
                                    <thead class="bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th bg-slate-200"
                                                style="position: sticky; left: 0; z-index: 1;">No.</th>
                                            <th scope="col" class="table-th bg-slate-200"
                                                style="position: sticky; left: 50px; z-index: 1; ">Business Name</th>
                                            <th scope="col" class="table-th">Company Name</th>
                                            <th scope="col" class="table-th">Company Licence Number</th>
                                            <th scope="col" class="table-th">Licence expire</th>
                                            <th scope="col" class="table-th">Licence proof</th>
                                            <th scope="col" class="table-th">Business Running Since</th>
                                            <th scope="col" class="table-th">Business insured</th>
                                            <th scope="col" class="table-th">Insurance Proof</th>
                                            <!-- <th scope="col" class="table-th">Member of any Security or Law Enforcement
                                                agency</th> -->
                                            <th scope="col" class="table-th">Other Membership</th>
                                            <th scope="col" class="table-th">Company website</th>
                                            <th scope="col" class="table-th">Business Hours</th>
                                            <th scope="col" class="table-th">Created At</th>
                                            <th scope="col" class="table-th bg-slate-200 dark:bg-slate-700">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        <?php foreach ($this->kyc as $index => $data) { ?>
                                        <tr data-no.="<?=$index+1?>" data-kid="<?= $this->encrypt_string($data['id'])?>"
                                            data-bid="<?= $this->encrypt_string($data['business_id'])?>"
                                            data-business-name=" Sv Solution" data-company-name="<?=$data['name']?>"
                                            data-company-licence-number="<?=$data['licence_number']?>"
                                            data-licence-expire="27-05-2023"
                                            data-licence-proof="<?= $data['licence_proof'] ? api_url . $data['licence_proof'] : "-"?>"
                                            data-business-running-since="<?= $data['running_since'] ?>"
                                            data-business-insured="<?= $data['insured'] == 1 ? "Yes" : ($data['insured'] == 2 ? "No" : "-") ?>"
                                            data-business-proof="<?= $data['insurance_proof'] ? api_url . $data['insurance_proof'] : "-"?>"
                                            data-member-of-SoLEA="<?=$data['other_membership'] == 0 ? 'No' : 'Yes'?>"
                                            data-company-website="<?= $data['website'] ? $data['website'] : "-" ?>"
                                            data-business-hours="8">

                                            <td class="table-td bg-white sticky" style="left: 0;">
                                                <?=$index+1?></td>
                                            <td class="table-td bg-white sticky" style="left: 50px;">
                                                <?= $data['business_name'] ?></td>
                                            <td class="table-td"><?=$data['name']?></td>
                                            <td class="table-td">
                                                <?= $data['licence_number'] ? $data['licence_number'] : "-"?>
                                            </td>
                                            <td class="table-td">
                                                <?= date('d/m/Y', strtotime($data['licence_expiry'])) ?></td>
                                            <td class="table-td">
                                                <?php
                        if($data['licence_proof']) {
                            ?>
                                                <img src="<?=api_url . $data['licence_proof']?>" alt="Licence Proof"
                                                    class="object-cover w-full h-full" onclick="openModal(this)">
                                                <?php
                        } else {
                            echo '-';
                        }
                                            ?>
                                            </td>
                                            <td class="table-td"><?= $data['running_since'] ?></td>
                                            <td class="table-td">
                                                <?= $data['insured'] == 1 ? "Yes" : ($data['insured'] == 2 ? "No" : "-") ?>
                                            </td>
                                            <td class="table-td">
                                                <?php
                                                if($data['insurance_proof']) {
                                                    ?>
                                                <img src="<?=api_url . $data['insurance_proof']?>" alt="Insurance Proof"
                                                    class="object-cover w-full h-full" onclick="openModal(this)">
                                                <?php
                                                } else {
                                                    echo '-';
                                                }
                                            ?>
                                            </td>
                                            <td class="table-td"><?=$data['other_membership'] == 0 ? 'No' : 'Yes'?></td>
                                            <td class="table-td">
                                                <?php
                                            if($data['website']) {
                                                ?>
                                                <a href="<?=$data['website']?>" target="_blank"
                                                    rel="noopener noreferrer"><?=$data['website']?></a>
                                                <?php
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                            </td>
                                            <td class="table-td">
                                                <?=$data['business_hours'] ? $data['business_hours'] . ' Hours' : '-'?>
                                            </td>
                                            <td class="table-td">
                                                <?= date('d/m/Y', strtotime($data['createdAt'])) ?>
                                            </td>
                                            <td class="table-td bg-white">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <button class="btn btn-success btn-sm block w-full text-center"
                                                        type="button" onclick="openKycModal(this, 1)">
                                                        Approve
                                                    </button>
                                                    <button class="btn btn-danger btn-sm block w-full text-center"
                                                        type="button" onclick="openKycModal(this, 2)">
                                                        Reject
                                                    </button>
                                                </div>
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
    id="reject_kyc_modal" tabindex="-1" aria-labelledby="reject_kyc_modal" aria-hidden="true">
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
                <div class="jsmodalerror mt-1"></div>
                <!-- Modal body -->
                <form method="post" action="<?= URL . admin_link ?>/kyc/reject_kyc">
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-7">
                            <div class="input-area relative">
                                <!-- <label for="msg" class="form-label">Question</label> -->
                                <input type="text" id="msg" name="msg" class="form-control" placeholder="Enter here..."
                                    required>
                                <input type="hidden" name="kyc_id" id="kyc_id">
                                <input type="hidden" name="biz_id" id="biz_id">
                            </div>
                            <div class="input-area relative">
                                <label for="reject_reason" class="form-label">KYC Reject Reason</label>
                                <select name="reject_reason" id="reject_reason"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>Select Reject Reason</option>
                                    <?php
                                        foreach ($this->reject_reasons as $ele) {
                                            ?>
                                    <option value="<?= $this->encrypt_string($ele['id']) ?>"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        <?=$ele['reject_reason_name']?>
                                    </option>
                                    <?php
                                        }
                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-end p-3 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <button type="submit" name="yes" id="confirm_btn"
                            class="btn inline-flex justify-center text-white bg-black-500">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modals -->
</div>

<!-- Kyc info model -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="kycInfo_modal" tabindex="-1" aria-labelledby="kycInfo_modal" aria-hidden="true">
    <!-- BEGIN: Modal -->
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-5 border-b rounded-t dark:border-slate-600 bg-black-500">
                    <h3 class="text-xl font-medium text-white dark:text-white capitalize">
                        KYC
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
                <form class="BusinessKycData" method="post" action="<?= URL . admin_link ?>/kyc/approve_kyc">
                    <div class="p-6 space-y-6">
                        <h6 class="text-base text-slate-600 dark:text-white leading-6">
                            Are you sure you want to approve this business KYC ?
                        </h6>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <input type="hidden" name="kid" id="kid">
                        <input type="hidden" name="bid" id="bid">
                        <button data-modal-hide="kycInfo_modal" type="submit"
                            class="btn inline-flex justify-center text-white bg-black-500">Approve</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Modals -->

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
                    <img class="modal-image object-cover w-full h-full" src="1.jpg" alt="slider image">
                </div>
            </div>
        </div>
    </div>
</div>
</div>
