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

function get_zone(selected_city,zone_name) {

    console.log(base_url + admin_link + '/add_teamleader/get_zone');
    var city_id=$(selected_city).val();
    $.ajax({
        type: 'POST',
        url: base_url + admin_link + '/add_teamleader/get_zone',
        data: 'city_id=' + city_id,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {
            var otpstr = '<option value="0">Select Zone</option>';
            for (var i = 0; i < data.length; i++) {
                otpstr += '<option value="'+data[i]["id"]+'">'+data[i]["zone"]+'</option>';
            }

            $('#user_zone').html(otpstr);
        }
    });
}

function get_manager_and_area(selected_zone,zone_name) {

    console.log(base_url + admin_link + '/add_teamleader/get_manager_and_area_byzone');
    var zone_id=$(selected_zone).val();
    $.ajax({
        type: 'POST',
        url: base_url + admin_link + '/add_teamleader/get_manager_and_area_byzone',
        data: 'zone_id=' + zone_id,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {
            console.log(data.manager.length);
            var manager_str = '<option value="0">Select Manager</option>';
            for (var i = 0; i < data.manager.length; i++) {
                manager_str += '<option value="'+data.manager[i]["user_id"]+'">'+data.manager[i]["user_fname"] +'  '+ data.manager[i]["user_lname"] +'</option>';
            }

            var area_str = '<option value="0">Select Area</option>';;
            for (var i = 0; i < data.area.length; i++) {
                area_str += '<option value="'+data.area[i]["id"]+'">'+data.area[i]["area"]+'</option>';
            }

            $('#manager').html(manager_str);
            $('#user_area').html(area_str);
        }
    });
}

function get_supervisor(id,type) {
    console.log("here");
    var id=$(id).val();
    var call_url='';
    var admin_link = 'Manager';
    var base_url = 'https://calienteitech.in/greenenergy/';

    //console.log("id : "+id+" type : "+type);
    if (type == 1) {
        call_url ="get_supervisor_by_area";
        get_locality(id);
    }else{
        call_url = "get_supervisor_by_manager";
    }

    $.ajax({
        type: 'POST',
        url: base_url + admin_link + '/manage_tl/'+call_url,
        data: 'id=' + id,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {
            
            //console.log(data);
            var supervisor_str = '<option value="0">Select Area</option>';;
            for (var i = 0; i < data.length; i++) {
                console.log(data[i]["id"]);
                //supervisor_str += '<option value="'+data[i]["id"]+'">'+data[i]["user_fname"] +'  '+ data[i]["user_lname"] +'</option>';
                supervisor_str += '<option value="'+data[i]["id"]+'">'+data[i]["fullname"] +'</option>';
            }

            $('#supervisor').html(supervisor_str);
        }
    });
}

function get_locality(id) {
    console.log("here");
    
    var admin_link = 'Manager';
    var base_url = 'https://calienteitech.in/greenenergy/';
    $.ajax({
        type: 'POST',
        url: base_url + admin_link + '/manage_tl/get_locality_by_area',
        data: 'id=' + id,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {
            console.log(data);
            var locality_str = '<option value="0">Select Area</option>';;
            for (var i = 0; i < data.length; i++) {
                locality_str += '<option value="'+data[i]["id"]+'">'+data[i]["locality"]  +'</option>';
            }

            $('#user_locality').html(locality_str);
        }
    });
}