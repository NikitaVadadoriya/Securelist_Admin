let r_id;

$('#requestAnswers_modal').on('hide.bs.modal', function (e) {
    $('#cname').val('');
});

$("#user_request_filter").submit(function (e) {
    e.preventDefault();
    $(".btn-disabled").attr('disabled', true);
    // Retrieve the form data
    const user_id = $("#userName").val();
    const sub_cat_id = $("#subCategory").val();
    const DateRange = $("#date_range").val();

    if (user_id != null || sub_cat_id != null || DateRange != '') {
        $.ajax({
            url: base_url + admin_link + '/user_requests/get_request_data',
            type: 'POST',
            data: {
                user_id: user_id,
                sub_cat_id: sub_cat_id,
                date_range: DateRange,
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
                                data.user_name,
                                data.sub_cat_name,
                                `<button type="button" class="text-primary-500 btn-disabled" onclick="openRequestAnswerModal(this)">View Answers</button>`,
                                data.business_name ? data.business_name : '-',
                                data.hired_date ? new Date(data.hired_date).toLocaleDateString('en-GB') : '-',
                                data.responded_business > 0 ? `<button type="button" class="text-primary-500 btn-disabled" onclick="openBusinessListModal(this, 1)">${data.responded_business}</button>` : '0',
                                data.rejected_business > 0 ? `<button type="button" class="text-primary-500 btn-disabled" onclick="openBusinessListModal(this, 2)">${data.rejected_business}</button>` : '0',
                                new Date(data.createdAt).toLocaleDateString('en-GB'),
                                data.status == 0 ? '<span class="text-danger-500">Deleted</span>' : (data.status == 1 ? '<span class="text-primary-500">Intiated</span>' : (data.status == 2 ? '<span class="text-success-500">Hired</span>' : '-'))
                            ];

                            // Render the custom <td> elements with classes
                            const renderedRow = rowData.map(function (value) {
                                const className = 'table-td'; // Default class
                                return `<td class="${className}">${value}</td>`;
                            });

                            // Build the HTML for the row
                            // var rowHTML = `<tr class="even:bg-slate-50 dark:even:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700" data-no.="${i + 1}" data-request-id="${data.id}">` + renderedRow.join('') + '</tr>';

                            var rowHTML = `<tr data-no.="${i + 1}" data-rid="${data.id}">${renderedRow.join('')}</tr>`;

                            // Add the row to the DataTable
                            table.row.add($(rowHTML)).draw();
                            table.columns.adjust();
                        });
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
        })
    } else {
        showAlert("danger", "Please provide all the necessary details.");
    }
});

function openRequestAnswerModal(button) {
    const r_id = $(button).closest('tr').data('rid');
    if (r_id) {
        $(".btn-disabled").attr('disabled', true);
        $.ajax({
            url: base_url + admin_link + '/user_requests/get_request_qa_data',
            type: 'POST',
            data: {
                request_id: r_id,
            },
            dataType: 'json',
            success: function (response) {
                console.log(response)
                if (response[0].etype == 'success') {
                    // response[0]?.data.push({
                    //     id: 290,
                    //     question_id: 4,
                    //     answer_id: 31,
                    //     extra: "",
                    //     createdAt: "2023-06-27",
                    //     answer_name: "Leisure Facility",
                    //     input_type: 4,
                    //     isDeleted: 0,
                    //     question_name: "What type of property needs protection?",
                    //     request_id: 124,
                    //     updatedAt: "2023-06-27",
                    //     user_id: 51,
                    // }, {
                    //     id: 290,
                    //     question_id: 4,
                    //     answer_id: 31,
                    //     extra: "",
                    //     createdAt: "2023-06-27",
                    //     answer_name: "Leisure Facility",
                    //     input_type: 4,
                    //     isDeleted: 0,
                    //     question_name: "What type of property needs protection?",
                    //     request_id: 124,
                    //     updatedAt: "2023-06-27",
                    //     user_id: 51,
                    // })

                    if (response[0]?.data?.length > 0) {
                        var groupedArray = {};
                        $.each(response[0]?.data, function (index, item) {
                            var key = item.question_id + '-' + item.input_type;
                            if (!groupedArray[key]) {
                                groupedArray[key] = [];
                            }
                            groupedArray[key].push(item);
                        });
                        console.log(groupedArray)
                        let resultArray = [];

                        $.each(groupedArray, function (key, items) {
                            if (items.length > 1) {
                                resultArray.push(items);
                            } else {
                                resultArray.push(items[0]);
                            }
                        });
                        console.log(resultArray)

                        let str = '';

                        resultArray.forEach(function (data, i) {
                            if ($.type(data) == "array") {
                                let list = '';
                                $.each(data, function (i, ele) {
                                    list += `<p class="text-slate-500">${ele.answer_name}</p>`;
                                })
                                str += `<div class="input-area relative"><label class="form-label"> Q.${i + 1} ${data[0].question_name}</label>${list}</div>`;
                            } else {
                                str += `<div class="input-area relative"><label class="form-label"> Q.${i + 1} ${data.question_name}</label><p class="text-slate-500">${(
                                    data.input_type == 1 || data.input_type == 5) ? (data.extra) : (
                                    (data.input_type == 2 || data.input_type == 4) ? (data.answer_name) : ('-')
                                )}</p></div>`;
                            }
                        });

                        // response[0].data.forEach(function (data, i) {
                        //     str += `<div class="input-area relative"><label class="form-label"> Q.${i + 1} ${data.question_name}</label><p class="text-slate-500">${(
                        //         data.input_type == 1 || data.input_type == 5) ? (data.extra) : (
                        //         (data.input_type == 2 || data.input_type == 4) ? (data.answer_name) : (
                        //             data.input_type == 3 ? (
                        //                 '-'
                        //             ) : ('-')
                        //         )
                        //     )}</p></div>`;
                        // });
                        $("#qa_list").html(str);
                        $("#requestAnswers_modal").modal("show");
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
        })
    } else {
        showAlert("danger", "Please provide all the necessary details.");
    }
}

function openBusinessListModal(button, status) {
    $(".btn-disabled").attr('disabled', true);
    const request_id = $(button).closest('tr').data('rid');
    if (request_id && (status == 1 || status == 2)) {
        $.ajax({
            url: base_url + admin_link + '/user_requests/get_business_list_data',
            type: 'POST',
            data: {
                request_id: request_id,
                status: status
            },
            dataType: 'json',
            success: function (response) {
                // console.log(response)
                if (response[0].etype == 'success') {
                    if (response[0]?.data?.length > 0) {
                        let list = '';
                        response[0]?.data.forEach(function (data, i) {
                            list += `<p class="text-slate-500">${i + 1}. ${data.full_name}</p>`;
                        });

                        $("#requestAnswers_modal .header").text(status == 1 ? `Responded business's list` : (status == 2 ? `Rejected business's list` : '-'));
                        $("#qa_list").removeClass('gap-7').html(list);
                        $("#requestAnswers_modal").modal("show");
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
        })
    } else {
        showAlert("danger", "Please provide all the necessary details.");
    }
}