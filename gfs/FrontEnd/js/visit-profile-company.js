var accessProfileCompany;

(()=>{
    accessProfileCompany = getParameterByName('visitcompany');
    $.ajax({
        url:"../BackEnd/ajax/Empresas/view-profile-company.php?visitcompany="+accessProfileCompany+'&action=home',
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            fillHome(res);
            console.log(res);
        },error:function(error){
            console.error(error);
        }
    });

    getProfileInformation();
})();


function getParameterByName(name){
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function fillHome(res){
    $('#container-loader').css('display','none');
    $('#container-all').css('display','block');
    
    updateCarousel([res.referenceFolder,res.ActiveBanners]);
    $('#image-profile').attr('src',`../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res.referenceFolder}${res.ActiveLogotype}`);
    $('#nav-home-tab').html(res.nameCompany);
}

function updateCarousel(activeBanners){
    referenceFolde = activeBanners[0];
    bannersActive = activeBanners[1];
    $("#carousel-items").fadeOut();
    $("#carousel-items").html('');
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


function getImageProfile(){
    $('#image-profile-view').modal('show');
    $('#header-buttonsProfile-actions').empty();
    $('#body-modal-viewprofile').empty();
    $('#modal-dialog-imgprofile').removeClass('dialog-expand-modal');
    $('#modal-content-imgprofile').removeClass('content-expand-modal');
    $('#body-modal-viewprofile').append(`
        <div id="spinner-loader" class="spinner-border" role="status" style="left= 40%;">
            <span class="sr-only">Loading...</span>
        </div>
    `);

    $('#modal-footer-profile').remove();
    
    
    
    $.ajax({
        url:"../BackEnd/ajax/Empresas/view-profile-company.php?visitcompany="+accessProfileCompany+"&action=imagenProfile",
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



function getProfileInformation(){
    $("#profile-content").css('display','none');
    $('.spinner-profile').css('display','block');
    $.ajax({
        url:"../BackEnd/ajax/Empresas/view-profile-company.php?visitcompany="+accessProfileCompany+'&action=profile',
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            console.log(res);

            $('#img-profile-principal').attr('src',`../BackEnd/ajax/Empresas/CompaniesImageDataBase/${res.Logotype[0]}${res.Logotype[1]}`);
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

function addNewMarker(markers){
    for(let i=0; i<markers.length; i++){
        var marker = new google.maps.Marker({
            position: markers[i],
            map: map
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
            fillProductInPromotions({'data':res.Active,'reference':res.referenceFolder})
          },error:function(error){
            console.error(error);
          }
      });
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
        <div id="" class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="box fix">
                    <img src="../BackEnd/ajax/Empresas/CompaniesImageDataBase/${data[i].principalImage}" alt="">
                </div>
                <div class="card-body">
                    <p class="card-text"><a href="" class="description-message">Lorem ipsum dolor sit amet consectetur adipisicing.</a><br>
                        Precio Original: <strong><del>${promoData.promotionPrice}</del></strong><br>
                        Precio de Descuento: <strong>${promoData.promotionPrice}</strong> 
                    </p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick=(this.value) value=''>Comprar</button>
                        <button id="" type="button" class="btn btn-sm btn-outline-secondary" onclick='' value="">Ver Mas</button>
                        </div>
                        <small id="finish-${item}" class="text-muted active-promotion">${countDown(expired.year,expired.month,expired.day,`finish-${item}`)}</small>
                    </div>
                </div>
            </div>
        </div>
    `)
    }
  }


