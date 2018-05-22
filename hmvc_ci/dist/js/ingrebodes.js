//Se invoca el controlador de consulta de Ingredientes por Bodega.
function consultaIngreBode(urlBase){
    //Se obtienen los valores digitados en el campo de búsqueda.
    var ingrebode_valor = document.getElementById('ingrebode-valor').value;
    ingrebode_valor     = $.trim(ingrebode_valor);
    $.ajax({
        url:urlBase+'ingrebodes/seleccionarIngreBode',
        async:false,
        data:{
            ingrebode_valor:ingrebode_valor
        },
        type:'POST',
        success:function(select){
            try{
                if(select !== "false"){
                    document.getElementById('ingrebodes').innerHTML = "";
                    document.getElementById('ingrebodes').innerHTML = select;
                }
                else{
                    alert("No se encontraron datos.");
                }
            }
            catch(err){
                alert(err);
            }
        }
    });
}