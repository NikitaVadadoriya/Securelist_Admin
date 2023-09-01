<?php
$questions = $this->questions;
$subCategories = $this->sub_categories;

echo "<script>var sub_categories = ".json_encode($subCategories).";</script>";

?>

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
                    Questions</li>
            </ul>
        </div>
        <!-- END: BreadCrumb -->
        <div class="jserror"></div>
        <?php $this->check_errors(); ?>
        <div class="card xl:col-span-2 mb-4">
            <div class="card-body flex flex-col p-6">
                <header class="flex mb-5 items-center border-b border-slate-100 dark:border-slate-700 pb-5 -mx-6 px-6">
                    <div class="flex-1">
                        <div class="card-title text-slate-900 dark:text-white">Add New Question</div>
                    </div>
                </header>
                <div class="card-text h-full">
                    <form class="space-y-4" method="post" id="AddQuestionData"
                        action="<?=URL . admin_link?>/questions/add_questions">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                            <!-- <div class="input-area relative">
                                <label for="questionType" class="form-label">Question Type</label>
                                <select name="questionType" id="questionType"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option disabled class="inline-block font-Inter font-normal text-sm text-slate-600">
                                        Select Question Type</option>
                                    <option value="Common"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Common
                                    </option>
                                    <option value="Business Specific"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Business
                                        Specific
                                    </option>
                                </select>
                            </div> -->
                            <!-- <div class="input-area relative" id="subCategoryInput" style="display: none;"> -->
                            <div class="input-area relative" id="subCategoryInput">
                                <label for="subCategory" class="form-label">Sub Category</label>
                                <select name="subCategory" id="subCategory"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>Select Sub Category</option>
                                    <?php
                                        foreach ($subCategories as $ele) {
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
                                <label for="inputType" class="form-label">Input Type</label>
                                <select name="inputType" id="inputType" class="select2 form-control w-full mt-2 py-2"
                                    required>
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>Select Input Type</option>
                                    <option value="Text"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Text
                                    </option>
                                    <option value="Radio"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Radio
                                    </option>
                                    <option value="Checkbox"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Checkbox
                                    </option>
                                    <option value="Dropdown"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Dropdown
                                    </option>
                                    <option value="Datepicker"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Datepicker
                                    </option>
                                </select>
                            </div>
                            <div class="input-area relative">
                                <label for="question" class="form-label">Question</label>
                                <input type="text" class="form-control" name="question" id="question"
                                    placeholder="Enter Question" required>
                            </div>
                            <div class="input-area relative">
                                <label for="questionOrder" class="form-label">Question Order</label>
                                <select name="questionOrder" id="questionOrder"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>
                                        Select Question Order</option>
                                    <?php
for($i=0; $i <= count($questions); $i++) {
    ?>
                                    <option value="<?= $i+1 ?>"><?= $i+1; ?></option>
                                    <?php
}
?>
                                </select>
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
                    <h4 class="card-title">Question List</h4>
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
                                            <!-- <th scope="col" class="table-th">Type</th> -->
                                            <th scope="col" class="table-th">Sub Category</th>
                                            <th scope="col" class="table-th">Question Name</th>
                                            <th scope="col" class="table-th">Input type</th>
                                            <th scope="col" class="table-th">Question Order</th>
                                            <th scope="col" class="table-th">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-slate-100 dark:bg-slate-800 dark:divide-slate-700">
                                        <?php foreach ($questions as $index => $data) { ?>
                                        <tr data-no.="<?= $index + 1 ?>"
                                            data-qid="<?= $this->encrypt_string($data['id']) ?>"
                                            data-question-type="<?= $data['question_type_name']; ?>"
                                            data-subcategory="<?= $data['sub_category_id'] ? $this->encrypt_string($data["sub_category_id"]) : "-"; ?>"
                                            data-question="<?= $data['question_name']; ?>"
                                            data-input-type="<?= $data['input_type_name']; ?>"
                                            data-questionorder="<?= $data['question_order'] ? $data['question_order'] : '-' ?>">
                                            <td class="table-td"><?= $index + 1 ?></td>
                                            <!-- <td class="table-td">
                                                <?= $data['question_type_name']; ?>
                                            </td> -->
                                            <td class="table-td">
                                                <?= $data['sub_cat_name'] ? $data["sub_cat_name"] : "-"; ?>
                                            </td>
                                            <td class="table-td"><?= $data['question_name']; ?></td>
                                            <td class="table-td"><?= $data['input_type_name']; ?></td>
                                            <td class="table-td">
                                                <?= $data['question_order'] ? $data["question_order"] : "-"; ?></td>
                                            <td class="table-td">
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

<!-- Delete & Activate Modal -->
<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="question_modal" tabindex="-1" aria-labelledby="question_modal" aria-hidden="true">
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
                <form method="post" id="dlt_modal" action="<?= URL . admin_link ?>/questions/change_question_status">
                    <div class="p-6 space-y-4">
                        <div class="form-group">
                            <input type="hidden" name="qid" id="qid" class="form-control">
                            <input type="hidden" name="type" id="type">
                            <input type="text" id="msg" name="msg" class="form-control" placeholder="Enter here...">
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex items-center justify-end p-3 space-x-2 border-t border-slate-200 rounded-b dark:border-slate-600">
                        <button data-bs-dismiss="modal" type="submit" name="yes" id="confirm_btn"
                            class="btn inline-flex justify-center text-white bg-black-500">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END: Modals -->
</div>

<!-- Edit model -->
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
                        Edit Question
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
                <form id="EditQuestionData">
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-7">
                            <!-- <div class="input-area relative">
                                <label for="EditquestionType" class="form-label">Question Type</label>
                                <select name="EditquestionType" id="EditquestionType"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option value="Common"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Common
                                    </option>
                                    <option value="Business Specific"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Business
                                        Specific
                                    </option>
                                </select>
                                <p class="text-danger-500 col-12" id="err_questionType"></p>
                            </div> -->
                            <!-- <div class="input-area relative" id="EditsubCategoryInput" style="display: none;"> -->
                            <div class="input-area relative" id="EditsubCategoryInput">
                                <label for="EditsubCategory" class="form-label">Sub Category</label>
                                <select name="EditsubCategory" id="EditsubCategory"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>Select Sub Category</option>
                                    <?php
                                        foreach ($subCategories as $ele) {
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
                                <label for="EditInputType" class="form-label">Input Type</label>
                                <select name="EditInputType" id="EditInputType"
                                    class="select2 form-control w-full mt-2 py-2" required>
                                    <option class="inline-block font-Inter font-normal text-sm text-slate-600" selected
                                        disabled>
                                        Select Input Type</option>
                                    <option value="Text"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Text
                                    </option>
                                    <option value="Radio"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Radio
                                    </option>
                                    <option value="Checkbox"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Checkbox
                                    </option>
                                    <option value="Dropdown"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Dropdown
                                    </option>
                                    <option value="Datepicker"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600">Datepicker
                                    </option>
                                </select>
                            </div>
                            <div class="input-area relative">
                                <label for="question" class="form-label">Question</label>
                                <input type="text" class="form-control" name="question" id="Editquestion"
                                    placeholder="Enter Question" required>
                            </div>
                            <div class="input-area relative" id="questionOrderInput">
                                <label for="questionOrder" class="form-label">Question Order</label>
                                <select name="subCategory" id="EditquestionOrder"
                                    class="select2 form-control w-full mt-2 py-2">
                                    <?php
                                    for($i = 1; $i <= count($questions); $i++) {
                                        ?>
                                    <option value="<?= $i; ?>"
                                        class="inline-block font-Inter font-normal text-sm text-slate-600"><?= $i; ?>
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
</div>
<!-- END: Modals -->
</div>
