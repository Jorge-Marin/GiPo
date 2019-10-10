var accessInformationProduct;

(()=>{
  accessProfileCompany = getParameterByName('promotionkey');
  $('#container-all').css('display','none');
  $.ajax({
      url:"../BackEnd/ajax/Empresas/actions-company.php?action=getProducforClient&promotionCode="+accessProfileCompany,
      type: "GET",
      dataType:"json",
      success:function(res){ //res es la respuesta (response)
          console.log('Respuesta del servidor:');
          console.log(res);
          fillComponets(res);
      },error:function(error){
          console.error(error);
      }
  });
})();

function getParameterByName(name){
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}




function fillComponets(res){
  dataPromotion = res[0];
  
  dataSet = res[1];
  dataProduct = dataSet[0];
  email = dataSet[1];

  $('#email-container').html(`
  ${email}
  `);
  $('#email-container').attr('href',)

  $('#picture-principal').attr('src',"../BackEnd/ajax/Empresas/CompaniesImageDataBase"+dataProduct.principalImage);

  fiilDinamicImage(dataProduct.principalImage, dataProduct.allImages);

  $('#price-descount').html(`L. ${dataPromotion.promotionPrice}`);
  $('#before-descount').html(`Antes: L. ${dataPromotion.originalPrice}`);
  $('#title-promo').html(`${dataProduct.titleProduct}`);
  $('#subtitle-promo').html(`${dataProduct.subTitleProduct}`);
  $('#description').html(`${dataProduct.descriptionProduct}`);
  

  addNewMarker(dataPromotion.mapMarkers);
 
  $('#container-loader').css('display','none');
  $('#container-all').css('display','block');
}


function fiilDinamicImage(principal, litle){
  for(let i=0; i<litle.length; i++){
    if(i<4 && litle[i]!=principal){
      $('#colum-vertical').append(`
        <div class="col-12">
          <div class="my-1">
            <img class="card-img-top" src="../BackEnd/ajax/Empresas/CompaniesImageDataBase${litle[i]}" alt="" width="80px;">
          </div>
      </div>
      `);
    }

    if(4<=i && litle[i]!=principal){
      $('#colum-vertical').append(`
      <div class="col-3 column">
          <div class="my-1">
              <img class="card-img-top" src="../BackEnd/ajax/Empresas/CompaniesImageDataBase${litle[i]}" alt="" width="80px;">
          </div>
      </div>  `);
    }
  }

}

var map;
var markers = [];
var markersJSON = [];


function addNewMarker(markers){
  markers = markers.slice(1,-1);
  markers = JSON.parse(markers);
      var marker = new google.maps.Marker({
          position: markers,
          map: map
      });  
}

function initMap() {
    var tgu = {lat: 14.1, lng: -87.2167};

    map = new google.maps.Map(document.getElementById('map'), {
    scaleControl: true,
    center: tgu,
    zoom: 15
    });
}
 // countDown(dataPromotion.expired.year, dataPromotion.expired.month, dataPromotion.expired.day)

/*function countDown(year,month,day,idlabel){
  console.log(`${year}/${month}/${day}`);
  var end = new Date(`${year}/${month}/${day} 0:00 AM`);

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

            return;
        }
        var days = Math.floor(distance / _day);
        var hours = Math.floor((distance % _day) / _hour);
        var minutes = Math.floor((distance % _hour) / _minute);
        var seconds = Math.floor((distance % _minute) / _second);

        document.getElementById("days").innerHTML = days + ':';
        document.getElementById('hours').innerHTML += hours + ':';
        document.getElementById('minutes').innerHTML += minutes + ':';
        document.getElementById('seconds').innerHTML += seconds + ' seg';
    }

    timer = setInterval(showRemaining, 1000);
}
*/
