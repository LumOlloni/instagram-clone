//
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#search').keyup(function(){
        var search = $('#search').val();
        var ul = $('#usersList');
        if(search==""){
            $("#usersList").html("");
            $('#result').hide();
        }
        else{
            $.get("/search",{search:search}, function(data){
                console.log(data);
                $('#usersList').empty().html(data);
                $('#result').show();
            })
        }
    });
});
