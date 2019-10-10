//Inicializacion del Mapa
var map;
var markers = [];
var markersJSON = [];

function initMap() {
  var tgu = {lat: 14.1, lng: -87.2167};

  map = new google.maps.Map(document.getElementById('map'), {
    scaleControl: true,
    center: tgu,
    zoom: 15
  });


  // This event listener will call addMarker() when the map is clicked.
  map.addListener('click', function(event) {
    addMarker(event.latLng);
  });

}

// Adds a marker to the map and push to the array.
function addMarker(location) {
  var marker = new google.maps.Marker({
    position: location,
    map: map
  });
  markers.push(marker);
  markersJSON.push({'lat':location.lat(), 'lng': location.lng()});
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
  setMapOnAll(null);
  markersJSON = [];
}

// Shows any markers currently in the array.
function showMarkers() {
  setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  clearMarkers();
  markers = [];
}

//Script para Leer los Banners
function putBannerBackground(evt) {
    var files = evt.target.files; 
    
    //Si se qesea ingresar mas de tres banner muestra un mensaje del tamaño limite
    if(files.length>3){
     
      $("#alert-files-size" ).fadeIn("slow", function(){
      });

      //Temporizador para Esconde el Mensaje
      setTimeout(function(){ 
        $("#alert-files-size").fadeOut( "slow", function() {
      });}, 5000);

    }else{
      //Si el tamaño es correcto comienza a leer el FileList Object
      for (let i = 0, f; f = files[i]; i++){
        
        // Solo para procesar las imagenes
        if (!f.type.match('image.*')){
          continue;
        }
  
        var reader = new FileReader();
        //Se esconce el mensaje del Banner
        document.getElementById('div-message-publicity').style.display = 'none';
  

        //Se llena el carousel con Html
        if(i==0){
          $('#ol-indicators').append(`
          <li data-target="#banner" data-slide-to="${i}" class="active"></li>`);
        }else{
          $('#ol-indicators').append(`
          <li data-target="#banner" data-slide-to="${i}"></li>`);
        }
        
        if(i==0){
          // Aqui se lee la data url de las imagenes.
            reader.onload = (function(theFile){
            return function(e){

              $('#carousel-image').append(
                `<div class="carousel-item container-wallpaper active position-carousel">
                <img src="${e.target.result}" class="d-block w-100">
              </div>`
              ); 
            };
          })(f);
          }else{
          // Aqui se lee la data url de las imagenes.
           reader.onload = (function(theFile){
            return function(e){
              // Render thumbnail.  
              $('#carousel-image').append(
                `<div class="carousel-item container-wallpaper position-carousel">
                <img src="${e.target.result}" class="d-block w-100">
               </div>`
              ); 
            };
          })(f);
        }
  
        // Lee la imagen con data Url.
        reader.readAsDataURL(f);
      }
    }
}


//Script para Leer el Logotipo
function putLogotypeBackground(evt){
  var files = evt.target.files;
  
  // Lectura de las imagenes de FileList Object.
  for (var i = 0, f; f = files[i]; i++) {
    // Solo para leer imagenes
    if (!f.type.match('image.*')){
      continue;
    }

    var reader = new FileReader();
    
    // Se comienza a procesar la data url.
    reader.onload = (function(theFile){
      return function(e){
        // Se renderiza y lleva a su componente en el DOM con Jquery

        $('#logotype-image').attr('src',`${e.target.result}`);
        
        
      };
    })(f);

    // Lee la imagen con data Url.
    reader.readAsDataURL(f);
  }
}

//Listo a la escucha de los input file
document.getElementById('file-banner').addEventListener('change', putBannerBackground, false);
document.getElementById('file-logotype').addEventListener('change', putLogotypeBackground, false);

function showPassword(){
  if ($('#password').attr('type')=='password') {
    $('#password').attr('type','text');
  } else {
    $('#password').attr('type','password');
  }
}


function hideAlertFiles(idForHide){
  if(idForHide=='banner-message-close'){
    $( "#alert-files-size").fadeOut( "slow", function() {
    });
  }else if(idForHide=='error-send-data'){
    $( "#error-alert-message").fadeOut( "slow", function() {
    });  
  }
}

function addInputPhone(){
  var parent = document.querySelector('#phones-numbers');
  var inputs = parent.querySelectorAll('input');

  if(inputs.length<3){
    $('#phones-numbers').append(`
      <input type="text" id="phone-${inputs.length}" class="form-control" placeholder="Numero Telefonico">
      `);
      $('#btn-remove-phone').attr('disabled',false);
    if(inputs.length==2){
      $('#button-addon2').attr('disabled',true);
    }
  }
}

function removeInputPhone(){
  var parent = document.querySelector('#phones-numbers');
  var inputs = parent.querySelectorAll('input');

  $('#phone-'+ (inputs.length-1)).remove();
  $('#button-addon2').attr('disabled',false);

  if((inputs.length-1)==0){
    $('#btn-remove-phone').attr('disabled',true);
  }
}

function verifyFieldsCompany(){
  //Todos los campos del Formulario
  var fields = [
    {nameField: 'nameCompany', field:'name-company', fill: false},
    {nameField: 'email', field:'email', fill: false},
    {nameField: 'password', field:'password', fill: false},
    {nameField: 'number', field:'input-phone-principal', fill: false},
    {nameField: 'direction', field:'text-direction', fill: false},
    {nameField: 'country', field:'select-country', fill: false},
    {nameField: 'latLng', field:'map', fill: false},
    {nameField: 'mision', field:'mision-textarea', fill: false},
    {nameField: 'vision', field:'vision-textarea', fill: false},
    {nameField: 'socialFacebook', field:'faceboox-textbox', fill: false},
    {nameField: 'socialTwitter', field:'twitter-textbox', fill: false},
    {nameField: 'socialInstagram', field:'instagram-textbox', fill: false}
  ];

  //Verfica que exista al menos un elemento en el input file para el banner
  if(document.getElementById('file-banner').files.length==0){
    $('#label-message-banner').html("Debe ingresar al menos un Banner Publicitario");
    goErrorFocus("banner");
      return;
  }

  let inputNumbers = [];

  //Verfica que exista al menos un elemento en el input file para el logotype
  if(document.getElementById('file-logotype').files.length==0){
    $( "#tooltiptext-exterior" ).fadeIn( "slow", function() {});
    $('html, body').animate({scrollTop: $("#logotype").offset().top }, 1000);
    setTimeout(function(){ 
      $( "#tooltiptext-exterior" ).fadeOut( "slow", function() {
      });
      }, 5000);
      return;
    }

    for(let i=0; i<fields.length; i++){
      if(fields[i].field=='email'){
        fields[i].fill = validarEmailEnLinea($('#email').val());
      }else if(fields[i].field=='password'){
        fields[i].fill = validPasswordForUpKey($('#password').val());
      }else if(fields[i].field=='input-phone-principal'){
        fields[i].fill = validNumberPhones(fields[i].field);
        var parent = document.querySelector('#phones-numbers');
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
      }else if(fields[i].field=='map'){
        if(markersJSON.length==0){
          $('#map').removeClass('is-valid');
          $('#map').addClass('is-invalid');
          goErrorFocus('map'); 
          return;
        }else{
          $('#map').removeClass('is-invalid');
          $('#map').addClass('is-valid')
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

    console.log(fields);
    //Arreglo de JSON que contiene los id de todos los inputs type file 
    let arrayJSONInputsFile = [
      {idInputFile: 'file-banner'},
      {idInputFile: 'file-logotype'}
    ];

    // Creamos un objeto FormData, que nos permitira enviar un formulario
    var datasFile= new FormData();

    //Tranfiriendo las imagenes a un objeto FormData para enviar las al servidor
    var data = getDataImageFile(datasFile,arrayJSONInputsFile, fields);
    if(data.readyForSend){  
      $('#btn-registrar').attr('disabled',true);
      $('#btn-registrar').css('background-color','#fae90e6b');
      showWaitPoint();
      $.ajax({
        url:"../BackEnd/ajax/Empresas/index.php",
        type:"POST",
        data:data.data,
        dataType:"json",
        contentType:false,
        processData:false,
        cache:false,
        success:function(res){ //res es la respuesta (response)
          console.log('Respuesta del servidor:');
          if(res!='exists'){
              $('#L4').css('display','none');
              emailExistAndCreate(true);
              $('#success-message').append(`
              <label class="alert-success-message">
              Enhorabuena ${res} Su Registro ha sido Exitoso
              </label>`);
              $("#success-message").fadeIn( "slow", function() {
              });

              //Temporizador para Esconde el Mensaje
              setTimeout(function(){ 
              $("#success-message").fadeOut("hide", function() {
              });}, 5000);
          }else{
            $('#L4').css('display','none');
            $('#btn-registrar').attr('disabled',false);
            $('#btn-registrar').css('background-color','#fae90e');
            emailExistAndCreate(false);
            goErrorFocus('email');
          }
      },
      error:function(error){
        $('#btn-registrar').attr('disabled',false);
        $('#btn-registrar').css('background-color','#fae90e');
        $( "#error-alert-message").fadeIn( "slow", function() {
        });  
        //Temporizador para Esconde el Mensaje
        setTimeout(function(){ 
          $( "#error-alert-message").fadeOut("hide", function() {
          });}, 5000);
        console.error(error);
      }
    });
  }
}

function getDataImageFile(datasFile,arrayJSONInputsFile, fields){
  for(let i=0; i<arrayJSONInputsFile.length; i++){
    let thisfileIsFor;
    if(i==0){
      thisfileIsFor = "BannersImage-";
    }else{
      thisfileIsFor = "LogotypeImage-";
    }
    var idFiles=document.getElementById(arrayJSONInputsFile[i].idInputFile);

    // Obtenemos el listado de archivos en un array
    var files=idFiles.files;


    // Recorremos todo el array de archivos y lo vamos añadiendo all 
    // objeto dataFile
    for(var j=0; j<files.length;j++){
      // Al objeto data, le pasamos clave,valor
      datasFile.append(thisfileIsFor+j,files[j]);
    }
  }

  let readyForSend;
  for(let i=0; i<fields.length; i++){
    if(fields[i].fill && fields[i].nameField!= 'latLng'){
      datasFile.append(fields[i].nameField, $('#'+fields[i].field).val());
      readyForSend = true;
    }else if(fields[i].fill && fields[i].nameField == 'latLng'){
      datasFile.append(fields[i].nameField, JSON.stringify(markersJSON));
      console.log(JSON.stringify(markersJSON));
      readyForSend = true;
    }else{
      console.log('Algunos campos Son Obligatorios, Verifique su informacion de registro');
      readyForSend = false;
      return data = {'readyForSend':readyForSend};
    } 
  }

  console.log('data')

  return {'data':datasFile , 'readyForSend':readyForSend};
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

function validPasswordForUpKey(password){
  var regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
  let resultado =  regex.test(password);
  if(!resultado){
    document.getElementById('password-invalid-feedback').innerHTML = "La contraseña debe contener minimo de 8 a 15 caracteres, Al menos una letra mayúscula, Una Minuscula, Un Digito y sin Espacios."
  }
  return validShowMessage('password',resultado);
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

function showWaitPoint(){
  $('#email').removeClass('is-invalid');
  $('#email').removeClass('is-valid');
  $('#L4').css('display','block');
}

function goErrorFocus(id){
  $('html, body').animate({
    scrollTop: $("#"+id).offset().top
    }, 1000);
}