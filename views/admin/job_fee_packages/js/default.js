let p_id, old_packageName, old_credits, old_candidates, old_candidate_radio, old_expiring_month;

$('#job_fee_packages_modal').on('hide.bs.modal', function (e) {
  $('#pid').val('');
  $('#type').val('');
  $('#msg').val('');
});

$('#edit_modal').on('hide.bs.modal', function (e) {
  $('#EditJobPackageData')[0].reset();
});

$("#add_job_fee_packages_form").validate({
  errorElement: "span",
  rules: {
    packageName: {
      required: true
    },
    credits: {
      required: true,
      number: true,
      min: 1
    },
    // candidates: {
    //   required: true,
    // },
    expireIn: {
      required: true,
      number: true,
      min: 1
    },
  },
  messages: {
    packageName: "Please enter package name",
    credits: {
      required: "Please enter credits",
      min: "Value must be greater than or equal to 1"
    },
    // candidates: {
    //   required: "Please select candidate option",
    // },
    expireIn: {
      required: "Please enter expiring month",
      min: "Value must be greater than or equal to 1"
    },
  }
});


function handleBtnClick(package_id, type) {
  let submitBtnText;
  switch (type) {
    case 1:
      submitBtnText = 'Activate';
      $('#job_fee_packages_modal').modal('show');
      $('#job_fee_packages_modal .header').text('Type "YES" to Activate this Package');
      break;
    case 2:
      submitBtnText = 'Delete';
      $('#job_fee_packages_modal').modal('show');
      $('#job_fee_packages_modal .header').text('Type "YES" to Delete this Package');
      break;
    default:
      return;
  }
  $('#pid').val(package_id);
  $('#type').val(type);
  $('#confirm_btn').text(submitBtnText);
}

function openEditModal(button) {
  const row = $(button).closest('tr');
  p_id = row.data('pid');
  old_packageName = row.attr('data-package-name');
  old_credits = row.attr('data-credits');
  old_candidates = row.attr('data-candidates');
  old_expiring_month = row.attr('data-expiring-month');

  $('#EditPackageName').val(old_packageName);
  $('#EditCredits').val(old_credits);

  if (old_candidates) {
    old_candidate_radio = "limited_candidate";
    $("#edit_limited_candidate").prop("checked", true);
    $('#EditCandidates').val(old_candidates);
  } else {
    old_candidate_radio = "unlimited_candidate";
    $("#edit_unlimited_candidate").prop("checked", true);
  }
  $('#EditExpireIn').val(old_expiring_month);
  $('#edit_modal').modal('show');
}

$('input[name="edit_candidates_radio"]').on('change', function () {
  if ($('#edit_unlimited_candidate').is(':checked') && $('#EditCandidates').val()) {
    $('#EditCandidates').val('');
  }
})

$("#EditJobPackageData").submit(function (e) {
  e.preventDefault(); // Prevent the form from submitting normally

  const packageName = $("#EditPackageName").val();
  const credits = $("#EditCredits").val();
  const candidate_radio = $('input[name="edit_candidates_radio"]:checked').val();
  const candidates = $("#EditCandidates").val();
  const expiring_month = $("#EditExpireIn").val();

  if (packageName !== old_packageName || credits != old_credits || candidates !== old_candidates || candidate_radio !== old_candidate_radio || expiring_month !== old_expiring_month) {
    if (packageName !== '' && credits > 0 && candidate_radio && expiring_month > 0) {
      if (candidate_radio === 'unlimited_candidate' || candidate_radio === 'limited_candidate') {
        if (candidate_radio === 'limited_candidate' && candidates <= 0) {
          showAlert("danger", "Candidate must be greater than 0.", "jsmodalerror");
        } else {
          $(".btn-disabled").attr('disabled', true);
          // Update the table row with the new data
          $.ajax({
            url: base_url + admin_link + '/job_fee_packages/edit_job_fee_packages_data',
            type: 'POST',
            data: { pid: p_id, packageName: packageName, credits: credits, candidates: candidates, candidates_radio: candidate_radio, expireIn: expiring_month },
            dataType: 'json',
            success: function (response) {
              // console.log(response)
              if (response[0].etype == 'success') {
                const row = $(".data-table tr[data-pid='" + p_id + "']");
                row.attr("data-package-name", packageName);
                row.attr("data-credits", credits);
                row.attr("data-candidates", candidate_radio === 'limited_candidate' ? candidates : null);
                row.attr("data-expiring-month", expiring_month);

                row.find(".table-td:nth-child(2)").text(packageName);
                row.find(".table-td:nth-child(3)").text(credits);
                row.find(".table-td:nth-child(4)").text(candidate_radio === 'limited_candidate' ? candidates : (candidate_radio === 'unlimited_candidate' ? 'Unlimited' : '-'));
                row.find(".table-td:nth-child(5)").text(expiring_month);
                $('#edit_modal').modal('hide');
                $('#EditJobPackageData')[0].reset();

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
        }
      } else {
        showAlert("danger", "Invalid candidate selected.", "jsmodalerror");
      }
    } else {
      showAlert("danger", "All the fields are require.", "jsmodalerror");
    }
  } else {
    showAlert("info", "No changes were made to your information.", "jsmodalerror");
  }
});