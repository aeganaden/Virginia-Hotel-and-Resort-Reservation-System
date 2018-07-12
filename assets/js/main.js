$(document).ready(function() {

  /*==================================
  =            General JS            =
  ==================================*/
  
  // Date function unix timestamp converter
  Date.prototype.getUnixTime = function() { return this.getTime()/1000|0 };
  if(!Date.now) Date.now = function() { return new Date(); }
  Date.time = function() { return Date.now().getUnixTime(); }

  // Get Dates Between
  Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
  }
  function getDates(startDate, stopDate) {
    let dateArray = new Array();
    let currentDate = startDate;
    while (currentDate <= stopDate) {
      dateArray.push(new Date (currentDate));
      currentDate = currentDate.addDays(1);
    }
    return dateArray;
  }
  // Add days to a date
  function addDays(date, days) {
    var result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
  }


  // Animate Css callback function
  $.fn.extend({
    animateCss: function(animationName, callback) {
      var animationEnd = (function(el) {
        var animations = {
          animation: 'animationend',
          OAnimation: 'oAnimationEnd',
          MozAnimation: 'mozAnimationEnd',
          WebkitAnimation: 'webkitAnimationEnd',
        };

        for (var t in animations) {
          if (el.style[t] !== undefined) {
            return animations[t];
          }
        }
      })(document.createElement('div'));

      this.addClass('animated ' + animationName).one(animationEnd, function() {
        $(this).removeClass('animated ' + animationName);

        if (typeof callback === 'function') callback();
      });

      return this;
    },
  });
  
  /*=====  End of General JS  ======*/
  


  $(".exitButton").click(function(event) {
    swal({
      title: "Are you sure to exit?",
      text: "Some information will not be saved",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        window.location.href = base_url;
      } 
    });
  });

  $('.datepicker').datepicker({
    autoclose: 'true',
    startDate: 'dateToday',
    todayHighlight: 'true',    
  });

// loading button
$('.proceed').on('click', function() {
  let startDate  = $('.startDate').datepicker('getDate').getUnixTime();  
  let endDate  = $('.endDate').datepicker('getDate').getUnixTime();  

  var $this = $(this);
  var loadingText = 'Checking <i class="fa fa-spinner fa-spin"></i> ';
  if ($(this).html() !== loadingText) {
    $this.data('original-text', $(this).html());
    $this.html(loadingText);
  }
  ajaxCheckReservation(startDate, endDate);

  setTimeout(function() {
    $this.html($this.data('original-text'));

  }, 2000);


});

function ajaxCheckReservation(dateIn,dateOut) {
  $.ajax({
    url: base_url+'Reservation/checkReservation',
    type: 'post',
    dataType: 'json',
    data: {
      dateIn,
      dateOut
    },
    success: function(data){
      console.log(data);
    }
  });
  
}


/*=======================================
=            Select Rooms JS            =
=======================================*/ 

$(".roomQty").on('change', function(event) { 
  let total = 0;
  let htmlDiv = ""; 
  let hasItem = false;
  // get value of each select and add to list
  $(".roomQty").each(function()
  {
   let roomId =  $(this).attr('data-id');
   let roomPrice = parseInt($(this).attr('data-price'));
   let qty = parseInt($(this).val()); 
   // Computation
   total += roomPrice * qty; 


   // Creating list of selected rooms
   if (qty > 0) { 
    hasItem = true;
    let roomName = $("#roomName"+roomId).text();
    htmlDiv += '<div class="col-md-6">'+'<h6>'+roomName+'</h6>'+'</div>'+
    '<div class="col-md-3">'+'<h6>'+qty+'</h6>'+'</div>'+
    '<div class="col-md-3">'+'<h6>'+(roomPrice * qty)+'</h6>'+'</div>'; 
    $("#viewItemsDiv").html(htmlDiv); 
  }
});  

  if (hasItem == false) {

    htmlDiv = '<div class="container"><h6 class="text-muted">Select a room to start booking</h6></div>';
    $("#viewItemsDiv").html(htmlDiv); 

  }

  $("#totalPrice").text(total.toLocaleString())
});

/*=====  End of Select Rooms JS  ======*/


/*=======================================
=            Proceed Button            =
=======================================*/

$(".btnProceed").click(function(event) {
  let step = $(this).attr('date-step'); 
  switch (step) {
    // Step 1
    case "1":
    var $this = $(this);
    var loadingText = 'Checking <i class="fa fa-spinner fa-spin"></i> ';
    let hasItem = false; 
    $(".roomQty").each(function(){ 
     let qty = parseInt($(this).val()); 
     if (qty > 0) { 
      hasItem = true; 
    }
  }); 
    
    if ($(this).html() !== loadingText) {
      $this.data('original-text', $(this).html());
      $this.html(loadingText);
    } 

    setTimeout(function() {
      if (hasItem == false) {
        $("#alertDiv").show('400', function() {
          $("#alertDiv span").text('Select atleast 1 (one) quantity of room.');
          $(this).css('display', 'block');
        });
        $this.html($this.data('original-text'));

      }else{
        $("#alertDiv").fadeOut('400', function() { 
          $(this).css('display', 'none');
          $this.html($this.data('original-text'));
          // go to next step
          nextStep(1);
        }); 

      }
    }, 500);

    break;



    default:
      // statements_def
      break;
    }
  });

/*=====  End of Proceed Button  ======*/



/*===================================
=            BreadCrumbs            =
===================================*/




function nextStep(currentStep) {

  switch (currentStep) {
    case 1:
    $("#divSelectRooms").animateCss('zoomOut', function() {
      $("#divSelectRooms").css('display', 'none');  
      $('#divSelectDates').addClass('animated zoomIn');
      $("#divSelectDates").css('display', 'block');
    });

    $("#divStep1").removeClass('stepActive');
    $("#divStep1 h4").removeClass('text-warning');
    $("#divStep1").addClass('stepHide');
    $("#divStep1 h4").addClass('text-muted');

    $("#divStep2").removeClass('stepHide');
    $("#divStep2 h4").removeClass('text-muted');
    $("#divStep2").addClass('stepActive');
    $("#divStep2 h4").addClass('text-warning');
    break;
    default:
      // statements_def
      break;
    }

  }

  /*=====  End of BreadCrumbs  ======*/



});