(()=>{
    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=home",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            getProfileInformation();
            getAllProducts();
            getPromotions();
            fillHome(res);
        },error:function(error){
            console.error(error);
        }
    });
})();


function fillHome(res){
    $('#container-loader').css('display','none');
    $('#container-all').css('display','block');
    
    updateCarousel([res.referenceFolder,res.ActiveBanners]);
    $('#image-profile').attr('src',`../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res.referenceFolder}${res.ActiveLogotype}`);
    $('#nav-home-tab').html(res.nameCompany);
    console.log(res);
}

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
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=imagenProfile",
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


function getLogotypeForChange(){
    $('#image-modal-show').remove();
    $('#chage-image-profile').css('display','none');
    $('#modal-dialog-imgprofile').addClass('dialog-expand-modal');
    $('#modal-content-imgprofile').addClass('content-expand-modal');
    $('#content-img-profile').css('display','none');
    $('#header-buttonsProfile-actions').html('');
    $('#header-buttonsProfile-actions').prepend(`
    <label class="buttons-simple-cools" for="new-image-upload">Agregar Nueva Imagen</label>
    <button class="buttons-simple-cools" onclick="deleteShowSliders()">Eliminar Imagen</button>
    <button class="buttons-simple-cools" onclick="$('#image-profile-view').modal('hide')">Cerrar Ventana</button>
    `);
    $('#body-modal-viewprofile').append(`
        <div class="container" style="width: 1110px;">
            <div id="row-container-images" class="row">                	
            </div>
        </div>    
    `);
    $('#row-container-images').html('');
    $('#spinner-loader').css('left','45%');
    $('#spinner-loader').css('display','block');

    $('#modal-footer-profile').remove();

    $('#modal-content-imgprofile').append(`
        <div id="modal-footer-profile" class="modal-footer" style="width: 100%; border-top: none;">
        </div>`
    );
    
    $('#modal-footer-profile').append(`
        <button id="viewmore" type="button" onclick="getCheckBox()" class="btn btn-link view-more">Ver Mas</button>
        <button id="make-picture-profile" onclick="makePictureNewProfileImage()" type="button" class="btn btn-light" disabled='disabled'>Hacer Imagen de Perfil</button>
    `);
    
    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=allLogotypeData",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            $('#spinner-loader').css('display','none');
            $('#image-modal-show').css('display','none');
            let referenceFolder = res[0];
            let pathsLototype = res[1];
            for(let i=0; i<pathsLototype.length; i++){
                $('#row-container-images').append(`
                <div class="col-xl-3" style="margin-bottom: 2%;" onclick="sendPicture(${i})">
                    <span class="box list-logotype">
                        <img src='../BackEnd/ajax/Empresas/CompaniesImageDataBase/${referenceFolder}${pathsLototype[i]}'>
                    </span>
                    <label class="switch-imagen-delete">
                        <input type="checkbox" value='${i}'>
                        <span class="slider-delete-cheked slider round"></span>
                    </label>
                </div>
                `);
            }
            console.log(pathsLototype);
        },error:function(error){
            console.error(error);
        }
    });
}


function sendPicture(value){
    var parent = document.querySelector('#row-container-images');
    var inputs = parent.querySelectorAll('div');
    if($('#make-picture-profile').val()==''){
        $('#make-picture-profile').attr('value',value);
        $('#make-picture-profile').attr('disabled',false);
        $(inputs[value]).addClass('selected-image');
    }else{
        removeSelected = $('#make-picture-profile').val();
        $(inputs[removeSelected]).addClass('deselected-image');
        $(inputs[removeSelected]).removeClass('selected-image');
        $('#make-picture-profile').attr('value',value);
        $(inputs[value]).removeClass('deselected-image');
        $(inputs[value]).addClass('selected-image');
    }    
}

function makePictureNewProfileImage(){
    if($('#make-picture-profile').val()!=''){
        index = $('#make-picture-profile').val();
        $.ajax({
            url:"../BackEnd/ajax/Empresas/actions-company.php?action=changeImage&index="+index,
            type: "GET",
            dataType:"json",
            success:function(res){ //res es la respuesta (response)
                console.log('Respuesta del servidor:');
                $("#image-profile").fadeOut();
                $('#image-profile').attr('src',`../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res[0]}${res[1]}`);
                $("#image-profile").fadeIn("slow");
                console.log(res);
            },error:function(error){
                console.error(error);
            }
        });
    }
    
}


//Script para Leer el Logotipo
function sendNewLogotype(evt){
    var files = evt.target.files;

    if(files.length==1){
        var datasFile= new FormData();
        datasFile.append('Logotype',files[0]);
        sendFormDataAjax(datasFile);
    }
}

//Listo a la escucha de los input file
document.getElementById('new-image-upload').addEventListener('change', sendNewLogotype, false);


function sendFormDataAjax(datasFile){
    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=newLogotype",
        type: "POST",
        data: datasFile,
        dataType:"json",
        contentType:false,
        processData:false,
        cache:false,
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            getLogotypeForChange();
            $("#image-profile").fadeOut();
            $('#image-profile').attr('src',`../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res[0]}${res[1]}`);
            $("#image-profile").fadeIn("slow");
        },error:function(error){
            console.error(error);
        }
    });
}

function deleteShowSliders(){
    $('.switch-imagen-delete').css('display','block');
    $('#make-picture-profile').css('display','none');
    $('#viewmore').css('display','none');
    $('#modal-footer-profile').append(`
        <button type="button" onclick="" class="btn btn-light">Cancelar</button>
        <button id="deleteImage" onclick="queryDeleteImage()" type="button" class="btn btn-light">Eliminar Imagenes Seleccionadas</button>
    `);
}

        
function queryDeleteImage(){
    var parent = document.querySelector('#row-container-images');
    var inputCheckBox = parent.querySelectorAll('input');

    chekeds = [];
    for(let i=0; i<inputCheckBox.length; i++){
        if($(inputCheckBox[i]).prop('checked')){
            chekeds.push($(inputCheckBox[i]).val());
        }
    }
    
    getLogotypeForChange();
    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=deletePictures&picturesPathReference="+JSON.stringify(chekeds),
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            getLogotypeForChange();
            console.log(res);
        },error:function(error){
            console.error(error);
        }
    });
}
        
  function queryGetBanners(){
      $('.labels-active-banners').css('display','none');
      $('#banners-gestor-view').modal('show');
      $('#spinner-loader-banner').css('display','block');
      $('#container-banners-active').html('');
      $('#container-banners-for-select').html('');


      $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=getBanners",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            
            referenceFolder = res[0];
            var jsonarrayPath = [];
            if(res.length==3){
                pathBannersActives = res[1];
                pathBanner = res[2];
                for(let i=0; i<pathBannersActives.length;i++){
                    jsonarrayPath.push({'path':pathBannersActives[i],'Active':true});
                }

                for(let i=0; i<pathBanner.length;i++){
                    jsonarrayPath.push({'path':pathBanner[i],'Active':false});
                }
            }else if(res.length==2){
                pathBanner= res[1];
                for(let i=0; i<(pathBanner.length);i++){
                    jsonarrayPath.push({'path':pathBanner[i],'Active':true});
                }
            }

            
            $('#spinner-loader-banner').css('display','none');
            $('.labels-active-banners').css('display','block');
            
            for(let i=0; i<jsonarrayPath.length;i++){
                checkValue =  jsonarrayPath[i].path.split("/")[2];
                $(`#${(jsonarrayPath[i].Active)?'container-banners-active':'container-banners-for-select'}`).append(`
                <div class="col-xl-6 banner-stack" style="margin-bottom: 35px;">
                    <div class="box box-banner-select">
                        <img src="../BackEnd/ajax/Empresas/CompaniesImageDataBase/${referenceFolder}${jsonarrayPath[i].path}">
                    </div>
                    <label class="switch-imagen-banner switch-imagen-delete" style="display: block;">
                        <input type="checkbox" value="${checkValue}" ${(jsonarrayPath[i].Active)?'checked':''}>
                        <span class="slider-delete-cheked slider round"></span>
                    </label>
                </div>
                `);
            }

            $('#container-banners-active').css('display','block');
            $('#container-banners-for-select').css('display','block');

        },error:function(error){
            console.error(error);
        }
    });
 }


 //Script para Leer el Logotipo
function sendBanners(evt){
      $('.labels-active-banners').css('display','none');
      $('#banners-gestor-view').modal('show');
      $('#spinner-loader-banner').css('display','block');
      $('#container-banners-active').html('');
      $('#container-banners-for-select').html('');

    var files = evt.target.files;

    var datasFile= new FormData();

    for(let i=0; i<files.length; i++){
        datasFile.append('newBanner-'+i,files[i]);
    }

    console.log(datasFile.get('newBanner-0'));

    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=newBanner",
        type: "POST",
        data: datasFile,
        dataType:"json",
        contentType:false,
        processData:false,
        cache:false,
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            queryGetBanners();
            updateCarousel(res);
        },error:function(error){
            console.error(error);
        }
    });

}


//Listo a la escucha de los input file
document.getElementById('new-banner-upload').addEventListener('change', sendBanners, false);


function updateCarousel(activeBanners){
    referenceFolde = activeBanners[0];
    bannersActive = activeBanners[1];
    $("#carousel-items").fadeOut();
    $("#carousel-items").html('');
    $("#carousel-items").prepend(`
        <button class="buttons-simple-cools" id='banner-call-modal' onclick="queryGetBanners()">Cambiar Banners</button>
    `);
        for(let i=0; i<bannersActive.length; i++){
            $('#carousel-items').append(`
            <div class="carousel-item ${(i==0)?'active':''}">
                <div  class="container-fluid backgrounds-divs box">
                    <img src="../BackEnd/ajax/Empresas/CompaniesImageDataBase/${referenceFolde}${bannersActive[i]}" alt="">
                </div>
            </div>`);
        }   
    $("#carousel-items").fadeIn("slow");
    
}


function activeThisBanners(){
    var parent = document.querySelector('#container-banners-active');
    var checkBoxActive = parent.querySelectorAll('input');


    var parent = document.querySelector('#container-banners-for-select');
    var noActive = parent.querySelectorAll('input');


    chekeds = [];

    for(let i=0; i<checkBoxActive.length; i++){
        if($(checkBoxActive[i]).prop('checked')){
            chekeds.push($(checkBoxActive[i]).val());
        }
    }

    for(let i=0; i<noActive.length; i++){
        if($(noActive[i]).prop('checked')){
            chekeds.push($(noActive[i]).val());
        }
    }

    console.log(chekeds);
    if(chekeds.length<4 && chekeds.length!=0){
        $.ajax({
            url:"../BackEnd/ajax/Empresas/actions-company.php?action=changeBanner&nameElements="+JSON.stringify(chekeds),
            type:"POST",
            dataType: 'json',
            success: function(res){
                console.log("Respuesta Del Servidor");
                queryGetBanners();
                updateCarousel(res);
            }, error:function(error){
                console.error(error);
            }
        });
    }
    
}

function deleteBannersQuery(){
    var parent = document.querySelector('#container-banners-active');
    var checkBoxActive = parent.querySelectorAll('input');
    var disOpacity =  parent.querySelectorAll('div');
    chekeds = [];

    for(let i=0; i<checkBoxActive.length; i++){
        $(checkBoxActive[i]).prop('disabled',true);
        $(disOpacity[i]).css("opacity", 0.7);
    }

    var parent = document.querySelector('#container-banners-for-select');
    var otherChecks = parent.querySelectorAll('input');

    for(let i=0; i<checkBoxActive.length; i++){
        $(checkBoxActive[i]).prop('checked',false);
    }

    $("#modal-footer-banners").fadeOut();
    $("#modal-footer-banners").html('');
    $('#modal-footer-banners').append(`
        <button id="btn-active-banners" onclick="cancelDelete()" type="button" class="btn btn-light">Cancelar</button>
        <button id="btn-active-banners" onclick="queryDeleteBanners()" type="button" class="btn btn-light">Eliminar Banners Seleccionados </button>
    `);
    $("#modal-footer-banners").fadeIn('slow');
}



function queryDeleteBanners(){
    var parent = document.querySelector('#container-banners-for-select');
    var noActive = parent.querySelectorAll('input');

    chekeds = [];

    for(let i=0; i<noActive.length; i++){
        if($(noActive[i]).prop('checked')){
            chekeds.push($(noActive[i]).val());
        }
    }

    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=delete&nameElements="+JSON.stringify(chekeds),
        type:"DELETE",
        dataType: 'json',
        success: function(res){
            console.log("Respuesta Del Servidor");
            queryGetBanners();
            $("#modal-footer-banners").fadeOut();
            $("#modal-footer-banners").html('');
            $('#modal-footer-banners').append(`
                <button id="btn-active-banners" onclick="activeThisBanners()" type="button" class="btn btn-light">Activar Banners Seleccionados</button>
            `);
    $("#modal-footer-banners").fadeIn('slow');
        }, error:function(error){
            console.error(error);
        }
    });
    
}

function getProfileInformation(){
    $("#profile-content").css('display','none');
    $('.spinner-profile').css('display','block');
    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=profile",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            console.log(res);

            $('#img-profile-principal').attr('src',`../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res.Logotype}`);
            $('#name-company-label').html(`
            ${res.nameCompany}`);
            $('#email-label').html(`
            ${res.email}`);
            $('#mision').html(`
            ${res.mision}`);
            $('#vision').html(`
            ${res.vision}`);
            $('#phones-numbers').html(`
            ${res.number}`);
            $('#direction-description').html(`
            ${res.direction}`);
            addNewMarker(res.MakersMap);

            $('.spinner-profile').css('display','none');
            $("#profile-content").fadeIn("slow");
        },error:function(error){
            console.error(error);
        }
    });

    

}

var map;
function initMap() {
  var tgu = {lat: 14.1, lng: -87.2167};

  map = new google.maps.Map(document.getElementById('map'), {
    scaleControl: true,
    center: tgu,
    zoom: 15
  });
}

var map2;

function newMap(id){
    var tgu = {lat: 14.1, lng: -87.2167};
    map2 = new google.maps.Map(document.getElementById(id), {
        scaleControl: true,
        center: tgu,
        zoom: 15
      });

    // This event listener will call addMarker() when the map is clicked.
  map2.addListener('click', function(event) {
    addMarker(event.latLng);
  });
}

var markerAdd = [];
var markersJSON =[];

function addMarker(location) {
    var marker = new google.maps.Marker({
      position: location,
      map: map2
    });
    markerAdd.push(marker);
    markersJSON.push({'lat':location.lat(), 'lng': location.lng()});
  }


function addNewMarker(markers){
    for(let i=0; i<markers.length; i++){
        var marker = new google.maps.Marker({
            position: markers[i],
            map: map
        });  
    }
}

function activeDeleteAcountButton(){
    ($('#password-verify-account').val()!='')?$('#btn-delete-account').prop('disabled',false):$('#btn-delete-account').prop('disabled',true);
}

function queryDeleteAcount(){
    $.ajax({
        url:"../BackEnd/ajax/Empresas/index.php",
        type: "GET",
        data: {'delete':'b029b2f27f6b4b948fbc'},
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            console.log(res);
        },error:function(error){
            console.error(error);
        }
    });
}

function fieldUpdateGenerate(){

    $('#editInformation').css('display','none');
    $('#deleteAccount').css('display','none');
    $("#information-profile").fadeOut();
    $("#information-profile").css('display','none');

    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=all",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            response = res;

    $('#container-form-items').append(`       
    <form id="form-update" >
    <div class="row">
        <div class="col-xl-6 contain-fields">
            <label>Nombre de la Empresa</label><br>
            <input class="form-control" id="name-company" name="nameCompany" type="text" value="${response.nameCompany}" placeholder="Ideale">
                <div class="valid-feedback">
                    Ok
                </div>
                <div class="invalid-feedback">
                    Campo obligatorio
                </div>
            <label>Email</label>
                <div>
                    <input type="text" name="email" class="form-control" onkeyup="validarEmailEnLinea(this.value)" value="${response.email}" id="email" placeholder="Email">
                    <svg version="1.1" class="svg-verify" id="L4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                        <circle fill="#2C2C2C" stroke="none" cx="6" cy="50" r="6">
                            <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"></animate>    
                        </circle>
                        <circle fill="#2C2C2C" stroke="none" cx="26" cy="50" r="6">
                            <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2"></animate>       
                        </circle>
                        <circle fill="#2C2C2C" stroke="none" cx="46" cy="50" r="6">
                            <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3"></animate>     
                        </circle>
                    </svg>
                        <div class="valid-feedback">
                            Ok
                        </div>
                        <div class="invalid-feedback" id="email-invalid-feedback">
                            Campo obligatorio
                        </div>
                </div>
                <label>Numero Telefonico</label>
                <div class="mb-3"  id="phones-numbers-inputs">
                </div>
                <div class="input-group">
                    <input type="text" name="input-phone-principal" id="input-phone-principal" class="form-control" placeholder="Numero Telefonico" value="" aria-label="Numero Telefonico" aria-describedby="button-addon2">
                    <div class="input-group-append" id="button-addon4">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="addInputPhone()">+</button>
                        <button class="btn btn-outline-secondary" type="button" id="btn-remove-phone" onclick="removeInputPhone()" disabled="">-</button>
                    </div>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback" id="invalid-phone-feedback-0">
                        Campo obligatorio
                    </div>
                </div>
                <label>Direccion</label><br>
                <div>
                    <textarea id="text-direction" name="text-direction" class="form-control" rows="3">${response.direction}</textarea>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Campo obligatorio
                    </div>
                </div>
                <label>Pais</label>
                <div>
                    <select id="select-country" name="select-country" class="form-control" value='${response.country}'>
                        <option value="Honduras">Honduras</option>
                        <option value="CostaRica">Costa Rica</option>
                        <option value="Salvador">El Salvador</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Guatemala">Guatemala</option>
                    </select>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Campo obligatorio
                    </div>
                </div>
        </div>
            <div class="col-xl-6 map-position">
                <h2>Su Ubicacion</h2>
                <div id="floating-panel">
                    <input class="btn btn-outline-secondary" onclick="clearMarkers();" type="button" value="Esconder Marcadores">
                    <input class="btn btn-outline-secondary" onclick="showMarkers();" type="button" value="Mostrar Todos">
                    <input class="btn btn-outline-secondary" onclick="deleteMarkers();" type="button" value="Eliminar Marcadores">
                </div>
                <div id="map2" class="form-control" style="height: 500px;"></div>
                <p class="card-text" style="color: gray;">
                    Busque su Ubicacion y de click sobre ella para agregar la ubicacion
                </p>
                <div class="valid-feedback">
                    Ok
                </div>
                <div class="invalid-feedback">
                    Campo obligatorio
                </div>
            </div>
        </div>
        <div class="row information">
                <div class="col-xl-6">
                    <label style="font-size: 1.4rem; padding-left: 10px;">Mision</label>
                    <textarea class="form-control w-do-area" name="mision-textarea" id="mision-textarea" >${response.mision}</textarea>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Campo obligatorio
                    </div>
                </div>
                <div class="col-xl-6">
                    <label style="font-size: 1.4rem; padding-left: 10px;">Vision</label>
                    <textarea class="form-control w-do-area" name="vision-textarea" id="vision-textarea">${response.vision}</textarea>
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Campo obligatorio
                    </div>
                </div>
        </div>    
        <div class="row">
            <div class="row social">
                <span class="col-xl-4"><img src="icons/facebook-icon.svg" alt="" width="45px">
                    <input type="text" id="faceboox-textbox"  name="faceboox-textbox" onkeyup="validUrlFacebook(this.value)" value="${response.socialFacebook}" class="form-control social-input" placeholder="Facebook">
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Url de Facebook no valida
                    </div>
                </span> 
                <span class="col-xl-4"><img src="icons/twitter-icon.svg" alt="" width="45px">
                    <input type="text" id="twitter-textbox" name="twitter-textbox" onkeyup="validUrlTwitter(this.value)" value="${response.socialTwitter}" class="form-control social-input" placeholder="Twitter">
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Url de twitter no valida
                    </div>
                </span>
                <span class="col-xl-4"><img src="icons/instagram.svg" alt="" width="45px">
                    <input type="text" id="instagram-textbox" name="instagram-textbox" onkeyup="validUrlInstagram(this.value)" value="${response.socialInstagram}" class="form-control social-input" placeholder="Instagram">
                    <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Url de Instagram no valida
                    </div>
                </span> 
            </div>
            <div class="col-xl-12 btn-register-container" style="padding-left: 65%;">
                <button id="cancel-update" class="btn-yellow-uptdate" type="button" onclick="cancelUpdate()">Cancelar</button>
                <button id="btn-registrar" class="btn-yellow-uptdate" type="button" onclick="updateDataCompany()">Actualizar Informacion</button>
            </div>
            </div>
       </div>
    </form>   

    `);

    fillThisNumbers(response.number);
    newMap('map2');
    $('#container-form-items').css('border','1px solid #ececec');
    $('#container-form-items').fadeIn('slow');
    },error:function(error){
        console.error(error);
    }
    });
}


function cancelUpdate(){
    $('#container-form-items').html('');
    $('#editInformation').fadeIn('slow');
    $('#deleteAccount').fadeIn('slow');
    $("#information-profile").fadeIn('slow');
}

function fillThisNumbers(arrayNumbers){
    for(let i=0; i<(arrayNumbers.length-1);i++){
        $('#phone-'+addInputPhone()).attr('value',arrayNumbers[i]);
    }

    $('#input-phone-principal').attr('value',arrayNumbers[arrayNumbers.length-1]);
}

function addInputPhone(){
    var parent = document.querySelector('#phones-numbers-inputs');
    var inputs = parent.querySelectorAll('input');
  
    if(inputs.length<3){
      $('#phones-numbers-inputs').append(`
        <input type="text" id="phone-${inputs.length}" name="phone-${inputs.length}" class="form-control" placeholder="Numero Telefonico">
        `);
        $('#btn-remove-phone').attr('disabled',false);
      if(inputs.length==2){
        $('#button-addon2').attr('disabled',true);
      }
    }

    return inputs.length; 
  }
  
  function removeInputPhone(){
    var parent = document.querySelector('#phones-numbers-inputs');
    var inputs = parent.querySelectorAll('input');
  
    $('#phone-'+ (inputs.length-1)).remove();
    $('#button-addon2').attr('disabled',false);
  
    if((inputs.length-1)==0){
      $('#btn-remove-phone').attr('disabled',true);
    }
  }


  // Sets the map on all markers in the array.
  function setMapOnAll(map2) {
    for(var i = 0; i < markerAdd.length; i++) {
        markerAdd[i].setMap(map2);
    }
    console.log(markersJSON);
  }
  
  // Removes the markers from the map, but keeps them in the array.
  function clearMarkers() {
    setMapOnAll(null);
  }
  
  // Shows any markers currently in the array.
  function showMarkers() {
    setMapOnAll(map2);
  }
  
  // Deletes all markers in the array by removing references to them.
  function deleteMarkers() {
    clearMarkers();
    markerAdd = []
    markersJSON = [];
  }


  function updateDataCompany(){
    //Todos los campos del Formulario
    var fields = [
      {nameField: 'nameCompany', field:'name-company', fill: false},
      {nameField: 'email', field:'email', fill: false},
      {nameField: 'number', field:'input-phone-principal', fill: false},
      {nameField: 'direction', field:'text-direction', fill: false},
      {nameField: 'country', field:'select-country', fill: false},
      {nameField: 'latLng', field:'map2', fill: false},
      {nameField: 'mision', field:'mision-textarea', fill: false},
      {nameField: 'vision', field:'vision-textarea', fill: false},
      {nameField: 'socialFacebook', field:'faceboox-textbox', fill: false},
      {nameField: 'socialTwitter', field:'twitter-textbox', fill: false},
      {nameField: 'socialInstagram', field:'instagram-textbox', fill: false}
    ];

    let inputNumbers = [];

    for(let i=0; i<fields.length; i++){
      if(fields[i].field=='email'){
        fields[i].fill = validarEmailEnLinea($('#email').val());
      }else if(fields[i].field=='input-phone-principal'){
        fields[i].fill = validNumberPhones(fields[i].field);
        var parent = document.querySelector('#phones-numbers-inputs');
        var inputs = parent.querySelectorAll('input');

        for(let i=0; i<inputs.length; i++){
          inputNumbers.push({nameField: 'phone-'+i, field:'phone-'+i, fill: validNumberPhones(inputs[i].id)});
        }

      }else if(fields[i].field=='select-country'){
        if($('#select-country').val()!='empty'){
          fields[i].fill = markInput(fields[i].field);
        }else{
          fields[i].fill = false;
          document.getElementById('select-country').classList.remove('is-valid')
          document.getElementById('select-country').classList.add('is-invalid');
        }
      }else if(fields[i].field=='map2'){
        if(markersJSON.length==0){
          $('#map2').removeClass('is-valid');
          $('#map2').addClass('is-invalid');
          goErrorFocus('map2'); 
          return;
        }else{
          $('#map2').removeClass('is-invalid');
          $('#map2').addClass('is-valid')
          fields[i].fill = true;
        }
      }else if(fields[i].field=='faceboox-textbox'){
        fields[i].fill = validUrlFacebook($('#'+fields[i].field).val());     
      }else if(fields[i].field=='twitter-textbox'){
        fields[i].fill = validUrlTwitter($('#'+fields[i].field).val());
      }else if(fields[i].field=='instagram-textbox'){
        fields[i].fill = validUrlInstagram($('#'+fields[i].field).val());
      }else{
        fields[i].fill = markInput(fields[i].field);
      }
    }

    for(let i=0; i<inputNumbers.length;i++){
        fields.push(inputNumbers[i]);
    }

    var data = getDataImageFile(fields);



    if(data.readyForSend){
        fields = $('#form-update').serialize();
        fields += '&latLng='+JSON.stringify(markersJSON);
        console.log(JSON.stringify(markersJSON));
        console.log(fields);
        $.ajax({
            url:'http://localhost/gfs/BackEnd/ajax/Empresas/?action=updateData',
            typeData:'json',
            data:fields,
            type:'PUT',
            success: function(res){
                console.log("Respuesta del Servidor");
                if(res){
                    $('#container-form-items').html('');
                    $('#editInformation').fadeIn('slow');
                    $('#deleteAccount').fadeIn('slow');
                    $("#information-profile").fadeIn('slow');
                }
            },error:function(error){
                console.error(error);
            }
        });   
    }
}


function getDataImageFile(fields){
    let readyForSend;
    for(let i=0; i<fields.length; i++){
      if(fields[i].fill){
        readyForSend = true;
      }else{
        console.log('Algunos campos Son Obligatorios, Verifique su informacion de registro');
        readyForSend = false;
        goErrorFocus(fields[i].field); 
        return data = {'readyForSend':readyForSend};
      } 
    }
  
    return {'readyForSend':readyForSend};
  }


  function markInput(id){
    valid = ($('#'+id).val()==''?false:true);
  
    if (valid){
        document.getElementById(id).classList.remove('is-invalid');
        document.getElementById(id).classList.add('is-valid');
    }else{
        document.getElementById(id).classList.remove('is-valid');
        document.getElementById(id).classList.add('is-invalid');        
    }
    
    return valid;
  }

  function validarEmailEnLinea(email){
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    let resultado =  re.test(email);
    if(!resultado){
      document.getElementById('email-invalid-feedback').innerHTML = "Correo Inválido";
    }
    return validShowMessage('email',resultado);
  }

  function validNumberPhones(idPhone){
    let regex = /^[\(]?[\+]?(\d{2}|\d{3})[\)]?[\s]?((\d{6}|\d{8})|(\d{3}[\*\.\-\s]){2}\d{3}|(\d{2}[\*\.\-\s]){3}\d{2}|(\d{4}[\*\.\-\s]){1}\d{4})|\d{8}|\d{10}|\d{12}$/;
    let res = regex.test($('#'+idPhone).val());
    if(!res){
      document.getElementById('input-phone-principal').classList.remove('is-valid');
      document.getElementById(idPhone).classList.remove('is-valid');
      document.getElementById('invalid-phone-feedback-0').innerHTML = "Los numero telefonicos no deben contener espacios, ni letras";
      document.getElementById('invalid-phone-feedback-0').style.display = "block";
    }else{
      document.getElementById('invalid-phone-feedback-0').style.display = "none";
      document.getElementById(idPhone).classList.remove('is-invalid');
      document.getElementById(idPhone).classList.add('is-valid');
    }
    return res;
  }
  
  
  function validUrlFacebook(urlFacebool){
    regexFacebookUrl = /^(https?:\/\/)?(www\.)?facebook.com\/[a-zA-Z0-9(\.\?)?]/;
    let result = regexFacebookUrl.test(urlFacebool);
    
    return validShowMessage('faceboox-textbox',result);
  }
  
  function validUrlTwitter(urlTwitter){
    regexTwitterUrl = /http(?:s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/;
    let result = regexTwitterUrl.test(urlTwitter);
    
    return validShowMessage('twitter-textbox',result);
  }
  
  function validUrlInstagram(urlInstagram){
    regexInstagramUrl = /http(?:s)?:\/\/(?:www\.)?instagram\.com\/([a-zA-Z0-9_]+)/;
    let result = regexInstagramUrl.test(urlInstagram);
    return validShowMessage('instagram-textbox',result);
  }
  
  //Funcion que se usa para validar el resultado del email y el password
  function validShowMessage(id,valid){
      if(valid){
        document.getElementById(id).classList.remove('is-invalid');
        document.getElementById(id).classList.add('is-valid');
      }else{
        document.getElementById(id).classList.remove('is-valid');
        document.getElementById(id).classList.add('is-invalid');      
      }
  
      return valid;
  }
  
  function emailExistAndCreate(verify){
    if(!verify){
        $('#email').removeClass('is-valid');
        if(!$('#email').hasClass('is-invalid')){
            $('#email').addClass('is-invalid');
        }
        $('#email-invalid-feedback').html(`<span><i class="fas fa-exclamation-circle"></i></span> 
        &nbsp Este Correo Ya Esta En Uso, Pruebe Otro.`);
    }else{
        if(!$('#email').hasClass('is-valid')){
            $('#email').addClass('is-valid');
        }
    }
  }



  function logout(){
    $.ajax({
        url:'http://localhost/gfs/BackEnd/ajax/Empresas/actions-company.php?action=logout',
        typeData:'json',
        type:'GET',
        success: function(res){
            console.log("Respuesta del Servidor");
            if(res){
                window.location.href = 'http://localhost/gfs/FrontEnd/GiPoHome.html';
            }
        },error:function(error){
            console.error(error);
        }
    });
  }



  function goErrorFocus(id){
    $('html, body').animate({
      scrollTop: $("#"+id).offset().top
      }, 1000);
  }






 





