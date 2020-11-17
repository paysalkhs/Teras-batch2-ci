$(document).ready(function(){
    $("#form").submit(function(e){
        e.preventDefault();
        $.ajax({
            url: base_url+'welcome/login_process',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                let json = JSON.parse(data);
                if(json.status === true){
                    window.location.reload();
                }else{
                    if(json.type === 'validation'){
                        $.each(json.data,function(i,v){
                            $("#error_"+i).html(v);
                        })
                    }
                }
            },error: function(err){
                console.log(err);
            }
        })
    })
})