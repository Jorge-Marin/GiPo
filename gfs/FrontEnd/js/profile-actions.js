var callProducts = true;
function activeCurrent(currentActive){
    var navElements = ['home','publications','products','promotions','logotype','locals','dashboard','promocion'];

    for(let i=0; i<navElements.length; i++){
        if($('#'+navElements[i]).hasClass('active')){
            $('#'+navElements[i]).removeClass('active');
            $('#'+navElements[i]).remove('span');
            $('#'+navElements[i]+'-a').removeClass('border-active');            
        }
    } 
    

    $('#'+currentActive).addClass('active');
    $('#'+currentActive).append(
        `<span class="sr-only">(current)</span>`  
    );
    $('#'+currentActive+' a').addClass('border-active');
}


function hidewhatsUp(i){
    $('#placeholder-8h7gt').css("display","none");
}


function showwhatsUp(value){
    var node = document.getElementById(value);
    htmlContent = node.innerHTML
    if(htmlContent==''){
        $('#placeholder-8h7gt').css("display","block");
        $('#btn-post').addClass('disabled');
        $('#btn-post').attr('disabled',true);
    }else{
        $('#placeholder-8h7gt').css("display","none");
        $('#btn-post').attr('disabled',false);
        $('#btn-post').removeClass('disabled');
    }
}
function deleteImagePost(idRemove){
  $('#'+idRemove).remove();

  var parent = document.querySelector('#container-image-publication');

  var divs = parent.querySelectorAll('div');

  var idsElements = [];
  let contd = 1;
  let contid = 1;
  let contOn = 1;
  for(var i=0; i<divs.length; i=i+2){
    $('#'+divs[i].id).attr('id',`image-${(contd++)}`);
    $(divs[i+1]).attr('onclick',`deleteImagePost("image-${contOn++}")`);
    idsElements.push(`image-${(contid++)}`);
  }

  if(divs.length==0){
    $('#survey').removeClass('disabled');
    $('#survey').attr('onclick','showsurveyElement("placeholder-8h7gt")');
  }else if(divs.length==2){
    let changeClass = 'one-image';
    changeClassImage(changeClass,idsElements,'');
  }else if(divs.length==4){
    let changeClass = 'two-image';
    changeClassImage(changeClass,idsElements,'');
  }else if(divs.length==6){
    let changeClass = 'tree-image';
    changeClassImage(changeClass,idsElements,'two-image');
  }
}

function changeClassImage(changeClass,idsElements, special){
  for(let i=0; i<idsElements.length; i++){
    if(special==''){
    $('#'+idsElements[i]).attr('class',`${changeClass}`);
    }else{
      $('#'+idsElements[i]).attr('class',`${special}`);
      special = '';
    }
  }
}

function hideAlertFiles(){
  $( "#alert-files-size" ).fadeOut( "slow", function() {
  });
}

function showModal(srcImage,iCome,idFather){
  if(iCome=='modal'){
    $('#modal-comments').modal('hide');
    $('#modal-image').modal('show');
    $('#showImage').attr('src',`${srcImage}`);
    $('#btn-close').attr('onclick','returnMeModalComment()')
  }else{
    $('#showImage').attr('src',`${srcImage}`);
  $('#modal-image').modal('show');
  }
}

function returnMeModalComment(){
  $('#modal-image').modal('hide');
  $('#modal-comments').modal('show');
  $('#btn-close').removeAttr('onclick');
}

function sendElementsNormal(){
  var dataPublicacion = {
    'Description': '',
    'Pictures': '', 
    'Likes': '',
    'Comentarios':''
  }

  var node = document.getElementById('rol-text');
  descriptionPublication = node.innerHTML
  dataPublicacion.Description = descriptionPublication;
  
  var parent = document.querySelector('#container-image-publication');
  var divs = parent.querySelectorAll('div');

  var cont = 1;
  let picturesJSON = {};
  for(var i=0; i<divs.length; i=i+2){
    var elementComplete = `${$('#'+divs[i].id).css("background-image")}`;
    elementComplete = elementComplete.slice(5,-2);
    picturesJSON['image-'+ cont] = elementComplete;
    cont++;
  }

  dataPublicacion.Pictures = picturesJSON;
  dataPublicacion.Likes = 0;
  dataPublicacion.Comentarios = 0;
  child = document.getElementById('container-publications-makes').firstChild; 
  var firstchildCode;
  if(child.id==undefined){
    firstchildCode =0;
  }else{
    diff = child.id.length - 25;
    console.log(diff);
    firstchildCode =  child.id.slice(-diff);
    firstchildCode = parseInt(firstchildCode) + 1;
  }
  
  $('#container-publications-makes').prepend(
    `<div id="information-publications-${firstchildCode}" class="row information-publications">
    <div class="col-xl-1">
        <img src="img/new/logo.jpg" style="border-radius: 50%" width="50px;" alt="">
    </div>
    <div class="col-xl-10">
        <label class="name-company-p">Nissan Company</label><br>
        <label class="email-direction">nissanCompany@gmail.com</label>
        <hr>
    </div>
    <div class="col-xl-1">
        <svg viewBox="0 0 24 24" class="icons-actions"><g><path d="M20.207 8.147c-.39-.39-1.023-.39-1.414 0L12 14.94 5.207 8.147c-.39-.39-1.023-.39-1.414 0-.39.39-.39 1.023 0 1.414l7.5 7.5c.195.196.45.294.707.294s.512-.098.707-.293l7.5-7.5c.39-.39.39-1.022 0-1.413z"></path></g></svg>
    </div>
    <div id="description-publication-${firstchildCode}" class="col-lx-12 ">
        ${(dataPublicacion.Description=='')?'':dataPublicacion.Description}
    </div>
    ${comprobatePostImage(dataPublicacion.Pictures,firstchildCode)}
    
    <div class="col-xl-12">
            <span onclick="showCommentPublication('information-publications-${firstchildCode}')"><svg viewBox="0 0 24 24" class="icons-actions"><g><path d="M14.046 2.242l-4.148-.01h-.002c-4.374 0-7.8 3.427-7.8 7.802 0 4.098 3.186 7.206 7.465 7.37v3.828c0 .108.044.286.12.403.142.225.384.347.632.347.138 0 .277-.038.402-.118.264-.168 6.473-4.14 8.088-5.506 1.902-1.61 3.04-3.97 3.043-6.312v-.017c-.006-4.367-3.43-7.787-7.8-7.788zm3.787 12.972c-1.134.96-4.862 3.405-6.772 4.643V16.67c0-.414-.335-.75-.75-.75h-.396c-3.66 0-6.318-2.476-6.318-5.886 0-3.534 2.768-6.302 6.3-6.302l4.147.01h.002c3.532 0 6.3 2.766 6.302 6.296-.003 1.91-.942 3.844-2.514 5.176z"></path></g></svg>
            <label class="number-actions">${dataPublicacion.Comentarios}</label></span>
            <svg viewBox="0 0 24 24" class="icons-actions"><g><path d="M12 21.638h-.014C9.403 21.59 1.95 14.856 1.95 8.478c0-3.064 2.525-5.754 5.403-5.754 2.29 0 3.83 1.58 4.646 2.73.814-1.148 2.354-2.73 4.645-2.73 2.88 0 5.404 2.69 5.404 5.755 0 6.376-7.454 13.11-10.037 13.157H12zM7.354 4.225c-2.08 0-3.903 1.988-3.903 4.255 0 5.74 7.034 11.596 8.55 11.658 1.518-.062 8.55-5.917 8.55-11.658 0-2.267-1.823-4.255-3.903-4.255-2.528 0-3.94 2.936-3.952 2.965-.23.562-1.156.562-1.387 0-.014-.03-1.425-2.965-3.954-2.965z"></path></g></svg>
            <label class="number-actions">${dataPublicacion.Likes}</label>
    </div>
    </div>`
  );
  
  $('#rol-text').empty();
  $('#container-image-publication').empty();
  $('#btn-post').attr('disabled',true);
  $('#btn-post').addClass('disabled')
  $('#placeholder-8h7gt').css('display','block');
  $('#survey').removeClass('disabled');
  $('#survey').attr('onclick','showsurveyElement("placeholder-8h7gt")');
}

function getElementByClass(JSONPictures){
  var addClass, special = '';
  var lengthSrc = Object.keys(JSONPictures).length;
  if(lengthSrc==1){
    addClass = 'one-image';
    special = '';
  }else if(lengthSrc==2){
    addClass = 'two-image';
    special = '';
  }else if(lengthSrc==3){
    addClass = 'tree-image';
    special = 'two-image';
  }else if(lengthSrc==4){
    addClass = 'four-image';
    special = '';
  }

  let valuesPictures = Object.values(JSONPictures);
  var acumulateHTML = '';
  for(let i=0; i<valuesPictures.length; i++){
    if(special==''){
      acumulateHTML+= `<div id="addClass" class="${addClass}" onclick="showModal('${valuesPictures[i]}')" style="background-image: url(${valuesPictures[i]})"> 
        </div>`      
    }else{
      acumulateHTML+= `<div id="addClass" class="${special}" onclick="showModal('${valuesPictures[i]}')" style="background-image: url(${valuesPictures[i]})"> 
        </div>`
      special = '';
    }
  }

  return acumulateHTML;

}

function comprobatePostImage(JSONPictures,firstchildCode){
  var yes = '';
  if(Object.keys(JSONPictures).length!=0){
    yes = `<div id="container-image-divs-${firstchildCode}" style='margin-left: 88px;'>
      ${getElementByClass(JSONPictures)}
    </div>`;
  }else{
    yes = '';
  }

  return yes;
}


function showsurveyElement(idChangeText){
  document.getElementById(idChangeText).innerHTML = 'Haz una Pregunta';

  for(var i=0; i<24; i++){
    $('#hours').append(
      `<option value="${i}">${i} Horas</option>`
    );
  }

  for(var i=0; i<60; i++){
    $('#minutes').append(
      `<option value="${i}">${i} Minutos</option>`
    );
  }

  $('#survey-container').addClass('border');
  $('#survey-container').append(
    `<div id="container-element-survey">
      <img src="icons/close-blue.svg" class="delete close-survey" onclick="closeSurvey()" alt="">
      <p class="p-inputs" style="margin-top: 45px;">Opcion 1</p>
      <input type="text" class="inputs-survey form-control rounded-input-text" placeholder='Opcion 1'>

      <p class="p-inputs">Opcion 2</p>
      <input type="text" class="inputs-survey form-control rounded-input-text" placeholder='Opcion 2'><button id="more" class="add-more" onclick="addOneElement('more',2)">+</button>
      <div id="more-option">

      </div>
      <div>
        <label class="p-inputs">Duracion de la Encuesta</label><br>
        <select name="" class='form-control duration-select rounded-input-text' id="days">
            <option value="0">0 Dias</option>
            <option value="1">1 Dias</option>
            <option value="2">2 Dias</option>
            <option value="3">3 Dias</option>
            <option value="4">4 Dias</option>
            <option value="5">5 Dias</option>
            <option value="6">6 Dias</option>
        </select>
        <select name="" class='form-control duration-select rounded-input-text' id="hours">
            <option value="0">0 horas</option>
        </select>
        <select name="" class='form-control duration-select rounded-input-text' id="minutes">
            <option value="0">0 Minutos</option>
        </select>
      </div>
    </div>`
  );

  $('#image-file').attr('disabled',true);
  $('#label-pictures').addClass('disabled');
  $('#label-pictures').attr('onclick',''); 
}


function addOneElement(id, numberNext){
  $('#'+id).remove();
  let forAdd = `<button id="${id}" class="add-more" onclick="addOneElement('${id}',${numberNext+1})">+</button>`
  $('#more-option').append(
    `<p class="p-inputs">Opcion ${numberNext+1}</p>
    <input type="text" class="inputs-survey form-control rounded-input-text" placeholder='Opcion ${numberNext+1}'>${(numberNext+1==4?'':forAdd)}`
  );
}

function closeSurvey(){
  $('#container-element-survey').remove();
  $('#survey-container').removeClass('border');
  $('#label-pictures').attr('onclick','disableOptionSurvey()');
  $('#image-file').attr('disabled',false);
  $('#label-pictures').removeClass('disabled');
  document.getElementById('rol-text').innerHTML = '';
  document.getElementById('placeholder-8h7gt').innerHTML = '¿Qué estás pensando, Jorge Arturo?';
  $('#placeholder-8h7gt').css('display','block');
}

function disableOptionSurvey(){
  $('#survey').attr('onclick','');
  $('#survey').addClass('disabled');
}


function fillListCategory(){
  let categorys = [
    "Arte","Bebes","Libros","Cámaras y Foto","Teléfonos celulares y accesorios",
    "Ropa", "Zapatos y accesorios","Computadoras / Tabletas y Redes","DVD y películas",
    "Salud y Belleza","Joyería","Relojes","Música","Cerámica y vidrio","Bienes raíces",
    "Sellos","Juguetes y pasatiempos","Viajar","Videojuegos", "Consolas"];

    for(let i=0; i<categorys.length; i++){
      $('#list-desordered').append(`
        <li id="item-catefory-${i}" class="list-group-item" onclick="activeCategory('item-catefory-${i}')">${categorys[i]}</li>
      `);
    }
}

function activeCategory(value){
  if($('#'+value).hasClass('category-selected')){
    $('#'+value).removeClass('category-selected');
  }else{
    $('#'+value).addClass('category-selected');
  }
}

function createFieldsProducts(){
  $('#fields-add-product').append(
      `<div id="fields-add-product">
            <div class="row" style="padding: 50px 25px 0px 25px;">
                    <label class="add-pictures-label">Detalles del Producto</label><br>
                  </div>
                <div class="row" style="padding: 5px 10px 0px 120px;">
                  <div class="col-xl-6" style="padding: 20px 0px;">
                    <p class="p-inputs products">Titulo</p>
                    <div>
                      <input type="text" id="title-product" class="form-control products rounded-input-text" placeholder='Titulo del Producto'>
                        <div class="valid-feedback">
                              Ok
                          </div>
                          <div class="invalid-feedback">
                              Campo obligatorio
                          </div> 
                    </div>  
                    <p class="p-inputs products">Subtitulo</p>
                    <div>
                      <input type="text" id="subtitle-product" class="form-control products rounded-input-text" placeholder='Subtitulo'>
                          <div class="valid-feedback">
                              Ok
                          </div>
                          <div class="invalid-feedback">
                              Campo obligatorio
                          </div>
                    </div>
                    <p class="p-inputs products">Marca</p>
                    <div>
                      <input type="text" id="trademark" class="form-control products rounded-input-text" placeholder='Marca'>
                        <div class="valid-feedback">
                          Ok
                        </div>
                        <div class="invalid-feedback">
                          Campo obligatorio
                        </div>
                    </div>
                    <p class="p-inputs products">Modelo</p>
                      <div>
                        <input type="text" id="model" class="form-control products rounded-input-text" placeholder='Modelo'>
                        <div class="valid-feedback">
                              Ok
                          </div>
                          <div class="invalid-feedback">
                              Campo obligatorio
                          </div>
                      </div>
                    <p class="p-inputs products">Cantidades Disponibles</p>
                    <div>
                      <input type="text" id="quantity" class="form-control products rounded-input-text" placeholder="Cantidades Disponibles">
                        <div class="valid-feedback">
                            Ok
                        </div>
                        <div class="invalid-feedback">
                            Campo obligatorio
                        </div>
                      </div>
                  </div>
                  <div class="col-xl-6" style='height: 540px;'>
                    <div class="categary-product">
                        <ul id="list-desordered" class="list-group" size="8" tabindex="0" aria-label="Categories" role="listbox">
                        </ul>
                    </div>
                  </div>
                </div>
              <div class="row" style="padding: 0px 25px 15px 25px;">
                <label class="add-pictures-label">Descripcion del Producto</label><br>
              </div>
              <div class="row">
                <div class="col-xl-12">
                  <div>
                  <textarea id="text-description" class="form-control" style="margin-top: 0px;margin-bottom: 0px;height: 331px;width: 100%;"></textarea>
                  <div class="valid-feedback">
                        Ok
                    </div>
                    <div class="invalid-feedback">
                        Campo obligatorio
                    </div>
                  </div>
                </div>
              </div>
              <div class="row" style="padding: 50px 25px 15px 25px;">
                <label class="add-pictures-label">Agregar Fotografias del Producto</label><br>
              </div>
              <div id="products-images-fill" class="row container-images-product">
                <div id="pimage-1" class="col-xl-6 image-products-divs" style="border-right: 1px solid #cfcfcf">
                    <label class="add-photos" for="image-product">Agregar Fotografias</label>
                    <p class="message-limit text-center">Agrege hasta 10 fotografias de su producto, Recuerden una buena imagen, vende su producto.</p>
                </div>
                <span id="container-images-fill" class="col-xl-6" style="padding: 0;">
                    <div id="pimage-2" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-3" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-4" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-5" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-6" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-7" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-8" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-9" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                    <div id="pimage-10" class="col-xl-4 other-images image-products-divs"><i class="far fa-file-image"></i></div>
                </span>
              </div>
        </div>
        <button type="button" class="btn btn-dark" style="float: right;" onclick="sendProduct()">Registrar Producto</button>
        <button type="button" class="btn btn-secondary" style="float: right; margin-right: 6.2px;" onclick="removeFieldsProducts()">Cancelar</button>`
    );
  $('#container-products-register').css("margin-top",'8%');
  fillListCategory()

  $('html, body').animate({
      scrollTop: $("#fields-add-product").offset().top
      }, 1000);

      $('#add-remove-fields').empty();
      $('#add-remove-fields').append(
        `<div>
        <button id="more" class="alert-message add-more" onclick="removeFieldsProducts()" style="top: -20.6px;
        left: -393px;">Remover Campos <img src="icons/close-simple.svg" width="20px" alt=""></button>
        </div>`
      );

}


function removeFieldsProducts(){
  $('#add-remove-fields').empty();
  $('#add-remove-fields').append(
      `<button id="more" class="alert-message add-more" onclick="createFieldsProducts()" style="top: -20.6px;
      left: -393px;">Agregar Nuevos Productos +</button>`
      );
  $('#fields-add-product').empty();

  $('#container-products-register').css("margin-top",'4%');
  $('html, body').animate({
    scrollTop: $("#add-remove-fields").offset().top
    }, 1000);
}

var productsImage = [];

function addImageFill(evt) {
  var files = evt.target.files; // FileList object
  var parent = document.querySelector('#products-images-fill');
  var divs = parent.querySelectorAll('div');
  var cont = 0;
  // Loop through the FileList and render image files as thumbnails.
  for (let i = 0,j=0; i<10 && j<files.length; i++) {
    
    

    if($('#'+divs[i].id).css("background-image")=='none'){
      f=files[j];
      productsImage.push(f);
      // Only process image files.
      if (!f.type.match('image.*')){
        continue;
      }

      var reader = new FileReader();

      reader.onload = (function(theFile){
        return function(e){
        // Render thumbnail.
              $('#'+divs[i].id).empty();
              $('#'+divs[i].id).append(`<img src="icons/close.svg" onclick="refillContainers('${divs[i].id}',${i})" class="delete remove-image-product">`);
              $('#'+divs[i].id).css("background-image",`url(${e.target.result})`);
          };
        })(f);

      // Read in the image file as a data URL.
        reader.readAsDataURL(f);
        j++;
      }
      cont = i;  
    }

  if(cont!=9){
    $('#'+divs[cont+1].id).empty(); 
    $('#'+divs[cont+1].id).append(`<label for="image-product" class="add-photos label-imgother">Agregar Imagen</label>`);
  }

  $('#'+divs[cont].id).addClass('last');

  console.log(productsImage);
}

document.getElementById('image-product').addEventListener('change', addImageFill, false);

function refillContainers(idelementsRemove, pop){
  productsImage.splice(pop, 1);
  

  console.log(productsImage);
  $('#'+idelementsRemove).empty();
  $('#'+idelementsRemove).removeAttr("style");

  var parent = document.querySelector('#products-images-fill');
  var divs = parent.querySelectorAll('div'); 
  
  var cont;
  var message = false;
  
  if($('#'+idelementsRemove).hasClass('last')){
    for(var i=0; i<(divs.length-1); i++){
      if(divs[i+1].id==idelementsRemove){
        $('#'+divs[i].id).addClass('last');
        cont = i+1;
        console.log("entro");
        break;
      }
      $('#'+divs[i].id).removeClass('last');
    }
  }else{
    for(var i=0; i<(divs.length); i++){
      if($('#'+divs[i].id).css("background-image")=='none'){
        for(var j=i; j<(divs.length-1); j++){
          if($('#'+divs[j+1].id).css("background-image")!='none'){
            $('#'+divs[j].id).empty();
            $('#'+divs[j].id).append(`<img src="icons/close.svg" onclick="refillContainers('${divs[j].id}')" class="delete remove-image-product">`);
            $('#'+divs[j].id).css("background-image",$('#'+divs[j+1].id).css("background-image"));
            cont = j+1;
          }
        }
        break;   
      }
    }
  }

  

  if(cont == undefined){
    cont=0;
    message =true;
  }else{
    $('#'+divs[cont-1].id).addClass('last');
  }
  
  for(var i=cont,add=true; i<divs.length; i++){
    if(add){
      if(message){
        $('#'+divs[i].id).empty();
        $('#'+divs[i].id).removeAttr("style");
        $('#'+divs[i].id).append(`<label class="add-photos" for="image-product">Agregar Fotografias</label>
        <p class="message-limit text-center">Agrege hasta 10 fotografias de su producto, Recuerden una buena imagen, vende su producto.</p>`);
      add = false;
      }else{
        $('#'+divs[i].id).empty();
        $('#'+divs[i].id).removeAttr("style");
        $('#'+divs[i].id).append(`<label for="image-product" class="add-photos label-imgother">Agregar Imagen</label>`);
        $('#'+divs[i].id).removeClass('last');
        add = false;
      }
    }else{
      $('#'+divs[i].id).empty();
      $('#'+divs[i].id).removeAttr("style");
      $('#'+divs[i].id).append(`<i class="far fa-file-image">`);
      $('#'+divs[i].id).removeClass('last');
    }
  }  
}

function showCommentPublication(idElemetsFather){
  var parent = document.querySelector('#'+idElemetsFather);
  var divs = parent.querySelectorAll('div');
  
  $('#body-modal-images').empty();
  $('#modal-comments').modal('show');
  $('#body-modal-images').append(`
  <div class="row" style="width: 690px;">
    <div class="col-xl-1">
        <img src="img/new/logo.jpg" style="border-radius: 50%" width="50px;" alt="">
    </div>
    <div class="col-xl-11">
        <label class="name-company-p">Nissan Company</label><br>
        <label class="email-direction">nissanCompany@gmail.com</label>
        <hr>
    </div>
  </div>
  <div id="description-publication" class="col-lx-12 ">
        <p>${document.getElementById(divs[3].id).innerHTML}</p>
  </div>
  <div class="row" style="width: 650px;
  padding: 0 0px 0px 66px;">
    <div class="col-xl-12">
    ${changeEventModal(divs[4].id,idElemetsFather)}
    </div>
  </div>
  <div style="padding: 20px 30px;">
  <div class="row comment-row">
  <div class="col-xl-1">
      <img src="img/naruto.jpg" class="rounded-circle thumbails" style="width: 65px; padding-top: 3px;" alt="">
  </div>
  <div class="col-xl-11" style="padding-left: 32px;">
      <label class="name-company-p">Uzumaki Naruto</label><br>
      <label class="email-direction">uzumakiDeKonoha@gmail.com</label>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis dicta iure, et blanditiis, porro dolor aspernatur quia alias pariatur aperiam debitis odit dolorem, necessitatibus officiis.</p>
  </div>
  </div>
    <div class="row" style="padding-left: 90px;">
      <a href="#" style="margin-right: 10px;">Responder</a>
      <a href="#">Me Gusta</a>
    </div>
  </div>
  `);


}

function changeEventModal(idfather,idElemetsFather){
    var parent = document.querySelector('#'+idfather);
    var divs = parent.querySelectorAll('div');
    var acumulateHTML='';
    console.log(divs[0].style.backgroundImage);
    for(var i=0; i<divs.length; i++){
      elementComplete = divs[i].style.backgroundImage;
      elementComplete = elementComplete.slice(5,-2);
      acumulateHTML += `<div id="addClass" class="${divs[i].className}" onclick="showModal('${elementComplete}','modal','${idElemetsFather}')" style="background-image: url(${elementComplete})"> 
      </div>\n`;
    }
    console.log(acumulateHTML);
    return acumulateHTML;
  }


function statePromotion(iditem){
  if($(`#${iditem}`).is(':checked')){
    $('#label-promotions').html(`Promocion en Vigencia`);
    $('#details-promotions').modal('show');
    // cargamos los años
    for(var i=2019;i<2025;i++)
    {
        $("#year").append(new Option(i,i));
    }

    let meses = ['Enero', 'Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    for(let i=0; i<meses.length; i++)
    $('#month').append(new Option(meses[i],i+1));
        // Creamos un Date con el año y mes seleccionado del formulario
        // y con el dia 0, que nos devolvera el ultimo dia del mes
        // anterior.
        fecha=new Date($("#year").val(), $('#month').val(), 0);

        $("#day").find('option').remove();
          for(var i=1;i<fecha.getDate();i++){
            $("#day").append(new Option(i,i));
        }
        
  $('#send-promotion').attr('value', iditem);
  newMap('mapPromotions');
  }else{
    value = $(`#${iditem}`).val();
    console.log(item);

    $('#cancel-delete-promotion').attr('value',value);
    $('#delete-promotion').attr('value',value);
    $('#delete-promotion-verify').modal('show');
  }
}

function creteTime(){
  $("#year").html('');
  for(var i=2019;i<2025;i++)
    {
        $("#year").append(new Option(i,i));
    }

    // Creamos un Date con el año y mes seleccionado del formulario
    // y con el dia 0, que nos devolvera el ultimo dia del mes
    // anterior.
    fecha=new Date($("#year").val(), $("#month").val(), 0);

    $("#days").find('option').remove();
      for(var i=1;i<fecha.getDate();i++){
        $("#days").append(new Option(i,i));
    }
}


function countDown(year,month,day,idlabel){
  console.log(`${year}/${month}/${day}`);
  var end = new Date((`${year}/${month}/${day} 0:00 AM`));

    var _second = 1000;
    var _minute = _second * 60;
    var _hour = _minute * 60;
    var _day = _hour * 24;
    var timer;

    function showRemaining() {
        var now = new Date();
        var distance = end - now;
        if (distance < 0){

            clearInterval(timer);
            document.getElementById(idlabel).innerHTML = 'Expiro';

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        document.getElementById(idlabel).innerHTML = days + ':';
        document.getElementById(idlabel).innerHTML += hours + ':';
        document.getElementById(idlabel).innerHTML += minutes + ':';
        document.getElementById(idlabel).innerHTML += seconds + ' seg';
    }

    timer = setInterval(showRemaining, 1000);
}




function decrement() {
  value = parseInt($('#value-size').val());
  if(1<value){
    $('#value-size').val(value-1);
  }	
}	

function increment() {
  value = parseInt($('#value-size').val());
  if(value<20){
    $('#value-size').val(value+1);
  }
}


function hideNotificationProfile(){
  $('#container-left').removeClass('col-9');
  $('#v-pills-home').removeClass('show');
  $('#v-pills-home').removeClass('active');
  $('#show-profile').hide();
  $('#container-left').addClass('container-fluid');
  $('#v-pills-profile').addClass('show');
  $('#v-pills-profile').addClass('active');

  
}

function returnPublication(){
  $('#container-left').removeClass('container-fluid');
  $('#v-pills-profile').removeClass('show');
  $('#v-pills-profile').removeClass('active');
  $('#show-profile').show();
  $('#container-left').addClass('col-9');
  $('#v-pills-home').addClass('show');
  $('#v-pills-home').addClass('active');
}


function createPromotionalSheet(){
  $('#promotional-sheet').modal('show');
}

function getAllProducts(){
  $.ajax({
    url:'../BackEnd/ajax/Empresas/actions-company.php?action=getProducts',
    type:'GET',
    dataType:'json',
    success: function(res){
      console.log('Respuesta del Servidor');
      console.log(res);
      addProductsContainer(res);
    },error:function(error){
      console.error(error);
    }
  });
}


function sendProduct(){
  var fieldsProducts = [{fieldName:'title',field: 'title-product', fill:false},
   {fieldName:'subtitle',field: 'subtitle-product', fill:false},
   {fieldName:'trademark',field: 'trademark', fill:false},
   {fieldName:'model',field: 'model', fill:false},
   {fieldName:'quantity',field: 'quantity', fill:false},
   {fieldName:'description',field: 'text-description', fill:false}];

   for(let i=0; i<fieldsProducts.length;i++){
       fieldsProducts[i].fill = markInput(fieldsProducts[i].field);
   }
   
   var parent = document.querySelector('#list-desordered');
   var categorySelected = parent.querySelectorAll('li');

   selected = [];

   for(let i=0; i<categorySelected.length; i++){
      if($(categorySelected[i]).hasClass('category-selected')){
        selected.push($(categorySelected[i]).html());
      }
   }
  
   var dataFile = new FormData();

   data = fillDataFile(dataFile,fieldsProducts, selected, productsImage);

   if(data.readForSend){
     $.ajax({
       url:'http://localhost/gfs/BackEnd/ajax/Empresas/actions-company.php?action=addProducts',
       type:'POST',
       data: data.dataFile,
       typeData: 'json',
       contentType:false,
        processData:false,
        cache:false,
       success: function(res){
        console.log('Respuesta del Servidor');
        console.log(res);
        addProduct(res);
       },error:function(error){
        console.error(error);
       }
     });
   }
 }

 function fillDataFile(dataFile,fieldsProducts, selected, productsImage){
   var readyForSend;


   for(let i=0; i<fieldsProducts.length; i++){
      if(fieldsProducts[i].fill){
        dataFile.append(fieldsProducts[i].fieldName, $('#'+fieldsProducts[i].field).val());
        readyForSend = true;
      }else{
        goErrorFocus(fieldsProducts[i].field);
        readyForSend = false;
      }
   }

   if(selected.length!=0){
    dataFile.append('category', JSON.stringify(selected));
    readyForSend = true;
   }

   for(let i=0; i<productsImage.length; i++){
    if(productsImage.length!=0){
     dataFile.append('image'+i, productsImage[i]);
     readyForSend = true;
    }
    else{
      readyForSend = false;
    }
  }

  return {'dataFile':dataFile,'readForSend':readyForSend};
   
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

 function addProductsContainer(res){
  data = res.data;
  title = '';
  reference = res.reference;
  for(let i=0; i<data.length;i++){
    splits =  data[i].principalImage.split('/');
    folderubi = splits[0];
    itemDelete = splits[3];
    if(data[i].titleProduct.length>80){
      title = data[i].titleProduct.substr(0,80) + '...';
    }else{
      title = data[i].titleProduct +'</br>';
    }
    $('#products-container').prepend(
      `<div id="cot-${itemDelete}" class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <div class="box fix">
          <img src="../BackEnd/ajax/Empresas/CompaniesImageDataBase/${data[i].principalImage}" alt="">
        </div>
        <div class="card-body">
          <p class="card-text"><a href="" class="description-message">${title}</a><br>
          Marca: <strong><del>${data[i].tradeMark}</del></strong><br>
          Modelo: <strong>${data[i].model}</strong> 
          </p>
          <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
              <button type="button" class="btn btn-sm btn-outline-secondary" onclick=(this.value) value="${reference}/${itemDelete}">Actualizar</button>
              <button id="${reference}/${itemDelete}" type="button" class="btn btn-sm btn-outline-secondary" onclick='querydeleteProduct(this.id,this.value)' value="${folderubi}">Eliminar</button>
              </div>
              <small class="text-muted">${data[i].quantity} Unidades Disponibles</small>
          </div>
      </div>
    </div>
  </div>`);
  }
}

                
 


 function addProduct(res){
    $('#products-container').prepend(
      `<div id="${res.item}" class="col-md-4" style="display:none">
          <div class="card mb-4 shadow-sm">
            <div class="box fix">
              <img src="../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res.principalImage}" alt="">
            </div>
            <div class="card-body">
              <p class="card-text"><a href="" class="description-message">${res.titleProduct}</a><br>
              Marca: <strong>${res.tradeMark}</strong><br>
              Modelo: <strong>${res.model}</strong> 
              </p>
          <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
              <button type="button" class="btn btn-sm btn-outline-secondary" onclick=(this.value) value="${res.tmp}/${res.item}">Actualizar</button>
              <button id="${res.tmp}/${res.item}" type="button" class="btn btn-sm btn-outline-secondary" onclick='querydeleteProduct(this.id,this.value)' value="${res.folderubi}">Eliminar</button>
              </div>
              <small class="text-muted">${res.quantity} Unidades Disponibles</small>
          </div>
          </div>
        </div>
      </div>`);

      $(`#${res.item}`).fadeIn('slow');
 }


 function querydeleteProduct(tmp, folderubi){
   splits =  tmp.split('/');
   referenceProducts = splits[0];
   itemDelete = splits[1];
   pathFolder = folderubi+'/'+'Products'+'/'+itemDelete;
 
    console.log(pathFolder);


   $.ajax({
     url:'http://localhost/gfs/BackEnd/ajax/Empresas/actions-company.php?action=deleteProduct&referenceProducts='+referenceProducts+'&itemDelete='+itemDelete+'&pathFolder='+pathFolder,
     type:'DELETE',
     dataType:'json',
     success: function(res){
        console.log('Respuesta del Servidor');
        $(`#cot-${itemDelete}`).fadeOut('slow');
        $(`#cot-${itemDelete}`).remove();
        console.log(res);
     },error:function(error){
       console.error(error);
     }
   });

 }
 
 function fillProducts(res,idContainer){
   data = res.data
   reference = res.reference;
  for(let i=0; i<data.length; i++){
    getThis = data[i].principalImage;
    item = getThis.split('/');
    folderubi = item[1];
    item = item[3];
    title = '';
    if(data[i].titleProduct.length>80){
      title = data[i].titleProduct.substr(0,80) + '...';
    }else{
      title = data[i].titleProduct +'</br>';
    }

    $(`#${idContainer}`).append(
      `<div class="col-md-4" style="display:block">
          <div class="card mb-4 shadow-sm">
            <div class="box fix">
              <img src="../BackEnd/ajax/Empresas/CompaniesImageDataBase/${data[i].principalImage}" alt="">
            </div>
            <div class="card-body">
              <p class="card-text"><a href="" class="description-message">${title}</a><br>
              Marca: <strong>${data[i].tradeMark}</strong><br>
              Modelo: <strong>${data[i].model}</strong> 
              </p>
              <label class="switch">
                <input type="checkbox" id="${item}" onclick='statePromotion(this.id)'>
                <span class="slider round">
                </span>
              </label>
              <small id="label-promotions" class="text-muted active-promotion" style="padding-left: 4.2px; float: left; padding-top: 5.7px;">Promocion en Vigencia</small>
          </div>
        </div>
      </div>`);
  }

  
}


var map3;
var markerAdd = [];
var markersJSON =[];

function newMap(id){
    var tgu = {lat: 14.1, lng: -87.2167};
    map3 = new google.maps.Map(document.getElementById(id), {
        scaleControl: true,
        center: tgu,
        zoom: 15
      });

    // This event listener will call addMarker() when the map is clicked.
  map3.addListener('click', function(event) {
    addMarker(event.latLng);
  });
}

// Adds a marker to the map and push to the array.
function addMarker(location) {
  var marker = new google.maps.Marker({
    position: location,
    map: map3
  });
  markerAdd.push(marker);
  markersJSON.push({'lat':location.lat(), 'lng': location.lng()});
}

// Sets the map on all markers in the array.
function setMapOnAll(map3) {
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

function resgitryPromotions(itemPromo){
  console.log(itemPromo);
  var fields = [
  {nameField:'promotions-price',field:"promotions-price",fill:false},
  {nameField:'original-price',field:"original-price",fill:false},
  {nameField:'size-promotion',field:"size-promotion",fill:false},
  {nameField:'days',field:"days",fill:false},
  {nameField:'month',field:"month",fill:false},
  {nameField:'year',field:"year",fill:false}
  ];  

  
  readyforSend = false;
  for(var i=0; i<fields.length; i++){
      fields[i].fill = (markInput(fields[i].field))?true:goErrorFocus(fields[i].field) ;
      readyforSend = true;
      if(!fields[i].fill){
          return;
      }
  }

  if(readyforSend){
      paramentros = $('#form-promotions').serialize();
      
      if(markersJSON.length=!0){
        paramentros = paramentros+ '&' +'markers='+JSON.stringify(markersJSON);
      }

      console.log(paramentros);
      $.ajax({
        url:'http://localhost/gfs/BackEnd/ajax/Empresas/actions-company.php?action=sendPromotion&itemPromo='+itemPromo,
        data:paramentros,
        dataType:'json',
        type:'POST',
        success:function(res){
          console.log("Respuesta del Servidor");
          console.log(res);
          $('#details-promotions').modal('hide');
        },error:function(error){
          console.error(error);
        }
      });
  }
}

function getPromotions(){
  $.ajax({
    url:'http://localhost/gfs/BackEnd/ajax/Empresas/actions-company.php?action=getPromotions',
        dataType:'json',
        type:'GET',
        success:function(res){
          console.log("Respuesta del Servidor");
          console.log(res);
          fillProducts({'data':res.NoActive,'reference':res.referenceFolder},'content-static-products')
          fillProductInPromotions({'data':res.Active,'reference':res.referenceFolder})
        },error:function(error){
          console.error(error);
        }
    });
}



function fillProductInPromotions(res){
  data = res.data;
  referenceFolder = res.referenceFolder;  
  for(let i=0; i<data.length; i++){
    getThis = data[i].principalImage;
    item = getThis.split('/');
    item = item[3];
    title = '';
    if(data[i].titleProduct.length>80){
      title = data[i].titleProduct.substr(0,80) + '...';
    }else{
      title = data[i].titleProduct +'</br>';
    }
    promoData = data[i].informationPromotion;
    expired = promoData.expired;
    $('#products-in-promotions').append(`
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <div class="box">
          <img id="image-${item}" value='${data[i].principalImage}' src="../BackEnd/ajax/Empresas/CompaniesImageDataBase/${data[i].principalImage}">
          </div>
          <div class="card-body">
          <a class="card-text print-a" href='#'>Imprimir Promocion<i class="fas fa-print"></i></a><br>
          <p class="card-text"><a href="" class="description-message">${title}.</a><br>
          Precio de Oferta: <strong>${promoData.promotionPrice}</strong><br>
          Precio Original: <strong><del>${promoData.originalPrice}</del></strong> 
          </p>
          <!-- Rounded switch -->
          <label class="switch">
              <input type="checkbox"  value='${data[i].idPromotion}' checked id="${item}" onclick='statePromotion(this.id)'>
              <span class="slider round"></span>
          </label>
          <small id="label-promotions" class="text-muted active-promotion" style="padding-left: 4.2px; float: left; padding-top: 5.7px;">Promocion en Vigencia</small>
          <small id="finish-${item}" class="text-muted active-promotion">${countDown(expired.year,expired.month,expired.day,`finish-${item}`)}</small>
          </div>
      </div>
    </div>
  `)
  }
}
 

function deletePromotion(itemId){
  $.ajax({
    url:'../BackEnd/ajax/Empresas/actions-company.php?action=deletePromotion&deletePromo='+itemId,
    type:'DELETE',
    dataType:'json',
    success: function(res){
      console.log('Respuesta del Servidor');
      console.log(res);
    },error:function(error){
      console.error(error);
    }
  });
}

function cancelDeletePromotion(againActive){
  console.log(againActive);
  $('#'+againActive).prop('checked',true);
  $('#delete-promotion-verify').modal('hide');
}