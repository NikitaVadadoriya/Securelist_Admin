function openKycModal(button, type) {
    var row = $(button).closest('tr'); // Get the closest parent table row
    let k_id = row.data('kid');
    let b_id = row.data('bid');

    if (type == 1) {
        $("#kid").val(k_id);
        $("#bid").val(b_id);
        $("#kycInfo_modal").modal('show');
    }
    if (type == 2) {
        $("#kyc_id").val(k_id);
        $("#biz_id").val(b_id);
        $('#reject_kyc_modal .header').text('Type "YES" to Reject this Business KYC');
        $("#reject_kyc_modal").modal('show');
    }
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

$("#kyc_req_filter_form").submit(function (e) {
    e.preventDefault();
    $(".btn-disabled").attr('disabled', true);
    // Retrieve the form data
    const business_id = $("#business").val();
    const DateRange = $("#date_range").val();
    const loc = $(location).attr('href')
    let split_array = loc.split(base_url + admin_link + '/');

    if (split_array.length > 0) {
        split_array = split_array[1].split('/')
    }

    if (business_id != null || DateRange != '') {
        $.ajax({
            url: base_url + admin_link + '/kyc/get_request_data',
            type: 'POST',
            data: {
                business_id: business_id,
                date_range: DateRange,
                is_pending: split_array[1] == 'pending'
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
                            if (split_array[1] == 'pending') {
                                rowData = [
                                    i + 1,
                                    data.business_name ? data.business_name : '-',
                                    data.name ? data.name : '-',
                                    data.licence_number ? data.licence_number : '-',
                                    new Date(data.licence_expiry).toLocaleDateString('en-GB'),
                                    data.licence_proof ? `<img src="${api_url}${data.licence_proof}" alt="Licence Proof" height="100" width="100" class="data-table-img w-full h-full cursor-pointer" onclick="openModal(this)">` : '-',
                                    data.running_since ? data.running_since : '-',
                                    data.insured == 1 ? 'Yes' : (data.insured == 2 ? 'No' : '-'),
                                    data.insurance_proof ? `<img src="${api_url}${data.insurance_proof}" alt="Licence Proof" height="100" width="100" class="data-table-img w-full h-full cursor-pointer" onclick="openModal(this)">` : '-',
                                    data.insurance_expiry ? new Date(data.insurance_expiry).toLocaleDateString('en-GB') : '-',
                                    data.other_membership == 0 ? 'No' : 'Yes',
                                    data.website ? `<a href="${data.website}" target="_blank" class="text-primary-500" rel="noopener noreferrer">${data.website}</a>` : '-',
                                    data.business_hours ? `${data.business_hours} Hour${data.business_hours > 0 && 's'}` : '-',
                                    new Date(data.updatedAt).toLocaleDateString('en-GB'),
                                    `<div class="flex space-x-3 rtl:space-x-reverse">
                                        <button class="btn btn-success btn-sm block w-full text-center"
                                            type="button" onclick="openKycModal(this, 1)">
                                            Approve
                                        </button>
                                        <button class="btn btn-danger btn-sm block w-full text-center"
                                            type="button" onclick="openKycModal(this, 2)">
                                            Reject
                                        </button>
                                    </div>`
                                ];
                            } else {
                                rowData = [
                                    i + 1,
                                    data.business_name ? data.business_name : '-',
                                    data.name ? data.name : '-',
                                    data.licence_number ? data.licence_number : '-',
                                    new Date(data.licence_expiry).toLocaleDateString('en-GB'),
                                    data.licence_proof ? `<img src="${api_url}${data.licence_proof}" alt="Licence Proof" height="100" width="100" class="data-table-img w-full h-full cursor-pointer" onclick="openModal(this)">` : '-',
                                    data.running_since ? data.running_since : '-',
                                    data.insured == 1 ? 'Yes' : (data.insured == 2 ? 'No' : '-'),
                                    data.insurance_proof ? `<img src="${api_url}${data.insurance_proof}" alt="Licence Proof" height="100" width="100" class="data-table-img w-full h-full cursor-pointer" onclick="openModal(this)">` : '-',
                                    data.insurance_expiry ? new Date(data.insurance_expiry).toLocaleDateString('en-GB') : '-',
                                    data.other_membership == 0 ? 'No' : 'Yes',
                                    data.website ? `<a href="${data.website}" target="_blank" class="text-primary-500" rel="noopener noreferrer">${data.website}</a>` : '-',
                                    data.business_hours ? `${data.business_hours} Hour${data.business_hours > 0 && 's'}` : '-',
                                    new Date(data.createdAt).toLocaleDateString('en-GB'),
                                    new Date(data.updatedAt).toLocaleDateString('en-GB'),
                                    data.approved_by_name ? data.approved_by_name : '-',
                                    data.reject_reason_name ? data.reject_reason_name : '-',
                                    data.apprvoed_date ? new Date(data.apprvoed_date).toLocaleDateString('en-GB') : '-',
                                    data.business_status == 0 ?
                                        '<span class="text-success-500">Active</span>'
                                        : (data.business_status == 1
                                            ? '<span class="text-danger-500">Blocked</span>' : '-'),
                                    data.is_approved == 0 ?
                                        '<span class="text-primary-500">Pending</span>'
                                        : (data.is_approved == 1
                                            ? '<span class="text-success-500">Approved</span>'
                                            : (data.is_approved == 2 ? '<span class="text-danger-500">Rejected</span>' : '-'))
                                ];
                            }

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

                            var rowHTML = `<tr data-no.="${i + 1}" data-kid="${data.id}"
                                data-bid="${data.business_id}">${renderedRow.join('')}</tr>
                            `;

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