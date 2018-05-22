$(document).ready(ini);

function ini(){
    $("#btn-login").click(validar);
}

function validar(){
	var usuario = $("#login-username").val();
    var pass = $("#login-password").val();
    alert(result);
    $.ajax({
        url:"login.php",
        success:function(result){
            alert(result);
			/*if(result =="true"){
               document.location.href="admin.php";    
            }else{
                $("#resultado").html("<div class='alert alert-danger' role='alert'><b>acceso denegado, </b>no se pudo comprobar el usuario</div>");
            }*/
        }/*,
        data:{
            usuario:usuario,
            pass:pass
        },
        type:"POST"*/
    });
}