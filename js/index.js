function displayComs(){
  $('.galeries').css({"display": "none"});
  $('.commentaires').css({"display": "block"});
  $('.commentaires').load('php/commentaires.content.php').fadeIn("slow");
}


function displayGals(id){
  $('.commentaires').css({"display": "none"});
  $('.galeries').css({"display": "block"});
  $('.galeries').load('php/galeries.content.php', { "gallery": id } ).fadeIn("slow");

}


function scrollingTop(){
    $('.body').animate({scrollTop : 0},800);
}


function displayable(){
  if ($('#blueimp-gallery').attr('class').match(/blueimp-gallery-controls/)) {
  
  }else{
    $('.titre').css({"display": "none"});
  }
}


function cssCond(top, right){
  $('.titre').css({"left": "0px", "top": top, "right": "", "display": "block"});
  $.extend( new displayable);
}

function cssNotCond(top, right){
  $('.titre').css({"right": right, "top": top, "left": "", "display": "block"});
  $.extend( new displayable);
}

function mobileDisplay(){
  $('.titre').css({"left": "15px", "top": "15px", "right": "", "display": "block"});
  $.extend( new displayable);
}

function displayTitleHandleOpen() {
    $('.slide').filter(function() { 
        if($(this).attr('style').match(/translate\(0px, 0px\)/)){     
          var imgw =  $(this).children('img').width();
          var imgh =  $(this).children('img').height();
          var winw = $(window).width();
          var winh = $(window).height();
          var right = (winw/2)+(imgw/2)+ 10;
          var top = (winh/2)-(imgh/2);
          var cond = (winw/2)-(imgw/2);
          if (((top > 70)&&(cond < 180))||(cond < 1 )) {
           $('.titre').css({"left": "0px", "top": "15px", "right": "", "display": "block"});
           $.extend( new displayable);
          }else{
            if(cond < 180){
              $.extend( new cssCond(top, right));
            }else{
              $.extend( new cssNotCond(top, right));
            }
          }
        }
    });   
}

function displayTitle (){
$('.titre').hide();
  $('.slide').filter(function() { 
      if($(this).attr('style').match(/translate\(0px, 0px\)/)){
        var imgw =  $(this).children('img').width();
        var imgh =  $(this).children('img').height();
        var winw = $(window).width();
        var winh = $(window).height();
        var right = (winw/2)+(imgw/2)+ 10;
        var top = (winh/2)-(imgh/2);
        var cond = (winw/2)-(imgw/2);
        if (((top > 70)&&(cond < 180))||(cond < 1 )) {
         $('.titre').css({"left": "0px", "top": "15px", "right": "", "display": "block"});
         $.extend( new displayable);
        }else{
          if(cond < 180){
            setTimeout(function() {
                  $.extend( new cssCond(top, right))
            }, 1500);
          }else{
            setTimeout(function() {
                    $.extend( new cssNotCond(top, right))
              }, 1500);
          }
        }
      }
  });   

}

function displayScroll(){
  var containerwidth = $('.container').width();
  var windowWidht = $(window).width();
  var scrollWith = ((windowWidht - containerwidth)/2);
  if(scrollWith > 58 ){
    var left = scrollWith+containerwidth;
    $('.scroll').css({"left": left, "right": ""}); 
  }else{
    $('.scroll').css({"left": "", "right": "20px"});
  }
}

function displayTitleResize(){
  $('.slide').filter(function() { 
    if($(this).attr('style').match(/translate\(0px, 0px\)/)){
      var imgw =  $(this).children('img').width();
      var imgh =  $(this).children('img').height();
      var winw = $(window).width();
      var winh = $(window).height();
      var right = (winw/2)+(imgw/2)+ 10;
      var top = (winh/2)-(imgh/2);
      var cond = (winw/2)-(imgw/2);
      if (((top > 70)&&(cond < 180))||(cond < 1 )) {
         $('.titre').css({"left": "0px", "top": "15px", "right": ""});
      }else{
        if(cond < 180){
          $('.titre').css({"left": "0px", "top": top, "right": ""});
        }else{
          $('.titre').css({"right": right, "top": top, "left": ""});
        }
      }
      
    }
  });    
}


$(window).ready(function(){ 
  displayScroll();
  $('.body').scroll(function(){
    if ($(this).scrollTop() > 400) {
      $('.scroll').fadeIn();
    } else {
      $('.scroll').fadeOut();
    }
  });
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$("#blueimp-gallery").removeClass( "blueimp-gallery-controls" );
	}
$( document ).bind('contextmenu', function(e) {
  return false;
});


$( document ).click(function(e){
  if (e.which == 2) {
      e.stopPropagation();
      e.preventDefault();
      return false;
  }    
 });


$(document).bind('keydown', function (event){
  switch (event.which || event.keyCode) {
     case 27: // Esc
        hidePicsForm();
        hideGalForm();
        break;
    }
});


  $('.del').nextAll().remove(); 
 });

function displayPicsForm(id){
  $('.form-back').css({"display": "block"});
  $('#inputtitre').val($('#'+id+'.padd-admin').children('.thumbnails').attr("id"));
  $('#inputsoustitre').val($('#'+id+'.padd-admin').children('.thumbnails').attr("alt"));
  $('#inputid').val(id);
}

function hidePicsForm(){
  $('.form-back').css({"display": "none"});
  $('#inputid').val();
  $('#inputtitre').val();
  $('#inputsoustitre').val();
}

function displayGalForm(id){
  $('.gal-form-back').css({"display": "block"});
  $('#galinputtitre').val($('#'+id+'.gallery-info').attr("titre"));
  $('#galinputsoustitre').val($('#'+id+'.gallery-info').attr("subtitle"));
  $('#galinputid').val(id);
}


function hideGalForm(){
  $('.gal-form-back').css({"display": "none"});
  $('#galinputid').val();
  $('#galinputtitre').val();
  $('#galinputsoustitre').val();  
}

function deleteComment(id){
  var pic = $('#'+id).attr("pic");
  var nbcom = $('#'+id).attr("nbcom");
  
  var isGood = confirm("Supprimer le commentaire");
  if(isGood){
    
    $.ajax({
          url: "php/delete_comment.php",
          type: "GET",
          data: {key: id, pic: pic, nbcom: nbcom},
          success: function(){
                    window.location.reload();
                   }
     });
  }
}

function antiSpam(){
  var auth = $('#author-input').val();
  var comment = $('#form_Commentaire').val();
  var test = true;
  if (auth == "") {
    test = false;
    $('#author-input').css({"border-color": "#F71D1D", "box-shadow": "0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(239, 55, 55, 0.6)", "outline": "0px none"});
  }else{
    $('#author-input').css({"border": "1px solid #CCC", "box-shadow": "0px 1px 1px rgba(0, 0, 0, 0.075) inset"});
  }
  if (comment == "") {
    test = false;
    $('#form_Commentaire').css({"border-color": "#F71D1D", "box-shadow": "0px 1px 1px rgba(0, 0, 0, 0.075) inset, 0px 0px 8px rgba(239, 55, 55, 0.6)", "outline": "0px none"});
  }else{
    $('#form_Commentaire').css({"border": "1px solid #CCC", "box-shadow": "0px 1px 1px rgba(0, 0, 0, 0.075) inset"});
  }

  if (test) {
    $.ajax({
    url: "php/antispam.php",
    dataType: "json",
    success: function(response){
      console.log(response);
      switch(response.status){
        case 'success':
          $('#commentForm').submit();
          break;
        case 'fail':
          $('#alert-message').load('php/alert.display.php').fadeIn("slow");
          break;
        default:
          alert("unknown response");
      }  
    }
  });
  }
  
}

$( document ).click(function(event) {
  event = event || window.event;
  var divClass = event.target.getAttribute("class");
  var picsBack = $('.form-back').attr("style");
  var galBack = $('.gal-form-back').attr("style");

  if((divClass == "form-back" ) && (picsBack == "display: block;"))
    hidePicsForm();

  if((divClass == "gal-form-back" ) && (galBack == "display: block;"))
    hideGalForm();
});