$(function () {
    $("#datatable1").DataTable();
});

//Initialize Select2 Elements
$('.select2').select2();

//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
});

$('[data-toggle="tooltip"]').tooltip();

function get_zone(selected_city, zone_name) {

    // console.log(base_url + admin_link + '/add_manager/get_zone');
    var city_id = $(selected_city).val();
    $.ajax({
        type: 'POST',
        url: base_url + admin_link + '/add_manager/get_zone',
        data: 'city_id=' + city_id,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {
            var otpstr = '<option value="0">Select Zone</option>';
            for (var i = 0; i < data.length; i++) {
                otpstr += '<option value="' + data[i]["id"] + '">' + data[i]["zone"] + '</option>';
            }

            $('#user_zone').html(otpstr);
        }
    });
}