$(document).ready(function() {

  /*==================================
  =            General JS            =
  ==================================*/
  
  // DATE FUNCTION UNIX TIMESTAMP CONVERTER
  Date.prototype.getUnixTime = function() { return this.getTime()/1000|0 };
  if(!Date.now) Date.now = function() { return new Date(); }
  Date.time = function() { return Date.now().getUnixTime(); }

  // GET DATES BETWEEN
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
  // ADD DATS TO A DATE
  function addDays(date, days) {
    var result = new Date(date);
    result.setDate(result.getDate() + days);
    return result;
  }

  // FUNCTION TO VALIDATE EMAIL
  function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }


  // ANIMATE CSS CALLBACK FUNCTION
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

  $(".exitButton").click(function(event) {
   let step = $(this).attr('data-step');
   returnButton(step);
 });

  $('.datepicker').datepicker({
    autoclose: 'true',
    startDate: 'dateToday',
    todayHighlight: 'true',    
  });


  
  /*=====  End of General JS  ======*/




/*=====================================================
=            SHOW/HIDE ERROR - RESERVATION            =
=====================================================*/

function showError_R(err_msg) {
  $("#alertDiv").show('400', function() {
    $("#alertDiv span").text(err_msg);
    $(this).css('display', 'block'); 
  });
}

function hideError_R() {
 $("#alertDiv").hide('400', function() { 
  $(this).css('display', 'none'); 
});
}

/*=====  End of SHOW/HIDE ERROR - RESERVATION  ======*/




/*========================================
=            GLOBAL VARIABLES            =
========================================*/

let totalPax =  0;
let totalRoomPrice = 0;
let feeCosts = 0;
let totalCharge = 0;
let inputAdult = 0;
let inputChild = 0;
let allReservedRoomType = [];
let allReservedRoomQty = [];
let stayTypeChk = null;

/*=====  End of GLOBAL VARIABLES  ======*/


//  /*===========================================
//  =            RESERVATION CHECKER            =
//  ===========================================*/

//  function disableReservedDates(selectedRoomsID) {
//   let reservedDatesAjax = [];

//   // GET DATES
//   $.ajax({
//     url: base_url+'Reservation/checkReservation',
//     type: 'post',
//     dataType: 'json',
//     data: {
//       selectedRoomsID
//     },
//     success: function(data){

//       for($i=0; $i<data.length;$i++){
//         let start = new Date(data[$i]['in']);
//         let end = new Date(data[$i]['out']);

//         var options = { 
//           year: "numeric",
//           month: "2-digit",
//           day: "2-digit"
//         };
//           // GET DATES BETWEEN 
//           let datesBetweenAjax = getDates(start,end);
//           datesBetweenAjax.forEach(element => {
//             element = element.toLocaleString('en-US',options).split(",")[0];
//             reservedDatesAjax.push(element)
//           });
//           // DATEPICKER UPDATE, SETTING RESERVED DATES TO DISABLED DATES

//         }


//         $('.input-daterange input').each(function() {
//           $('.datepicker').datepicker().on("show", function(e) {
//             $('.disabled-date').tooltip({
//               "title": "Reserved"
//             });
//           }); 
//           $(this).datepicker('setDatesDisabled', reservedDatesAjax);
//           reservedDates = reservedDatesAjax;
//         });  
//       }
//     });

// }


// // VALIDATION FOR INBETWEEN RESERVED DATES
// $('.datepicker').datepicker().on('changeDate', function (ev) {

//   // GATHER DATES DATA
//   let start = $('.startDate').datepicker('getDate');   
//   let end = $('.endDate').datepicker('getDate');  
//   let checker = false;
//   // GET DATES BETWEEN
//   let datesBetween = getDates(start,end);

//    // FORMAT DATE FOR DATE CHECKING
//    datesBetween.forEach(function(element){
//     var options = { 
//       year: "numeric",
//       month: "2-digit",
//       day: "2-digit"
//     };
//     var element = element.toLocaleString('en-US',options).split(",")[0];


//     if ( $.inArray(element, reservedDates) > -1 ) {
//       checker = true;

//       $("#alertDiv").show('400', function() {
//         $("#alertDiv span").text('Your selected range overlap an existing reserved date/s');
//         $(this).css('display', 'block');
//         $('.startDate').datepicker('update', '');
//         $('.endDate').datepicker('update', '');
//       });
//     } 
//   });

//    if (checker == false) {
//     $("#alertDiv").hide('400', function() { 
//     });
//   }

// });

// /*=====  End of RESERVATION CHECKER  ======*/






// LOADING BUTTON
$('.proceed').on('click', function() {

  var $this = $(this);
  var loadingText = 'Checking <i class="fa fa-spinner fa-spin"></i> ';
  if ($(this).html() !== loadingText) {
    $this.data('original-text', $(this).html());
    $this.html(loadingText);
  }

  setTimeout(function() {
    $this.html($this.data('original-text'));

  }, 2000);


});


/*=======================================
=            Select Rooms JS            =
=======================================*/ 

$(".roomQty").on('change', function(event) { 
  totalRoomPrice = 0;
  let htmlDiv = ""; 
  let hasItem = false; 
    // GET VALUE OF EACH SELECT AND ADD TO LIST
    $(".roomQty").each(function()
    {
     let roomId =  $(this).attr('data-id');
     let roomPrice = parseInt($(this).attr('data-price'));
     let qty = parseInt($(this).val()); 


     // COMPUTATION
     totalRoomPrice += roomPrice * qty;  

     // CREATING LIST OF SELECTED ROOMS
     if (qty > 0) { 
       hasItem = true;
       let roomName = $("#roomName"+roomId).text();
       htmlDiv += '<div class="col-md-6">'+'<h6>'+roomName+'</h6>'+'</div>'+
       '<div class="col-md-3">'+'<h6>'+qty+'</h6>'+'</div>'+
       '<div class="col-md-3">'+'<h6>'+(roomPrice * qty)+'</h6>'+'</div>'; 
       $(".viewItemsDiv").html(htmlDiv); 
     }
   });   
    console.log(hasItem)

    if (hasItem == false) {

      htmlDiv = '<div class="container"><h6 class="text-muted">Select a room to start booking</h6></div>';
      $(".viewItemsDiv").html(htmlDiv); 

    }

    $(".roomCosts").text(totalRoomPrice.toLocaleString())
  });

/*=====  End of Select Rooms JS  ======*/


/*=======================================
=            Proceed Button            =
=======================================*/

$(".btnProceed").click(function(event) {
  let step = $(this).attr('date-step');  
  let roomID = [];
  let $this = $(this);
  let loadingText = 'Checking <i class="fa fa-spinner fa-spin"></i> ';

  switch (step) {
    // STEP 1
    case "1":

    let hasItem = false; 
    $(".roomQty").each(function(){ 
     let qty = parseInt($(this).val()); 
     if (qty > 0) { 
      roomID.push($(this).attr('data-id'));
      hasItem = true; 
    }
  }); 
    
    // CHANGE CONTENT OF BUTTON
    if ($(this).html() !== loadingText) {
      $this.data('original-text', $(this).html());
      $this.html(loadingText);
    } 

    // SET LOADING BUTTON
    setTimeout(function() {
      if (hasItem == false) {
        $("#alertDiv").show('400', function() {
          $("#alertDiv span").text('Select atleast 1 (one) quantity of room.');
          $(this).css('display', 'block');
        });
        $this.html($this.data('original-text'));

      }else{
        let htmlDivPax = "";
        $("#alertDiv").fadeOut('400', function() { 
          $(this).css('display', 'none');
          $this.html($this.data('original-text'));

          //GET AND SET THE TYPE OF STAY
          stayTypeChk = $("input[name='dayType']:checked").val();
          let content = stayTypeChk == 1 ? "Day Stay" : "Night Stay"
          $(".stayType").text(content);

          // SET THE CONTENT OF PAX DIV
          $(".roomQty").each(function(){
            let qty = parseInt($(this).val()); 
            let roomId =  $(this).data('id'); 
            let roomPax =  $(this).data('pax');  


           //  INSERT THE CONTENT 
           if (qty > 0) {   
            totalPax+= roomPax;
          }
        });  
          htmlDivPax += ' <h6 class="p-2 text-muted">MAXIMUM PAX :  <span class="text-primary">'+totalPax+' PAX</span> </h6>'; 
          $(".paxInfoDiv").html(htmlDivPax); 


          // GO TO THE NEXT STEP
          nextStep(1);
          // disableReservedDates(roomID);
        }); 

      }
    }, 500);

    break;

    // STEP 2
    case "2": 

    // DATE FORMAT OPTION USING LOCALE STRING
    var options = { 
      year: "numeric",
      month: "2-digit",
      day: "2-digit"
    };
    let oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
    let start = $('.startDate').datepicker('getDate');   
    let end = $('.endDate').datepicker('getDate'); 
    inputAdult = $('#inputAdult').val(); 
    inputChild = $('#inputChild').val();   


    // COUNT TOTAL DAYS
    let startDate = new Date($('.startDate').datepicker('getDate'));
    let endDate = new Date($('.endDate').datepicker('getDate'));

    let diffDays = Math.round(Math.abs(( startDate.getTime() - endDate.getTime())/(oneDay)));
    let diff = diffDays == 0 ? 1 : (diffDays+1); 

    // CHANGING CONTENT
    if ($(this).html() !== loadingText) {
      $this.data('original-text', $(this).html());
      $this.html(loadingText);
    } 

    // SET LOADING
    setTimeout(function() {
      if (!start|| end == null) {
        $("#alertDiv").show('400', function() {
          $("#alertDiv span").text('Choose reservation dates first');
          $(this).css('display', 'block');
        });
        $this.html($this.data('original-text'));

      }else if (inputAdult == "0" && inputChild == "0") {
       $("#alertDiv").show('400', function() {
        $("#alertDiv span").text('Include number of persons first');
        $(this).css('display', 'block');
      });
       $this.html($this.data('original-text'));
     }else{ 
      $this.html($this.data('original-text'));
      $("#alertDiv").hide('400', function() { 
        $(this).css('display', 'none');
      });

      // GO TO NEXT STEP
      nextStep(2);

      // SET VALUES TO SPAN ATTRIBUTES
      $(".checkInText").text(start.toLocaleString('en-US',options).split(","));
      $(".checkOutText").text(end.toLocaleString('en-US',options).split(","));
      $(".totalDays").text(diff+" Day/s");

      // ADDING MISC / ENTRANCE FEE
      let entrance_fee = 0;
      // SET TO NULL 
      $(".feeCosts").html("");
      if (parseInt(diff) < 2) {
        console.log("less than");
        if (stayTypeChk == 1) { 
          entrance_fee = (inputAdult * 80) + (inputChild * 50);
          $(".feeCosts").append("<p>Adult ("+inputAdult+") - P"+(inputAdult * 80).toLocaleString()+"</p>"); 
          $(".feeCosts").append("<p>Child ("+inputChild+") - P"+(inputChild * 50).toLocaleString()+"</p>"); 
          $(".feeCosts").append("<hr>"); 
          $(".feeCosts").append("<p>Entrance Fee - P"+entrance_fee.toLocaleString()+"</p>");

        }else{ 
          entrance_fee = (inputAdult * 100) + (inputChild * 70);
          $(".feeCosts").append("<p>Adult ("+inputAdult+") - P"+(inputAdult * 100).toLocaleString()+"</p>"); 
          $(".feeCosts").append("<p>Child ("+inputChild+") - P"+(inputChild * 70).toLocaleString()+"</p>"); 
          $(".feeCosts").append("<p>Entrance Fee - P"+entrance_fee.toLocaleString()+"</p>");

        }
      }

      // CALCULATE TOTAL TAX 
      let userPax = parseInt(inputAdult) + parseInt(inputChild); 
      let tax = parseInt($(".taxCosts").text()); 
      tax = (tax / 100)+1;

      if (totalPax < userPax) { 
        feeCosts = 500;
        $(".feeCosts").append("<p>Add. Pax. - P"+feeCosts.toLocaleString()+"</p>");
      } 

      let totalFee = (totalRoomPrice + feeCosts + entrance_fee)*diff; 
      
      let totalTax = ((totalFee / tax) - totalFee)*(-1);
      
      totalCharge = totalFee;

      $(".taxFee").text('P'+totalTax.toLocaleString('en'));

      $(".totalCharge").text('P'+totalCharge.toLocaleString('en'));



    }
  }, 500);

    break;

    case "3":


    let htmlDivCheckout = ""; 
    
    $(".adultText").text(inputAdult);
    $(".childText").text(inputChild);

    // GET ALL ROOM TYPES AND ROOM QTY
    $(".roomQty").each(function(){
      let qty = parseInt($(this).val()); 
      let roomId =  $(this).data('id');
      //  INSERT THE CONTENT 
      if (qty > 0) {  
        let roomName = $("#roomName"+roomId).text(); 
        htmlDivCheckout +=  '<h6>'+roomName+'</h6>';
        // allReservedRoomType.push(roomId);
        allReservedRoomQty.push(qty);
      }else{
       allReservedRoomQty.push(0);
     }
   });

    $(".roomsText").html(htmlDivCheckout);

    nextStep(3);


    break;

    case "4":
    // VALIDATION OF USER DETAILS
    let fname = $("#firstName").val();
    let lname = $("#lastName").val();
    let gender = $("#gender").find(':selected').val();
    let phone = $("#mobileNumber").val();
    let address = $("#address").val();
    let email = $("#emailAddress").val();
    let comment = $("#comment").val();
    let agreement = $("#agreement").is(":checked");
    let checkin = $('.startDate').datepicker('getDate').toLocaleString('en-US',options).split(",")[0];   
    let checkout = $('.endDate').datepicker('getDate').toLocaleString('en-US',options).split(",")[0];  
    let error = '';


    if (!fname){  
      error = 'First Name field is required';
      showError_R(error);
    } 
    else if (!lname){  
      error = 'Last Name field is required';
      showError_R(error);
    } 
    else if (!gender){  
      error = 'Gender field is required';
      showError_R(error);
    } 
    else if (!phone){  
      error = 'Phone field is required';
      showError_R(error);
    } 
    else if (phone.length != 11){  
      error = 'Phone number must be 11 digits';
      showError_R(error);
    } 
    else if (!address){  
      error = 'Address field is required';
      showError_R(error);
    } 
    else if (!email){  
      error = 'Email field is required'; 
      showError_R(error);
    }else if (!validateEmail(email)) {
      error = 'Enter valid email'; 
      showError_R(error);
    }else if (!agreement){  
      error = 'Please accept the Terms and Condition'; 
      showError_R(error);
    } 
    else { 
      hideError_R();
      $.ajax({
       url: base_url+'Reservation/addReservation',
       type: 'post',
       dataType: 'json',
       data: {
        checkin,
        checkout,
        inputAdult,
        inputChild,
        allReservedRoomQty,
        stayTypeChk,
        comment,
        // allReservedRoomType, 
        fname,
        lname,
        gender,
        phone,
        address,
        email, 
        totalCharge,
      },success: function(data){  
        if (data[0] == true) {
          swal({
            title: "TRANSACTION KEY: "+data[1],
            text: "Get a pen and paper, take down this IMPORTANT transaction key. This will serve as your code to view, edit, and as well as pay your reservation.",
            icon: "warning",
            buttons: "Proceed",
            closeOnClickOutside: false, 
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Reservation sent", {
                icon: "success",
                closeOnClickOutside: false,
              }).then(()=>{
                window.location.href = base_url
              });
            }  
          });
        }
      }
    });
    }
    

    break;

  }
});

/*=====  End of Proceed Button  ======*/


/*===================================
=            Back Button            =
===================================*/

function returnButton(step) {
 switch (step) {

  case "1":
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
  break;

  case "2":
  previousStep(2)
  break;

  case "3":
  previousStep(3)
  break;

  case "4":
  previousStep(4);
  break;


}
}

/*=====  End of Back Button  ======*/




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

    // div 1
    $("#divStep1").removeClass('stepActive');
    $("#divStep1 h4").removeClass('text-warning');
    $("#divStep1").addClass('stepHide');
    $("#divStep1 h4").addClass('text-muted');

    // div 2
    $("#divStep2").removeClass('stepHide');
    $("#divStep2 h4").removeClass('text-muted');
    $("#divStep2").addClass('stepActive');
    $("#divStep2 h4").addClass('text-warning');

    // button
    $(".exitButton").removeClass('btn-danger');
    $(".exitButton").addClass('btn-warning');
    $(".exitButton").text(' Back ');
    $(".exitButton").attr('data-step', '2');

    break; 


    case 2:
    $("#divSelectDates").animateCss('zoomOut', function() {
      $("#divSelectDates").css('display', 'none');  
      $('#divConfirmReservation').addClass('animated zoomIn');
      $("#divConfirmReservation").css('display', 'block');
    });

    // div 1
    $("#divStep2").removeClass('stepActive');
    $("#divStep2 h4").removeClass('text-warning');
    $("#divStep2").addClass('stepHide');
    $("#divStep2 h4").addClass('text-muted');

    // div 2
    $("#divStep3").removeClass('stepHide');
    $("#divStep3 h4").removeClass('text-muted');
    $("#divStep3").addClass('stepActive');
    $("#divStep3 h4").addClass('text-warning');

    // button   
    $(".exitButton").attr('data-step', '3');

    break;


    case 3: 
    $("#divConfirmReservation").animateCss('zoomOut', function() {
      $("#divConfirmReservation").css('display', 'none');  
      $('#divGuestDetails').addClass('animated zoomIn');
      $("#divGuestDetails").css('display', 'block');
    });

    // div 1
    $("#divStep3").removeClass('stepActive');
    $("#divStep3 h4").removeClass('text-warning');
    $("#divStep3").addClass('stepHide');
    $("#divStep3 h4").addClass('text-muted');

    // div 2
    $("#divStep4").removeClass('stepHide');
    $("#divStep4 h4").removeClass('text-muted');
    $("#divStep4").addClass('stepActive');
    $("#divStep4 h4").addClass('text-warning');

    // button   
    $(".exitButton").attr('data-step', '4');
    break;
  }

}



function previousStep(currentStep) {
  switch (currentStep) {
    case 1: 

    break;

    case 2: 

    $("#divSelectDates").animateCss('zoomOut', function() {
      $("#divSelectDates").css('display', 'none');  
      $('#divSelectRooms').addClass('animated zoomIn');
      $("#divSelectRooms").css('display', 'block');
    });

      // div 1
      $("#divStep2").removeClass('stepActive');
      $("#divStep2 h4").removeClass('text-warning');
      $("#divStep2").addClass('stepHide');
      $("#divStep2 h4").addClass('text-muted');

      // div 2
      $("#divStep1").removeClass('stepHide');
      $("#divStep1 h4").removeClass('text-muted');
      $("#divStep1").addClass('stepActive');
      $("#divStep1 h4").addClass('text-warning');

      // button
      $(".exitButton").removeClass('btn-warning');
      $(".exitButton").addClass('btn-danger');
      $(".exitButton").text(' Cancel ');
      $(".exitButton").attr('data-step', '1');

      break;

      case 3: 

      $("#divConfirmReservation").animateCss('zoomOut', function() {
        $("#divConfirmReservation").css('display', 'none');  
        $('#divSelectDates').addClass('animated zoomIn');
        $("#divSelectDates").css('display', 'block');
      });

      // div 1
      $("#divStep3").removeClass('stepActive');
      $("#divStep3 h4").removeClass('text-warning');
      $("#divStep3").addClass('stepHide');
      $("#divStep3 h4").addClass('text-muted');

      // div 2
      $("#divStep2").removeClass('stepHide');
      $("#divStep2 h4").removeClass('text-muted');
      $("#divStep2").addClass('stepActive');
      $("#divStep2 h4").addClass('text-warning');

      // button 
      $(".exitButton").attr('data-step', '2');

      break;


      case 4:
      $("#divGuestDetails").animateCss('zoomOut', function() {
        $("#divGuestDetails").css('display', 'none');  
        $('#divConfirmReservation').addClass('animated zoomIn');
        $("#divConfirmReservation").css('display', 'block');
      });

      // div 1
      $("#divStep4").removeClass('stepActive');
      $("#divStep4 h4").removeClass('text-warning');
      $("#divStep4").addClass('stepHide');
      $("#divStep4 h4").addClass('text-muted');

      // div 2
      $("#divStep3").removeClass('stepHide');
      $("#divStep3 h4").removeClass('text-muted');
      $("#divStep3").addClass('stepActive');
      $("#divStep3 h4").addClass('text-warning');

      // button 
      $(".exitButton").attr('data-step', '3');
      break;
    }
  }

  /*=====  End of BreadCrumbs  ======*/


});




