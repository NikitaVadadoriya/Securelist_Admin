<?php
// $questions = $this->questions;
?>

<div class="transition-all duration-150 container-fluid" id="page_layout">
    <div id="content_layout">
        <!-- BEGIN: Breadcrumb -->
        <div class="mb-5">
            <ul class="m-0 p-0 list-none">
                <li class="inline-block relative top-[3px] text-base text-primary-500 font-Inter">
                    <a href="<?= URL . admin_link ?>">
                        <iconify-icon icon="heroicons-outline:home"></iconify-icon>
                        <iconify-icon icon="heroicons-outline:chevron-right"
                            class="relative text-slate-500 text-sm rtl:rotate-180"></iconify-icon>
                    </a>
                </li>
                <li class="inline-block relative text-sm text-primary-500 font-Inter">
                    App Variables
                    <iconify-icon icon="heroicons-outline:chevron-right"
                        class="relative top-[3px] text-slate-500 rtl:rotate-180"></iconify-icon>
                </li>
                <li class="inline-block relative text-sm text-slate-500 font-Inter dark:text-white">
                    Answers</li>
            </ul>
        </div>
        <!-- END: BreadCrumb -->
        <div class="jserror"></div>
        <?php $this->check_errors(); ?>
        <div class="card xl:col-span-2 mb-4">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Add Answers</div>
                    </div>
                </header>
                <div class="card-text h-full ">
                    <form class="space-y-4" id="add_answer_form">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <div class="input-area relative" id="subCategoryInput">
                                <label for="subCategory" class="form-label">Sub Category</label>
                                <select name="subCategory" id="subCategory"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>Select Sub Category</option>
                                    <?php
                                        foreach ($this->sub_categories as $ele) {
                                            ?>
                                    <option value="<?= $ele['id'] ?>"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        <?=$ele['name']?>
                                    </option>
                                    <?php
                                        }
?>
                                </select>
                            </div>
                            <div class="input-area relative">
                                <label for="question" class="form-label">Select Question</label>
                                <select name="question" id="question" class="select2 form-control w-full mt-2 py-2"
                                    required></select>
                            </div>
                            <div class="input-area relative" id="answerType">
                                <label for="answerTypeInput" class="form-label">Answer Type</label>
                                <input type="text" class="form-control" name="answerType" id="answerTypeInput" disabled>
                            </div>
                            <div class="input-area relative" id="answerName">
                                <label for="answerNameInput" class="form-label">Answer Name</label>
                                <input type="text" class="form-control" name="answerName" id="answerNameInput"
                                    placeholder="Enter Answer Name" required>
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
                    <h4 class="card-title">Answer List</h4>
                </header>
                <div class="card-body px-6 pb-6">
                    <div class="-mx-6 dashcode-data-table px-6">
                        <span class="col-span-8 hidden"></span>
                        <span class="col-span-4 hidden"></span>
                        <div class="block min-w-full align-middle">
                            <div class="overflow-hidden">
                                <table
                                    class="min-w-full divide-y divide-slate-100 table-fixed dark:divide-slate-700 data-table">
                                    <thead class="bg-slate-200 dark:bg-slate-700">
                                        <tr>
                                            <th scope="col" class="table-th">No.</th>
                                            <!-- <th scope="col" class="table-th">Question Name</th> -->
                                            <th scope="col" class="table-th">Answer Name</th>
                                            <th scope="col" class="table-th">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
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
    id="answer_modal" tabindex="-1" aria-labelledby="answer_modal" aria-hidden="true">
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
                <div class="jsmodalerror mt-1"></div>
                <!-- <form method="post" action="<?=URL . admin_link?>/answers/change_answer_status"> -->
                <form id="ChangeStateStatus">
                    <div class="p-6 space-y-4">
                        <div class="form-group">
                            <input type="hidden" name="ans_id" id="ans_id" class="form-control">
                            <input type="hidden" name="type" id="type">
                            <input type="text" id="msg" name="msg" class="form-control" placeholder="Enter here...">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-end p-3 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <button type="submit" name="yes" id="confirm_btn"
                            class="btn inline-flex justify-center text-white bg-black-500 btn-disabled">Delete</button>
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
                        Edit Answer
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
                <form id="EditAnswerData">
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-7">
                            <div class="input-area relative">
                                <label for="Editquestion" class="form-label">Select Question</label>
                                <input type="text" class="form-control" name="Editquestion" id="Editquestion"
                                    placeholder="Enter Answer Name" readonly>
                            </div>

                            <div class="input-area relative" id="answerName">
                                <label for="EditanswerNameInput" class="form-label"> Add New Answer Name</label>
                                <input type="text" class="form-control" name="EditanswerNameInput"
                                    id="EditanswerNameInput" placeholder="Enter Answer Name">
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-end p-6 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <button data-modal-hide="edit_modal" data-bs-dismiss="modal" type="button"
                            class="btn inline-flex justify-center btn-outline-dark">Cancel</button>
                        <button data-modal-hide="edit_modal" type="submit"
                            class="btn inline-flex justify-center text-white bg-black-500 btn-disabled">save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Modals -->
</div>
