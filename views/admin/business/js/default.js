function openConfirmationModal(id, type) {
    let submitBtnText;
    switch (type) {
        case 1:
            submitBtnText = 'Activate';
            $('#business_modal').modal('show');
            $('#business_modal .header').text('Type "YES" to Activate this Business');
            break;
        case 2:
            submitBtnText = 'Block';
            $('#business_modal').modal('show');
            $('#business_modal .header').text('Type "YES" to Block this Business');
            break;
        default:
            return;
    }
    $('#id').val(id);
    $('#type').val(type);
    $('#confirm_btn').text(submitBtnText);
    $("#business_modal").modal('show');
}

$('#reject_reason').select2({
    dropdownParent: $('#reject_kyc_modal')
});

function openModal(img) {
    // Set the source of the modal image to the clicked image
    let modalImage = document.querySelector('.modal-image');
    modalImage.src = img.src;
    $("#imageModal").modal('show');
}

$("#business_filter_form").submit(function (e) {
    e.preventDefault();
    $(".btn-disabled").attr('disabled', true);
    // Retrieve the form data
    const business_id = $("#business").val();
    const DateRange = $("#date_range").val();

    if (business_id != null || DateRange != '') {
        $.ajax({
            url: base_url + admin_link + '/business/get_data',
            type: 'POST',
            data: {
                business_id: business_id,
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
                                data.full_name ? data.full_name : '-',
                                data.business_profile ? `<img src="${api_url}${data.business_profile}" alt="Profile" height="100" width="100" class="object-cover w-full h-full cursor-pointer" onclick="openModal(this)">` : '-',
                                data.business_email ? data.business_email : '-',
                                data.business_address ? data.business_address : '-',
                                data.pincode ? data.pincode : '-',
                                data.dial_code ? data.dial_code : '-',
                                data.business_phone ? data.business_phone : '-',
                                data.is_email_verified == 0 ? `<span class="text-danger-500">Pending</span>` : (data.is_email_verified == 1 ? `<span class="text-success-500">Done</span>` : '-'),
                                data.is_phone_verified == 0 ? `<span class="text-danger-500">Pending</span>` : (data.is_phone_verified == 1 ? `<span class="text-success-500">Done</span>` : '-'),
                                data.is_kyc_done == 0 ? `<span class="text-primary-500">Pending</span>` : (data.is_kyc_done == 1 ? `<span class="text-success-500">Done</span>` : (data.is_kyc_done == 2 ? `<span class="text-danger-500">Rejected</span>` : '-')),
                                new Date(data.createdAt).toLocaleDateString('en-GB'),
                                data.total_credit ? data.total_credit : '0',
                                data.total_debit ? data.total_debit : '0',
                                data.current_balance,
                                data.isDeleted == 1 ? `<button class="btn btn-success btn-sm block w-full text-center" type="button" onclick="openConfirmationModal('${data.id}', 1)">Activate</button>` : `<button class="btn btn-danger btn-sm block w-full text-center" type="button" onclick="openConfirmationModal('${data.id}', 2)">Block</button>`
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

