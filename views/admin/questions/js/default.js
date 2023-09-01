let q_id, old_questionType, old_subCategory, old_question, old_inputType, old_questionOrder;

$(document).ready(function () {
    // Show sub-category select when "Business Specific" is selected
    $('#questionType').on('change', function () {
        var selectedOption = $(this).val();
        if (selectedOption == 'Business Specific') {
            $("#subCategoryInput").css("display", "block");
        } else {
            $("#subCategoryInput").css("display", "none");
            $("#subCategory").val();
        }
    });

    $('#EditquestionType').on('change', function () {
        var selectedOption = $(this).val();
        if (selectedOption == 'Business Specific') {
            $("#EditsubCategoryInput").css("display", "block");
        } else {
            $("#EditsubCategoryInput").css("display", "none");
            $("#EditsubCategory").val();
        }
    });
});

$('#EditsubCategory,#EditquestionType,#EditInputType,#EditquestionOrder').select2({
    dropdownParent: $('#edit_modal')
});

function handleBtnClick(qid, type) {
    let submitBtnText;
    switch (type) {
        case 1:
            submitBtnText = 'Activate';
            $('#question_modal').modal('show');
            $('#question_modal .header').text('Type "YES" to Activate this Question');
            break;
        case 2:
            submitBtnText = 'Delete';
            $('#question_modal').modal('show');
            $('#question_modal .header').text('Type "YES" to Delete this Question');
            break;
        default:
            return;
    }
    $('#qid').val(qid);
    $('#type').val(type);
    $('#confirm_btn').text(submitBtnText);
}

function openEditModal(button) {
    var row = $(button).closest('tr'); // Get the closest parent table row
    q_id = row.attr('data-qid');
    old_questionType = row.attr('data-question-type');
    old_subCategory = row.attr('data-subcategory');
    old_question = row.attr('data-question');
    old_inputType = row.attr('data-input-type');
    old_questionOrder = row.attr('data-questionorder');

    // $('#EditquestionType').val(old_questionType).trigger('change');
    $('#EditsubCategory').val(old_subCategory).trigger('change');
    $('#Editquestion').val(old_question);
    $('#EditInputType').val(old_inputType).trigger('change');
    $('#EditquestionOrder').val(old_questionOrder).trigger('change'); // Set the value and trigger change event
    $('#edit_modal').modal('show');
}

$("#EditQuestionData").submit(function (e) {
    e.preventDefault();
    // Retrieve the form data
    // const questionType = $("#EditquestionType").val();
    const subCategory = $("#EditsubCategory").val();
    const inputType = $("#EditInputType").val();
    const question = $("#Editquestion").val();
    const questionOrder = $("#EditquestionOrder").val();

    if (subCategory != old_subCategory || inputType != old_inputType || subCategory != old_subCategory || question != old_question || questionOrder != old_questionOrder) {
        if (subCategory != null && question != '' && inputType != null && questionOrder != '') {
            // if (questionType == 'Business Specific' && subCategory == null) {
            //     showAlert("danger", "Please select sub category.", "jsmodalerror");
            // } else {
            $(".btn-disabled").attr('disabled', true);
            $.ajax({
                url: base_url + admin_link + '/questions/edit_question_data',
                type: 'POST',
                data: {
                    q_id: q_id,
                    // questionType: questionType,
                    subCategory: subCategory != null ? subCategory : '-',
                    inputType: inputType,
                    question: question,
                    questionOrder: questionOrder != null ? questionOrder : '-',
                },
                dataType: 'json',
                success: function (response) {
                    // console.log(response)
                    if (response[0].etype == 'success') {
                        var table = $(".data-table").DataTable();
                        table.clear().draw();
                        if (response[0]?.data?.length > 0) {
                            response[0].data.forEach(function (data, i) {
                                const rowData = [
                                    i + 1,
                                    // data.question_type_name,
                                    data.sub_cat_name ? data.sub_cat_name : '-',
                                    data.question_name,
                                    data.input_type_name,
                                    data.question_order ? data.question_order : '-',
                                    data.isDeleted == 1 ? (
                                        `<button type="button" onclick="handleBtnClick('${data.id}', 1)">Activate</button>`
                                    ) : (
                                        `<div class="flex space-x-3 rtl:space-x-reverse"><button class="action-btn" type="button" onclick="openEditModal(this)"><iconify-icon icon="heroicons:pencil-square"></iconify-icon></button><button class="action-btn" type="button" onclick="handleBtnClick('${data.id}', 2)"><iconify-icon icon="heroicons:trash"></iconify-icon></button></div>`
                                    )
                                ];

                                // Render the custom <td> elements with classes
                                const renderedRow = rowData.map(function (value) {
                                    const className = 'table-td'; // Default class
                                    return `<td class="${className}">${value}</td>`;
                                });

                                var rowHTML = `<tr
                                            data-no.="${i + 1}"
                                            data-qid="${data.id}"
                                            data-question-type="${data.question_type_name}"
                                            data-subcategory="${data.sub_category_id ? data.sub_category_id : '-'}"
                                            data-question="${data.question_name}"
                                            data-input-type="${data.input_type_name}"
                                            data-questionorder="${data.question_order}"
                                        >
                                            ${renderedRow.join('')}
                                        </tr>`;

                                // Add the row to the DataTable
                                table.row.add($(rowHTML)).draw();
                                table.columns.adjust();
                                $('#edit_modal').modal('hide');
                            });
                            showAlert(response[0].etype, response[0].msg);
                        } else {
                            showAlert('danger', 'No data available.');
                        }
                    } else {
                        showAlert(response[0].etype, response[0].msg, "jsmodalerror");
                    }
                    $(".btn-disabled").removeAttr('disabled');
                },
                error: function (jqXHR, exception) {
                    handleAjaxErr(jqXHR, exception);
                }
            })
            // }
        } else {
            showAlert("danger", "All fields are required.", "jsmodalerror");
        }
    } else {
        showAlert("info", "No changes were made to your information.", "jsmodalerror");
    }
});

