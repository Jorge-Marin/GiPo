(()=>{
    $.ajax({
        url:"../BackEnd/ajax/Usuarios/Class/actions-user.php?action=home",
        type: "GET",
        dataType:"json",
        success:function(res){ //res es la respuesta (response)
            console.log('Respuesta del servidor:');
            console.log(res);
            fillHome(res);
        },error:function(error){
            console.error(error);
        }
    });
})();


function fillHome(res){
    $('#container-loader').css('display','none');
    $('#container-all').css('display','block');
    
    console.log(res.bannerActive);
    updateCarousel(res);
    $('#image-profile').attr('src',`../BackEnd/ajax/Usuarios/UserDataBaseImg/${res.bannerActive}`);
    $('#nav-home-tab').html(res.firstname+' '+res.lastname);
    console.log(res);
}



function updateCarousel(res){
    $("#carousel-items").fadeOut();
    $("#carousel-items").html('');
    $("#carousel-items").prepend(`
        <button class="buttons-simple-cools" id='banner-call-modal' onclick="queryGetBanners()">Cambiar Banners</button>
    `);
    $('#carousel-items').append(`
    <div class="carousel-item active">
        <div  class="container-fluid backgrounds-divs box">
            <img src="../BackEnd/ajax/Usuarios/UserDataBaseImg/${res.profileActive}" alt="">
        </div>
    </div>`); 
    $("#carousel-items").fadeIn("slow");
}

