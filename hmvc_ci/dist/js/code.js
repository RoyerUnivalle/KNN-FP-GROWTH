function ini(){
    alert("ini");
}

function validaUsuario(urlBase){
    var login = document.getElementById('login-username').value;
    var passwd = document.getElementById('login-password').value;
    login = $.trim(login);
    passwd = $.trim(passwd);
    $.ajax({
        url:urlBase+'login/',
        async:false,
        data:{
            username:login,
            password:passwd
        },
        type:'POST',
        success:function(result){
            if(result === "true"){
                document.location.href=urlBase+'home/';
            }
            else{
                document.location.href=urlBase;
            }
        }
    });
}