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
        <div class="grid xl:grid-cols-1 grid-cols-1 gap-6">
            <div class="card">
                <header class=" card-header noborder">
                    <h4 class="card-title">Advanced Table Two
                    </h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="overflow-x-auto -mx-6 dashcode-data-table">
                        <span class=" col-span-8  hidden"></span>
                        <span class="  col-span-4 hidden"></span>
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden ">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class=" bg-slate-200 dark:bg-slate-700">
                                        <tr>

                                            <th scope="col" class=" table-th ">
                                                Id
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Order
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Customer
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Date
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Quantity
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Amount
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Status
                                            </th>

                                            <th scope="col" class=" table-th ">
                                                Action
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">

                                        <tr>
                                            <td class="table-td">1</td>
                                            <td class="table-td ">#951</td>
                                            <td class="table-td">
                                                <span class="flex">
                                                    <span class="w-7 h-7 rounded-full ltr:mr-3 rtl:ml-3 flex-none">
                                                        <img src="<?=URL?>public/admin/images/all-img/customer_1.png"
                                                            alt="1" class="object-cover w-full h-full rounded-full">
                                                    </span>
                                                    <span
                                                        class="text-sm text-slate-600 dark:text-slate-300 capitalize">Jenny
                                                        Wilson</span>
                                                </span>
                                            </td>
                                            <td class="table-td ">3/26/2022</td>
                                            <td class="table-td ">
                                                <div>
                                                    13
                                                </div>
                                            </td>
                                            <td class="table-td ">
                                                <div>
                                                    $1779.53
                                                </div>
                                            </td>
                                            <td class="table-td ">

                                                <div
                                                    class="inline-block px-3 min-w-[90px] text-center mx-auto py-1 rounded-[999px] bg-opacity-25 text-success-500 bg-success-500">
                                                    paid
                                                </div>

                                            </td>
                                            <td class="table-td ">
                                                <div class="flex space-x-3 rtl:space-x-reverse">
                                                    <button class="action-btn" type="button">
                                                        <iconify-icon icon="heroicons:eye"></iconify-icon>
                                                    </button>
                                                    <button class="action-btn" type="button">
                                                        <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                                    </button>
                                                    <button class="action-btn" type="button">
                                                        <iconify-icon icon="heroicons:trash"></iconify-icon>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
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
