let c_id, old_countryName, old_stateName, old_cityName;

$('#city_modal').on('hide.bs.modal', function (e) {
  $('#cname').val('');
  $('#type').val('');
  $('#msg').val('');
});

$("#add_city_form").validate({
  errorElement: "span",
  rules: {
    countryName: {
      required: true
    },
    stateName: {
      required: true,
    },
    cityName: {
      required: true,
      pattern: /^[a-zA-Z ]+$/
    }
  },
  messages: {
    countryName: "Please select country",
    stateName: {
      required: "Please select state",
    },
    cityName: {
      required: "Please enter city name",
      pattern: "Only alphabetical characters are allowed."
    }
  }
});

function handleBtnClick(countryName, type) {
  let submitBtnText;
  switch (type) {
    case 1:
      submitBtnText = 'Activate';
      $('#city_modal').modal('show');
      $('#city_modal .header').text('Type "YES" to Activate this City');
      break;
    case 2:
      submitBtnText = 'Delete';
      $('#city_modal').modal('show');
      $('#city_modal .header').text('Type "YES" to Delete this City');
      break;
    default:
      return;
  }
  $('#cname').val(countryName);
  $('#type').val(type);
  $('#confirm_btn').text(submitBtnText);
}

function getCityData(stateName) {
  $.ajax({
    url: base_url + admin_link + '/city/get_city',
    type: 'POST',
    data: {
      state_name: stateName
    },
    dataType: 'json',
    success: function (response) {
      // console.log(response);
      if (response[0].etype == 'success') {
        var table = $(".data-table").DataTable();
        // table.ajax.reload(null, false); // Reload the table without resetting the current page
        table.clear().draw(); // Clear the existing data

        if (response[0]?.data?.length > 0) {

          response[0].data.forEach(function (data, i) {
            var rowData = [
              i + 1,
              data.country_name ? data.country_name : '-',
              data.state_name ? data.state_name : '-',
              data.city_name ? data.city_name : '-',
              data.isDeleted == 1 ? (
                `<button type="button" onclick="handleBtnClick('${data.cname}', 1)">Activate</button>`
              ) : (
                `<div class="flex space-x-3 rtl:space-x-reverse"><button class="action-btn" type="button" onclick="openEditModal(this)"><iconify-icon icon="heroicons:pencil-square"></iconify-icon></button><button class="action-btn" type="button" onclick="handleBtnClick('${data.cname}', 2)"><iconify-icon icon="heroicons:trash"></iconify-icon></button></div>`
              ),
              // data.isDeleted == 1
              //   ? '<button type="button"  onclick="handleBtnClick(\'' + data.cname + '\', 1)">Activate</button>'
              //   : '<div class="flex space-x-3 rtl:space-x-reverse">' +
              //   '<button class="action-btn" type="button" onclick="openEditModal(this)">' +
              //   '<iconify-icon icon="heroicons:pencil-square"></iconify-icon>' +
              //   '</button>' +
              //   '<button class="action-btn" type="button" onclick="handleBtnClick(\'' + data.cname + '\', 2)">' +
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
              'data-cid="' + data.id + '" ' +
              'data-country="' + data.country_name + '" ' +
              'data-state="' + data.state_name + '" ' +
              'data-city="' + data.city_name + '">' +
              renderedRow.join('') +
              '</tr>';

            table.row.add($(rowHTML));
          });

          table.draw(); // Redraw the table with the new data
          table.columns.adjust(); // Adjust the columns
        }
      } else {
        showAlert('danger', "hello");
      }
    },
    error: function (jqXHR, exception) {
      handleAjaxErr(jqXHR, exception);
    }
  });
}

$("#countryName").change((e) => {
  $.ajax({
    url: base_url + admin_link + '/city/get_state_data',
    type: 'POST',
    data: {
      country_name: e.target.value
    },
    dataType: 'json',
    success: function (response) {
      // console.log(response)
      if (response[0].etype == 'success') {
        $('#stateName').empty();
        let str = `<option selected disabled class="inline-block font-Inter font-normal text-sm text-slate-600">
                      Select state
                    </option>`;
        $.each(response[0]?.data, function (key, value) {
          str += '<option value="' + value.state_name + '">' + value.state_name + '</option>';
        })
        $('#stateName').append(str);
      } else {
        showAlert('danger', "hello");
      }
    },
    error: function (jqXHR, exception) {
      handleAjaxErr(jqXHR, exception);
    }
  })
})

$("#stateName").change((e) => {
  getCityData(e.target.value)
})

function openEditModal(button) {
  var row = $(button).closest('tr'); // Get the closest parent table row
  c_id = row.data('cid');
  old_countryName = row.attr('data-country');
  old_stateName = row.attr('data-state');
  old_cityName = row.attr('data-city');

  $('#EditcountryName').val(old_countryName);
  $('#EditstateName').val(old_stateName);
  $('#EditcityName').val(old_cityName);
  $('#edit_modal').modal('show');
}

$("#add_city_form").submit(function (e) {
  e.preventDefault();

  // Retrieve the form data
  const country_Name = $("#countryName").val();
  const state_Name = $("#stateName").val();
  const city_Name = $("#cityName").val();
  if (country_Name !== '' && state_Name !== '' && city_Name) {
    $(".btn-disabled").attr('disabled', true);
    $.ajax({
      url: base_url + admin_link + '/city/add_city',
      type: 'POST',
      data: { countryName: country_Name, stateName: state_Name, cityName: city_Name },
      dataType: 'json',
      success: function (response) {
        // console.log(response)
        if (response[0].etype == 'success') {
          showAlert(response[0].etype, response[0].msg);
          $("#cityName").val("");
          getCityData(state_Name)
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

$("#EditCityData").submit(function (e) {
  e.preventDefault();

  // Retrieve the form data
  const countryName = $("#EditcountryName").val();
  const stateName = $("#EditstateName").val();
  const cityName = $("#EditcityName").val();
  if (cityName != old_cityName) {
    if (countryName !== '' && stateName !== '' && cityName !== '') {
      $(".btn-disabled").attr('disabled', true);
      $.ajax({
        url: base_url + admin_link + '/city/edit_city_data',
        type: 'POST',
        data: { cid: c_id, state: stateName, city: cityName },
        dataType: 'json',
        success: function (response) {
          // console.log(response)
          if (response[0].etype == 'success') {
            const row = $(".data-table tr[data-cid='" + c_id + "']");

            // Target the specific row using the data-cid attribute
            row.attr("data-city", cityName);

            row.find(".table-td:nth-child(4)").text(cityName);
            $('#edit_modal').modal('hide');
            $('#EditCityData')[0].reset();
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

$("#ChangeCityStatus").submit(function (e) {
  e.preventDefault();

  // Retrieve the form data
  const city_Name = $("#cname").val();
  const Type = $("#type").val();
  const Msg = $("#msg").val();
  const state_Name = $("#stateName").val();

  if (city_Name !== '' && Type !== '' && Msg !== '') {
    $(".btn-disabled").attr('disabled', true);
    $.ajax({
      url: base_url + admin_link + '/city/change_city_status',
      type: 'POST',
      data: { cname: city_Name, type: Type, msg: Msg },
      dataType: 'json',
      success: function (response) {
        // console.log(response)
        if (response[0].etype == 'success') {
          showAlert(response[0].etype, response[0].msg,);
          $('#city_modal').modal('hide');
          $("#cname").val("");
          $("#type").val("");
          $("#msg").val("");

          getCityData(state_Name)
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