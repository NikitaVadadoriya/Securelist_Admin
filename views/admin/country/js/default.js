let c_id, old_countryName, old_code, old_isoCode;

$('#country_modal').on('hide.bs.modal', function (e) {
  $('#cname').val('');
  $('#type').val('');
  $('#msg').val('');
});

$("#add_country_form").validate({
  errorElement: "span",
  rules: {
    countryName: {
      required: true
    },
    dial_code: {
      required: true,
      number: true
    },
    isoCode: {
      required: true,
      minlength: 2,
      maxlength: 2
    },
  },
  messages: {
    countryName: "Please enter country name",
    dial_code: {
      required: "Please enter dial code"
    },
    isoCode: {
      minlength: "Should contain 2 characters",
      maxlength: "Should contain 2 characters"
    },
  }
});


function handleBtnClick(stateName, type) {
  let submitBtnText;
  switch (type) {
    case 1:
      submitBtnText = 'Activate';
      $('#country_modal').modal('show');
      $('#country_modal .header').text('Type "YES" to Activate this Country');
      break;
    case 2:
      submitBtnText = 'Delete';
      $('#country_modal').modal('show');
      $('#country_modal .header').text('Type "YES" to Delete this Country');
      break;
    default:
      return;
  }
  $('#cname').val(stateName);
  $('#type').val(type);
  $('#confirm_btn').text(submitBtnText);
}

function openEditModal(button) {
  const row = $(button).closest('tr');
  c_id = row.data('cid');
  old_countryName = row.attr('data-country');
  old_code = row.attr('data-dial-code');
  old_isoCode = row.attr('data-code'); // Retrieve the ISO code from the data attribute

  $('#EditcountryName').val(old_countryName);
  $('#Editcode').val(old_code);
  $('#EditisoCode').val(old_isoCode);
  $('#edit_modal').modal('show');
}

$("#EditCountryData").submit(function (e) {
  e.preventDefault(); // Prevent the form from submitting normally

  const countryName = $("#EditcountryName").val();
  const code = $("#Editcode").val();
  const isoCode = $("#EditisoCode").val();
  if (countryName !== old_countryName || code != old_code || isoCode !== old_isoCode) {
    if (countryName !== '' && code !== '' && isoCode !== '') {
      if (isoCode.length == 2) {
        $(".btn-disabled").attr('disabled', true);
        // Update the table row with the new data
        $.ajax({
          url: base_url + admin_link + '/country/edit_country_data',
          type: 'POST',
          data: { cid: c_id, country: countryName, code: code, iso_code: isoCode },
          dataType: 'json',
          success: function (response) {
            // console.log(response)
            if (response[0].etype == 'success') {
              const row = $(".data-table tr[data-cid='" + c_id + "']");
              row.attr("data-country", countryName);
              row.attr("data-dial-code", code);
              row.attr("data-code", isoCode);

              row.find(".table-td:nth-child(2)").text(countryName);
              row.find(".table-td:nth-child(3)").text(code);
              row.find(".table-td:nth-child(4)").text(isoCode);
              $('#edit_modal').modal('hide');
              $('#EditCountryData')[0].reset();

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
        showAlert("danger", "Only two letters are allowed in ISO code.", "jsmodalerror");
      }
    } else {
      showAlert("danger", "All fields are required.", "jsmodalerror");
    }
  } else {
    showAlert("info", "No changes were made to your information.", "jsmodalerror");
  }
});