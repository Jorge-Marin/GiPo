$('#btn-login').click(function(){
    let parametros = $('#form-login').serialize();
    console.log('Login:' + parametros);

    $.ajax({
        url:"http://localhost/gfs/BackEnd/ajax/Empresas/?accion=login",
        type:'POST',
        data:parametros,
        dataType:'json',
        success: function(res){
            console.log("Respuesta del Servidor");
            console.log(res);

            if(res.Valido==1){
                window.location.href = 'http://localhost/gfs/FrontEnd/perfil-compa%c3%b1ia.php';
            }
        },error: function(error){
            console.error(error);
        }
    })


});