function openConfirmationModal(id, type) {
    let submitBtnText;
    switch (type) {
        case 1:
            submitBtnText = 'Activate';
            $('#user_modal').modal('show');
            $('#user_modal .header').text('Type "YES" to Activate this User');
            break;
        case 2:
            submitBtnText = 'Block';
            $('#user_modal').modal('show');
            $('#user_modal .header').text('Type "YES" to Block this User');
            break;
        default:
            return;
    }
    $('#id').val(id);
    $('#type').val(type);
    $('#confirm_btn').text(submitBtnText);
    $("#user_modal").modal('show');
}

function openModal(img) {
    // Set the source of the modal image to the clicked image
    let modalImage = document.querySelector('.modal-image');
    modalImage.src = img.src;
    $("#imageModal").modal('show');
}

$("#users_filter_form").submit(function (e) {
    e.preventDefault();
    $(".btn-disabled").attr('disabled', true);
    // Retrieve the form data
    const user_id = $("#user").val();
    const DateRange = $("#date_range").val();

    if (user_id != null || DateRange != '') {
        $.ajax({
            url: base_url + admin_link + '/users/get_users_data',
            type: 'POST',
            data: {
                user_id: user_id,
                date_range: DateRange
            },
            dataType: 'json',
            success: function (response) {
                // console.log(response)
                if (response[0].etype == 'success') {
                    var table = $(".data-table").DataTable();
                    table.clear().draw();

                    if (response[0]?.data?.length > 0) {
                        response[0].data.forEach(function (data, i) {
                            let rowData = [];
                            rowData = [
                                i + 1,
                                data.user_name ? data.user_name : '-',
                                data.user_profile ? `<img src="${api_url}${data.user_profile}" alt="Profile" class="data-table-img w-full h-full cursor-pointer" onclick="openModal(this)">` : '-',
                                data.user_email ? data.user_email : '-',
                                data.dial_code ? data.dial_code : '-',
                                data.user_phone ? data.user_phone : '-',
                                data.user_address ? data.user_address : '-',
                                data.country_name ? data.country_name : '-',
                                data.is_email_verified == 0 ? `<span class="text-danger-500">Pending</span>` : (data.is_email_verified == 1 ? `<span class="text-success-500">Done</span>` : '-'),
                                data.is_phone_verified == 0 ? `<span class="text-danger-500">Pending</span>` : (data.is_phone_verified == 1 ? `<span class="text-success-500">Done</span>` : '-'),
                                data.is_jobseeker == 0 ? `No` : (data.is_jobseeker == 1 ? `Yes` : '-'),
                                new Date(data.createdAt).toLocaleDateString('en-GB'),
                                data.isDeleted == 1 ? (
                                    `<button class="btn btn-success btn-sm block w-full text-center" type="button" onclick="openConfirmationModal('${data.id}', 1)">
                                        Activate
                                    </button>`
                                ) : (
                                    `<button class="btn btn-danger btn-sm block w-full text-center" type="button" onclick="openConfirmationModal('${data.id}', 2)">
                                        Block
                                    </button>`
                                )
                            ];

                            // Render the custom <td> elements with classes
                            var renderedRow = rowData.map(function (value, index) {
                                var className = 'table-td'; // Default class
                                if (index == 0 || index == 1 || index == (rowData.length - 1)) {
                                    className = 'table-td bg-white sticky'
                                }

                                if (index == 0) {
                                    return `<td class="${className}" style="left: 0;">${value}</td>`;
                                } else if (index == 1) {
                                    return `<td class="${className}" style="left: 50px;">${value}</td>`;
                                } else {
                                    return `<td class="${className}">${value}</td>`;
                                }
                            });

                            var rowHTML = `<tr class="even:bg-slate-50 dark:even:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700">${renderedRow.join('')}</tr>`;

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

