let a_id, q_id, old_answerName, old_question;

$(document).ready(function () {
    $('#question').change(function () {
        const selectedOption = $(this).val();
        if (selectedOption === '') {
            $('#answerType').hide();
        } else {
            $('#answerType').show();
            const selectedOptionType = $(this).find(':selected').data('question-type');
            $('#answerTypeInput').val(selectedOptionType);

            getAnswerData(selectedOption)
        }
    });
});

function getAnswerData(selectedOption) {
    $(".btn-disabled").attr('disabled', true);
    if (selectedOption) {
        $.ajax({
            url: base_url + admin_link + '/answers/get_all_answers',
            type: "POST",
            data: {
                question_id: selectedOption
            },
            dataType: "json",
            success: function (response) {
                console.log(response);
                var table = $(".data-table").DataTable();
                table.clear().draw(); // Clear the existing data
                if (response[0].etype == 'success') {
                    if (response[0]?.data?.length > 0) {
                        response[0].data.forEach(function (data, i) {
                            var rowData = [
                                i + 1,
                                data.answer_name,
                                data.isDeleted === 1 ? `
                                        <button type="button" onclick="handleBtnClick('${data.id}', 1)">
                                            Activate
                                        </button>
                                    ` : `
                                        <div class="flex space-x-3 rtl:space-x-reverse">
                                            <button class="action-btn" type="button"
                                                onclick="openEditModal(this)">
                                                <iconify-icon icon="heroicons:pencil-square"></iconify-icon>
                                            </button>
                                            <button class="action-btn" type="button"
                                                onclick="handleBtnClick('${data.id}', 2)">
                                                <iconify-icon icon="heroicons:trash"></iconify-icon>
                                            </button>
                                        </div>
                                    `
                            ];

                            let renderedRow = rowData.map(function (value, index) {
                                return '<td class="table-td">' + value + '</td>';
                            });

                            const rowHTML = `
                                <tr class="even:bg-slate-50 dark:even:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700" data-no="${i + 1}" data-aid="${data.id}" data-qid="${data.question_id}" data-question="${data.question_name}" data-answer-name="${data.answer_name}" >${renderedRow.join('')}</tr>
                            `;

                            table.row.add($(rowHTML));
                        });

                        table.draw(); // Redraw the table with the new data
                        table.columns.adjust(); // Adjust the columns
                    } else {
                        showAlert('danger', 'No data available.');
                    }
                } else {
                    showAlert(response[0].etype, response[0].msg);
                }
                $(".btn-disabled").removeAttr('disabled');
            },
            error: function (jqXHR, exception) {
                handleAjaxErr(jqXHR, exception);
            }
        });
    } else {
        showAlert('danger', 'Please select question first.');
    }
}

function handleBtnClick(id, type) {
    let submitBtnText;
    switch (type) {
        case 1:
            submitBtnText = 'Activate';
            $('#answer_modal').modal('show');
            $('#answer_modal .header').text('Type "YES" to Activate this Answer');
            break;
        case 2:
            submitBtnText = 'Delete';
            $('#answer_modal').modal('show');
            $('#answer_modal .header').text('Type "YES" to Delete this Answer');
            break;
        default:
            return;
    }
    $('#ans_id').val(id);
    $('#type').val(type);
    $('#confirm_btn').text(submitBtnText);
}

function openEditModal(button) {
    var row = $(button).closest('tr'); // Get the closest parent table row
    a_id = row.data('aid');
    q_id = row.data('qid');
    old_answerName = row.attr('data-answer-name');
    old_question = row.attr('data-question');
    console.log(old_question);
    console.log(old_answerName);
    $('#Editquestion').val(old_question);
    $('#Editquestion').attr("title", old_question);
    $('#EditanswerNameInput').val(old_answerName);
    $('#edit_modal').modal('show');
}

$("#subCategory").change(function () {
    const sub_cat_data = $(this).val();
    if (sub_cat_data) {
        $.ajax({
            url: base_url + admin_link + '/answers/get_all_questions',
            type: "POST",
            data: {
                sub_cat_id: sub_cat_data
            },
            dataType: "json",
            success: function (response) {
                // console.log(response);
                var table = $(".data-table").DataTable();
                table.clear().draw(); // Clear the existing data
                if (response[0].etype == 'success') {
                    if (response[0]?.data?.length > 0) {
                        $('#question').empty();
                        let str = `<option class="inline-block font-Inter font-normal text-sm text-slate-600" selected disabled>Select Question Type</option>`;
                        $.each(response[0]?.data, function (key, value) {
                            str += `<option value="${value.id}" data-question="${value.question_name}" data-question-type="${value.input_type_name}" class="inline-block font-Inter font-normal text-sm text-slate-600">${value.question_name}</option>`;
                        })
                        $('#question').append(str);
                    } else {
                        showAlert('danger', 'No data available.');
                    }
                } else {
                    showAlert(response[0].etype, response[0].msg);
                }
            },
            error: function (jqXHR, exception) {
                handleAjaxErr(jqXHR, exception);
            }
        });
    } else {
        showAlert('danger', 'Please select subcategory first.');
    }
})

$("#EditAnswerData").submit(function (e) {
    e.preventDefault();
    const answerName = $("#EditanswerNameInput").val();

    if (answerName !== old_answerName) {
        if (answerName !== '') {
            $(".btn-disabled").attr('disabled', true);
            $.ajax({
                url: base_url + admin_link + '/answers/edit_answer_data',
                type: "POST",
                data: {
                    ans_id: a_id,
                    question_id: q_id,
                    ans_name: answerName
                },
                dataType: "json",
                success: function (response) {
                    // console.log(response)
                    if (response[0].etype == 'success') {
                        const row = $(".data-table tr[data-aid='" + a_id + "']");

                        row.attr("data-answer-name", answerName);
                        row.find(".table-td:nth-child(2)").text(answerName);
                        $('#edit_modal').modal('hide');

                        $("#EditanswerNameInput").val("");
                        $("#Editquestion").val("");
                        showAlert(response[0].etype, response[0].msg);
                    } else {
                        showAlert(response[0].etype, response[0].msg, "jsmodalerror");
                    }
                    $(".btn-disabled").removeAttr('disabled');
                },
                error: function (jqXHR, exception) {
                    handleAjaxErr(jqXHR, exception);
                }
            })
        } else {
            showAlert("danger", "All fields are required.", "jsmodalerror");
        }
    } else {
        showAlert("info", "No changes were made to your information.", "jsmodalerror");
    }
});

$("#add_answer_form").submit(function (e) {
    e.preventDefault();

    // Retrieve the form data
    const question = $("#question").val();
    const answer = $("#answerNameInput").val();
    if (question != null && answer != '') {
        $(".btn-disabled").attr('disabled', true);
        $.ajax({
            url: base_url + admin_link + '/answers/add_answers',
            type: 'POST',
            data: { question: question, answerName: answer },
            dataType: 'json',
            success: function (response) {
                // console.log(response)
                if (response[0].etype == 'success') {
                    showAlert(response[0].etype, response[0].msg);

                    $("#answerNameInput").val("");
                    getAnswerData(question)
                } else {
                    showAlert(response[0].etype, response[0].msg, "jserror");
                }
                $(".btn-disabled").removeAttr('disabled');
            },
            error: function (jqXHR, exception) {
                handleAjaxErr(jqXHR, exception);
            }
        })
    } else {
        showAlert("danger", "Some data is missing.", "jsmodalerror");
    }
});

$("#ChangeStateStatus").submit(function (e) {
    e.preventDefault();

    // Retrieve the form data
    const ans_id = $("#ans_id").val();
    const Type = $("#type").val();
    const Msg = $("#msg").val();
    const question = $("#question").val();

    if (ans_id != '' && Type != '' && Msg != '') {
        $(".btn-disabled").attr('disabled', true);
        $.ajax({
            url: base_url + admin_link + '/answers/change_answer_status',
            type: 'POST',
            data: { ans_id: ans_id, type: Type, msg: Msg },
            dataType: 'json',
            success: function (response) {
                // console.log(response)
                if (response[0].etype == 'success') {
                    getAnswerData(question);
                    showAlert(response[0].etype, response[0].msg);
                    $("#ans_id").val("");
                    $("#type").val("");
                    $("#msg").val("");
                    $('#answer_modal').modal('hide');
                } else {
                    showAlert(response[0].etype, response[0].msg, "jsmodalerror");
                }
                $(".btn-disabled").removeAttr('disabled');
            },
            error: function (jqXHR, exception) {
                handleAjaxErr(jqXHR, exception);
            }
        })
    } else {
        showAlert("danger", "Some data is missing.", "jsmodalerror");
    }
});

