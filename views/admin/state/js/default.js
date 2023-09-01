let s_id, old_countryName, old_stateName;

$('#state_modal').on('hide.bs.modal', function (e) {
  $('#sname').val('');
  $('#type').val('');
  $('#msg').val('');
});

$("#add_state_form").validate({
  errorElement: "span",
  rules: {
    countryName: {
      required: true
    },

    stateName: {
      required: true,
      pattern: /^[a-zA-Z ]+$/
    },
  },
  messages: {
    countryName: "Please select country",
    stateName: {
      required: "Please enter state name",
      pattern: "Only alphabetical characters are allowed."
    },
  }
});

function handleBtnClick(stateName, type) {
  let submitBtnText;
  switch (type) {
    case 1:
      submitBtnText = 'Activate';
      $('#state_modal').modal('show');
      $('#state_modal .header').text('Type "YES" to Activate this State');
      break;
    case 2:
      submitBtnText = 'Delete';
      $('#state_modal').modal('show');
      $('#state_modal .header').text('Type "YES" to Delete this State');
      break;
    default:
      return;
  }
  $('#sname').val(stateName);
  $('#type').val(type);
  $('#confirm_btn').text(submitBtnText);
}

function openEditModal(button) {
  const row = $(button).closest('tr');
  s_id = row.data('sid');
  old_countryName = row.attr('data-country');
  old_stateName = row.attr('data-state');

  $('#EditcountryName').val(old_countryName);
  $('#EditstateName').val(old_stateName);
  $('#edit_modal').modal('show');
}

function getStateData(countryName) {
  if (countryName) {
    $.ajax({
      url: base_url + admin_link + '/state/get_state',
      type: 'POST',
      data: {
        country_name: countryName
      },
      dataType: 'json',
      success: function (response) {
        // console.log("getStateData =", response);
        if (response[0].etype == 'success') {
          var table = $(".data-table").DataTable();

          if (response[0]?.data?.length > 0) {
            table.clear().draw(); // Clear the existing data

            response[0].data.forEach(function (data, i) {
              var rowData = [
                i + 1,
                data.country_name ? data.country_name : '-',
                data.state_name ? data.state_name : '-',
                data.isDeleted == 1 ? (
                  `<button type="button" onclick="handleBtnClick('${data.sname}', 1)">Activate</button>`
                ) : (
                  `<div class="flex space-x-3 rtl:space-x-reverse"><button class="action-btn" type="button" onclick="openEditModal(this)"><iconify-icon icon="heroicons:pencil-square"></iconify-icon></button><button class="action-btn" type="button" onclick="handleBtnClick('${data.sname}', 2)"><iconify-icon icon="heroicons:trash"></iconify-icon></button></div>`
                ),
                // data.isDeleted == 1
                //   ? '<button type="button" class="text-primary-500"  onclick="handleBtnClick(\'' + data.sname + '\', 1)">Activate</button>'
                //   : '<div class="flex space-x-3 rtl:space-x-reverse">' +
                //   '<button class="action-btn" type="button" onclick="openEditModal(this)">' +
                //   '<iconify-icon icon="heroicons:pencil-square"></iconify-icon>' +
                //   '</button>' +
                //   '<button class="action-btn" type="button" onclick="handleBtnClick(\'' + data.sname + '\', 2)">' +
                //   '<iconify-icon icon="heroicons:trash"></iconify-icon>' +
                //   '</button>' +
                //   '</div>'
              ];

              var renderedRow = rowData.map(function (value, index) {
                var className = 'table-td';
                if (index === 0) {
                  className = 'table-td custom-class';
                }
                return '<td class="' + className + '">' + value + '</td>';
              });

              var rowHTML = '<tr class="even:bg-slate-50 dark:even:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700" ' +
                'data-no="' + (i + 1) + '" ' +
                'data-sid="' + data.id + '" ' +
                'data-country="' + data.country_name + '" ' +
                'data-state="' + data.state_name + '">' +
                renderedRow.join('') +
                '</tr>';

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
      },
      error: function (jqXHR, exception) {
        handleAjaxErr(jqXHR, exception);
      }
    });
  } else {
    showAlert('danger', 'Please select country first.');
  }
}

$("#countryName").change((e) => {
  getStateData(e.target.value)
})

$("#add_state_form").submit(function (e) {
  e.preventDefault();

  // Retrieve the form data
  const country_Name = $("#countryName").val();
  const state_Name = $("#stateName").val();
  if (country_Name != null && state_Name != '') {
    $(".btn-disabled").attr('disabled', true);
    $.ajax({
      url: base_url + admin_link + '/state/add_state',
      type: 'POST',
      data: { countryName: country_Name, stateName: state_Name },
      dataType: 'json',
      success: function (response) {
        // console.log(response)
        if (response[0].etype == 'success') {
          showAlert(response[0].etype, response[0].msg);

          $("#stateName").val("");
          getStateData(country_Name)
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

$("#EditStateData").submit(function (e) {
  e.preventDefault(); // Prevent the form from submitting normally
  const countryName = $("#EditcountryName").val();
  const stateName = $("#EditstateName").val();

  if (stateName != old_stateName) {
    if (countryName != null && stateName != '') {
      $(".btn-disabled").attr('disabled', true);
      // Update the table row with the new data
      $.ajax({
        url: base_url + admin_link + '/state/edit_state_data',
        type: 'POST',
        data: { sid: s_id, country: old_countryName, state: stateName },
        dataType: 'json',
        success: function (response) {
          // console.log(response)
          if (response[0].etype == 'success') {
            const row = $(".data-table tr[data-sid='" + s_id + "']");
            // Target the specific row using the data-cid attribute
            row.attr("data-state", stateName);

            row.find(".table-td:nth-child(3)").text(stateName);

            $('#edit_modal').modal('hide');
            $('#EditStateData')[0].reset();
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
      showAlert("danger", "Some data is missing.", "jsmodalerror");
    }
  } else {
    showAlert("info", "No changes were made to your information.", "jsmodalerror");
  }
});

$("#ChangeStateStatus").submit(function (e) {
  e.preventDefault();

  // Retrieve the form data
  const state_Name = $("#sname").val();
  const Type = $("#type").val();
  const Msg = $("#msg").val();
  const country_Name = $("#countryName").val();
  if (state_Name != '' && Type != '' && Msg != '') {
    $(".btn-disabled").attr('disabled', true);
    $.ajax({
      url: base_url + admin_link + '/state/change_state_status',
      type: 'POST',
      data: { sname: state_Name, type: Type, msg: Msg },
      dataType: 'json',

      success: function (response) {
        // console.log(response)
        if (response[0].etype == 'success') {
          showAlert(response[0].etype, response[0].msg,);
          $('#state_modal').modal('hide');
          $("#sname").val("");
          $("#type").val("");
          $("#msg").val("");

          getStateData(country_Name)
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

