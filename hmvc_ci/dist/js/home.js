function ini(){
    alert("ini");
}

function logOut(urlBase,urlMetodo){
    $.ajax({
        url:urlBase+urlMetodo,
        async:false,
        data:{
        },
        type:'POST',
        success:function(result){
            if(result == "true"){
                document.location.href=urlBase+'contenedor/';
            }
            else{
                document.location.href=urlBase+'home/';
            }
        }
    });
}

function llamarMetodo(urlBase,urlMetodo){
    $.ajax({
        url:urlBase+urlMetodo,
        async:false,
        data:{
        },
        type:'POST',
        success:function(result){
            document.getElementById('page-wrapper').innerHTML = "";
            document.getElementById('page-wrapper').innerHTML = result;
        }
    });
}