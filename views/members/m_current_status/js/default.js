
 $('.select2').select2();
 $('.select2bs4').select2({
    theme: 'bootstrap4'
});

var uluru = {lat: -25.344, lng: 131.036};

$(function () {
    $("#example1").DataTable(); 
      
});

$( document ).ready(function() {
    console.log( "ready!" );
    var map = new google.maps.Map(document.getElementById('googleMap'), {
        zoom: 4,
        center: uluru
      });
});

function get_area(id) {
    
    var selected = $(id).val();

    // console.log(selected.indexOf("0"));

    if (selected.indexOf("0") == 0) {  
        selected = '0';      
        // var values = [];
        // $("#user_area option").each(function(){
        //     // Add $(this).val() to your list
        //     if ($(this).val() != 0) {
        //         console.log($(this).val());
        //         values.push($(this).val());
        //         // value = $(this).val();
                
        //     }
        // });       
        
    }
    
    $.ajax({

        type: 'POST',
        url: base_url + user_type + '/m_current_status/get_area',
        data: 'id=' + selected,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {   
            console.log(data);
            var locality_str = '<option value="0">All</option>';
            
            for (var i = 0; i < data.length; i++) {
                for(var j = 0; j < data[i].length;j++){
                    locality_str += '<option value="'+data[i][j]["id"]+'">'+data[i][j]["area"]  +'</option>';
                }
            }
            $('#user_area_all').val('');
            $('#user_area').html(locality_str);
        }
    });
}

function get_locality(id) {
    
    var selected = $(id).val();

    // console.log(selected.indexOf("0"));

    if (selected.indexOf("0") == 0) {  
        selected = '0';      
        // var values = [];
        // $("#user_area option").each(function(){
        //     // Add $(this).val() to your list
        //     if ($(this).val() != 0) {
        //         console.log($(this).val());
        //         values.push($(this).val());
        //         // value = $(this).val();
                
        //     }
        // });       
        
    }
    
    $.ajax({

        type: 'POST',
        url: base_url + user_type + '/m_current_status/get_locality',
        data: 'id=' + selected,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {           

            console.log(data["locality_list"]);
            var locality_str = '<option value="0">All</option>';
            
            for (var i = 0; i < data["locality_list"].length; i++) {
                console.log(data["locality_list"][i]['locality']);
                locality_str += '<option value="'+data["locality_list"][i]["id"]+'">'+data["locality_list"][i]["locality"]  +'</option>';                
            }

            $('#user_locality').html(locality_str);
            locality_str = '<option value="0">All</option>';
            for (var i = 0; i < data["superviosr_list"].length; i++) {
                locality_str += '<option value="'+data["superviosr_list"][i]["id"]+'">'+data["superviosr_list"][i]["fullname"]  +'</option>';                
            }
            $('#user_supervisor').html(locality_str);
            
        }
    });
}

function get_tl(id) {
   
    var selected = $(id).val();

    console.log(selected.indexOf("0"));

    if (selected.indexOf("0") == 0) { 
        selected = '0';             
        // var values = [];
        // $("#user_locality option").each(function(){
        //     // Add $(this).val() to your list
        //     if ($(this).val() != 0) {
        //         console.log($(this).val());
        //         values.push($(this).val());
        //         // value = $(this).val();
                
        //     }
        // });       
        // $('#user_locality_all').val(values);
    }else{
        console.log('here');
        $.ajax({

            type: 'POST',
            url: base_url + user_type + '/s_current_status/get_locality',
            data: 'id=' + selected,
            // contentType: "application/json",
            dataType: "json",
            success: function (data) {           
                var locality_str = '<option value="0">All</option>';;
                for (var i = 0; i < data.length; i++) {
                    for(var j = 0; j < data[i].length;j++){
                        locality_str += '<option value="'+data[i][j]["id"]+'">'+data[i][j]["locality"]  +'</option>';
                    }
                }
                // $('#user_locality_all').val('');
                $('#team_leader').html(locality_str);
            }
        });
    }
}

function myMap() {
    var uluru = {lat: -25.344, lng: 131.036};
  // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('googleMap'), {zoom: 4, center: uluru});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: uluru, map: map});
}