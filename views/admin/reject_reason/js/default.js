let reason_id, old_reason;
$('#reject_reason_modal').on('hide.bs.modal', function (e) {
    $('#id').val('');
    $('#type').val('');
    $('#msg').val('');
});

$("#add_reject_reason_form").validate({
    errorElement: "span",
    rules: {
        rejectReason: {
            required: true,
            pattern: /^[a-zA-Z(),\s\/-]+$/,
        },
    },
    messages: {
        rejectReason: {
            required: "Reject reason must not be empty",
            pattern: "Please enter valid reject reason",
        }
    }
});

function handleBtnClick(id, type) {
    let submitBtnText;
    switch (type) {
        case 1:
            submitBtnText = 'Activate';
            $('#reject_reason_modal').modal('show');
            $('#reject_reason_modal .header').text('Type "YES" to Activate this Reject Reason');
            break;
        case 2:
            submitBtnText = 'Delete';
            $('#reject_reason_modal').modal('show');
            $('#reject_reason_modal .header').text('Type "YES" to Delete this Reject Reason');
            break;
        default:
            return;
    }
    $('#id').val(id);
    $('#type').val(type);
    $('#confirm_btn').text(submitBtnText);
}

function openEditModal(button) {
    var row = $(button).closest('tr'); // Get the closest parent table row
    reason_id = row.data('id');

    old_reason = row.attr('data-reason-name');

    $('#EditrejectReason').val(old_reason);
    $('#edit_modal').modal('show');
}

$("#EditRejectReason").submit(function (e) {
    e.preventDefault(); // Prevent the form from submitting normally

    // Retrieve the form data
    const rejectReason = $("#EditrejectReason").val();
    if (rejectReason != old_reason) {
        if (rejectReason) {
            if (rejectReason.match(/^[a-zA-Z(),\s\/-]+$/)) {
                $(".btn-disabled").attr('disabled', true);
                $.ajax({
                    url: base_url + admin_link + '/reject_reason/edit_reject_reason',
                    type: 'POST',
                    data: { id: reason_id, reject_reason: rejectReason },
                    dataType: 'json',
                    success: function (response) {
                        // console.log(response)
                        if (response[0].etype == 'success') {

                            const row = $(".data-table tr[data-id='" + reason_id + "']");
                            row.attr("data-reason-name", rejectReason);
                            row.find(".table-td:nth-child(2)").text(rejectReason);
                            $('#edit_modal').modal('hide');
                            $('#EditRejectReason')[0].reset()

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
                showAlert("danger", "Please enter valid reject reason.", "jsmodalerror");
            }
        } else {
            showAlert("danger", "Reject reason must not be empty.", "jsmodalerror");
        }
    } else {
        showAlert("info", "No changes were made to your information.", "jsmodalerror");
    }
});