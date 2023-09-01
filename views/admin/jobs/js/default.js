$('#requestAnswers_modal').on('hide.bs.modal', function (e) {
    $('#cname').val('');
});

$("#job_filter").submit(function (e) {
    e.preventDefault();
    $(".btn-disabled").attr('disabled', true);
    // Retrieve the form data
    const business_id = $("#business").val();
    const sub_cat_id = $("#subCategory").val();
    const DateRange = $("#date_range").val();

    if (business_id != null || sub_cat_id != null || DateRange != '') {
        $.ajax({
            url: base_url + admin_link + '/jobs/get_job_data',
            type: 'POST',
            data: {
                business_id: business_id,
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
                                data.business_name,
                                data.sub_cat_name,
                                data.title,
                                data.description,
                                data.vacancy,
                                data.city_name ? data.city_name : '-',
                                data.address ? data.address : '-',
                                data.min_experience ? data.min_experience : '-',
                                data.min_qualification ? data.min_qualification : '-',
                                data.job_type,
                                data.applied_user_count > 0 ? `<button type="button" class="text-primary-500" onclick="openUserListModal(this, 1)">${data.applied_user_count}</button>` : '0',
                                data.hired_user_count > 0 ? `<button type="button" class="text-primary-500" onclick="openUserListModal(this, 2)">${data.hired_user_count}</button>` : '0',
                                new Date(data.createdAt).toLocaleDateString('en-GB'),
                                data.status == 0 ? '<span class="text-danger-500">Deleted</span>' : (data.status == 1 ? '<span class="text-success-500">Active</span>' : (data.status == 2 ? '<span class="text-primary-500">Draft</span>' : '-'))
                            ];

                            // Render the custom <td> elements with classes
                            const renderedRow = rowData.map(function (value) {
                                const className = 'table-td'; // Default class
                                return `<td class="${className}">${value}</td>`;
                            });

                            var rowHTML = `<tr data-no.="${i + 1}" data-jid="${data.id}">${renderedRow.join('')}</tr>`;

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

function openUserListModal(button, status) {
    const job_id = $(button).closest('tr').data('jid');
    if (job_id && (status == 1 || status == 2)) {
        $.ajax({
            url: base_url + admin_link + '/jobs/get_user_list_data',
            type: 'POST',
            data: {
                job_id: job_id,
                status: status
            },
            dataType: 'json',
            success: function (response) {
                // console.log(response)
                if (response[0].etype == 'success') {
                    if (response[0]?.data?.length > 0) {
                        let list = '';
                        response[0]?.data.forEach(function (data, i) {
                            list += `<p class="text-slate-500">${data.applicant_name}</p>`;
                        });

                        $("#user_list_modal .header").text(status == 1 ? `Applied user's list` : (status == 2 ? `Hired user's list` : '-'));
                        $("#user_list").html(list);
                        $("#user_list_modal").modal("show");
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
        })
    } else {
        showAlert("danger", "Please provide all the necessary details.");
    }
}
