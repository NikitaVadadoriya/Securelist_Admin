
 $('.select2').select2();
 $('.select2bs4').select2({
    theme: 'bootstrap4'
});

$(function () {
    $("#example1").DataTable();   
});

function get_locality(id) {
    console.log(base_url + user_type + '/s_current_status/get_locality');
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
        url: base_url + user_type + '/s_current_status/get_locality',
        data: 'id=' + selected,
        // contentType: "application/json",
        dataType: "json",
        success: function (data) {           
            var locality_str = '<option value="0">All</option>';
            
            for (var i = 0; i < data.length; i++) {
                for(var j = 0; j < data[i].length;j++){
                    locality_str += '<option value="'+data[i][j]["id"]+'">'+data[i][j]["locality"]  +'</option>';
                }
            }
            $('#user_area_all').val('');
            $('#user_locality').html(locality_str);
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