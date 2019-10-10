(()=>{
    $('#body-content').css('display','none');
    $('#container-loader').css('display','block')
    $.ajax({
        url:"../BackEnd/ajax/Empresas/actions-company.php?action=homeidex",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            console.log(res);
            fillPromotionsHome(res);
            $('#body-content').fadeIn('slow');
            $('#container-loader').css('display','none')
            $('#body-content').css('display','block');
        },error:function(error){
            console.error(error);
        }
    });
})();



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


  function fillPromotionsHome(res){

      for(let i=0; i<res.length; i++){
        item = res[i];
        dataPromo = item[0];
        dataProduct = item[1][0];
        console.log(dataProduct);
        $('#container-promotions').append(`
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="box fix">
                <img src="../BackEnd/ajax/Empresas/CompaniesImageDataBase${dataProduct.principalImage}" alt="">
                </div>
                <div class="card-body">
                <p class="card-text"><a href="http://localhost/gfs/FrontEnd/view-product.php?promotionkey=${dataProduct.idPromotion}" class="description-message">${dataProduct.titleProduct}</a><br>
                Precio Original: <strong><del>$${dataPromo.originalPrice}</del></strong><br>
                Precio de Descuento: <strong>$${dataPromo.promotionPrice}</strong> 
                </p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="" value=''>Comprar</button>
                <button id="" type="button" class="btn btn-sm btn-outline-secondary" onclick="viewMore(${dataProduct.idPromotion})" value="">Ver Mas</button>
                </div>
                <small id='${dataProduct.idPromotion}' class="text-muted">Finaliza en:${countDown(dataPromo.expired.year,dataPromo.expired.month,dataPromo.expired.day,dataProduct.idPromotion)}</small>
            </div>
            </div>
            </div>
        </div>
        `);
    }
  }

function viewMore(seeProduct){
    window.location.href = 'http://localhost/gfs/FrontEnd/view-product.php?promotionkey='+seeProduct;
}


