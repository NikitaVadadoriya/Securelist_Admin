let sub_cat_id, old_subCategoryName, old_credits;
$('#sub_cat_modal').on('hide.bs.modal', function (e) {
    $('#sub_cat_name').val('');
    $('#type').val('');
    $('#msg').val('');
});

$("#add_sub_category_form").validate({
    errorElement: "span",
    rules: {
        subCategoryName: {
            required: true,
            pattern: /^[a-zA-Z0-9()&,\s\/-]+$/,
        },
        credits: {
            required: true,
            digits: true
        }
    },
    messages: {
        subCategoryName: {
            required: "Please enter sub category name",
            pattern: "Please enter valid sub category name",
        },
        credits: {
            required: "Please enter credits",
            digits: "Enter only numbers for Credits."
        }
    }
});

function handleBtnClick(sub_cat_name, type) {
    let submitBtnText;
    switch (type) {
        case 1:
            submitBtnText = 'Activate';
            $('#sub_cat_modal').modal('show');
            $('#sub_cat_modal .header').text('Type "YES" to Activate this Sub Category');
            break;
        case 2:
            submitBtnText = 'Delete';
            $('#sub_cat_modal').modal('show');
            $('#sub_cat_modal .header').text('Type "YES" to Delete this Sub Category');
            break;
        default:
            return;
    }
    $('#sub_cat_name').val(sub_cat_name);
    $('#type').val(type);
    $('#confirm_btn').text(submitBtnText);
}

function openEditModal(button) {
    var row = $(button).closest('tr'); // Get the closest parent table row
    sub_cat_id = row.data('sub-cat-id');

    old_subCategoryName = row.attr('data-subcategory');
    old_credits = row.attr('data-credits');

    $('#EditsubCategoryName').val(old_subCategoryName);
    $('#EditCredits').val(old_credits);
    $('#edit_modal').modal('show');
}

$("#EditSubCategoryData").submit(function (e) {
    e.preventDefault(); // Prevent the form from submitting normally

    // Retrieve the form data
    const subCategoryName = $("#EditsubCategoryName").val();
    const credits = $("#EditCredits").val();

    if (subCategoryName != old_subCategoryName || credits != old_credits) {
        if (subCategoryName) {
            $(".btn-disabled").attr('disabled', true);
            $.ajax({
                url: base_url + admin_link + '/sub_categories/edit_sub_cat_data',
                type: 'POST',
                data: { sub_cat_id: sub_cat_id, sub_cat_name: subCategoryName, credits: credits },
                dataType: 'json',
                success: function (response) {
                    // console.log(response)
                    if (response[0].etype == 'success') {
                        const row = $(".data-table tr[data-sub-cat-id='" + sub_cat_id + "']");
                        row.attr("data-subcategory", subCategoryName);
                        row.attr("data-credits", credits);
                        row.find(".table-td:nth-child(2)").text(subCategoryName);
                        row.find(".table-td:nth-child(3)").text(credits);
                        $('#edit_modal').modal('hide');
                        $('#EditSubCategoryData')[0].reset()

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
            showAlert("danger", "Sub-category name must not be empty.", "jsmodalerror");
        }
    } else {
        showAlert("info", "No changes were made to your information.", "jsmodalerror");
    }
});