
function getImageProfile(){
    $('#image-profile-view').modal('show');
    $('#header-buttonsProfile-actions').empty();
    $('#body-modal-viewprofile').empty();
    $('#modal-dialog-imgprofile').removeClass('dialog-expand-modal');
    $('#modal-content-imgprofile').removeClass('content-expand-modal');
    $('#header-buttonsProfile-actions').append(`
        <button id="chage-image-profile" class="buttons-simple-cools" onclick="getLogotypeForChange()">Cambiar Imagen</button>
        <button class="buttons-simple-cools" onclick="$('#image-profile-view').modal('hide')">Cerrar Ventana</button>
    `);
    $('#body-modal-viewprofile').append(`
        <div id="spinner-loader" class="spinner-border" role="status" style="left= 40%;">
            <span class="sr-only">Loading...</span>
        </div>
    `);

    $('#modal-footer-profile').remove();
    
    
    
    $.ajax({
        url:"../BackEnd/ajax/Usuarios/actions-user.php?action=imagenProfile",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            $('.spinner-border').css('display','none');
            $('#body-modal-viewprofile').append(`
                <div id="content-img-profile" class="box profile-view-image">
                    <img id='image-modal-show' src="" ></img>
                </div>
            `);
            $('#image-modal-show').attr('src',`../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res[0]}${res[1]}`);
            $('#image-modal-show').css('display','block');
        },error:function(error){
            console.error(error);
        }
    });

}
