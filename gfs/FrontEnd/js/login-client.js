$('#btn-login-client').click(function(){
    let parametros = $('#form-login').serialize();
    console.log('Login:' + parametros);

    $.ajax({
        url:"http://localhost/gfs/BackEnd/ajax/Usuarios/Class/index.php?action=login",
        type:'POST',
        data:parametros,
        dataType:'json',
        success: function(res){
            console.log("Respuesta del Servidor");
            console.log(res);

            if(res.Valido==1){
                window.location.href = 'http://localhost/gfs/FrontEnd/profile-client.php';
            }
        },error: function(error){
            console.error(error);
        }
    })
});

