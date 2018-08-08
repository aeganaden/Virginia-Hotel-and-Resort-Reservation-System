$(document).ready(function() { 
	$('.sidenav').sidenav(); 
	$('.tabs').tabs();
	$('.materialboxed').materialbox();
	M.AutoInit();

	$("#btnShowReservation").click(function(event) {
		$("#reservationDetails").fadeIn('fast', function() {
			$(this).css('display', 'block');
		});
	});

	$("#fileInput").change(function(){
		showImage(this); 
	});

	setTimeout(()=>{$("#attention").removeClass('animated')}, 2000);
	$("[type='number']").keypress(function (evt) {
		evt.preventDefault();
	});

	$("#chkRoom_0").change(function(event) {
		var atLeastOneIsChecked = $('input:checkbox').is(':checked');
		if (atLeastOneIsChecked) {
			if($(this).prop('checked')) {
				$("#Room_0").removeAttr('disabled');
				$("#Room_0").val(1); 
				if (parseInt($("#Room_0").attr('data-def')) < $("#Room_0").val()) {
					$("#sdRoom").css('display', 'block');
				}
			}else{
				$("#Room_0").attr('disabled',true);
				$("#Room_0").val(0);
			}
		}else{
			$(this).prop("checked",true);
			M.toast({html: 'Cannot diselect, must select atleast one room type'})
		}

	});

	$("#chkRoom_1").change(function(event) { 
		var atLeastOneIsChecked = $('input:checkbox').is(':checked');
		if (atLeastOneIsChecked) {
			if($(this).prop('checked')) {
				$("#Room_1").removeAttr('disabled');
				$("#Room_1").val(1); 
			}else{
				$("#Room_1").attr('disabled',true);
				$("#Room_1").val(0);
			}
		}else{
			$(this).prop("checked",true);
			M.toast({html: 'Cannot diselect, must select atleast one room type'})
		}

	});

	$("#addMattress").change(function(event) {  

		if($(this).prop('checked')) {
			$("#mattressCount").removeAttr('disabled');
			$("#mattressCount").val(1); 
		}else{
			$("#mattressCount").attr('disabled',true);
			$("#mattressCount").val(0);
		}


	});



	/*===============================================
	=            SUBMIT EDIT RESERVATION            =
	===============================================*/
	
	$(".btnConfirmReservation").click(function(event) {
		let reservation_key = $(this).attr('data-id');
		let stayLength = parseInt($(this).attr('data-days'));
		let entranceFee = $(this).attr('data-entrance');
		let stayType = $(this).attr('data-staytype');
		let adultCount = parseInt($("#adultCount").val());
		let mattressCount = parseInt($("#mattressCount").val());
		let childCount =parseInt( $("#childCount").val());
		let sbRoomCount = parseInt($("#Room_0").val());
		let dbRoomCount = parseInt($("#Room_1").val());
		let def_mattressCount = parseInt($("#mattressCount").attr('data-def'));
		let def_adultCount = parseInt($("#adultCount").attr('data-def'));
		let def_childCount = parseInt($("#childCount").attr('data-def'));
		let def_sbRoomCount = parseInt($("#Room_0").attr('data-def'));
		let def_dbRoomCount = parseInt($("#Room_1").attr('data-def')); 
		let pax_sbRoomCount = parseInt($("#Room_0").attr('data-pax'));
		let pax_dbRoomCount = parseInt($("#Room_1").attr('data-pax')); 
		let listItem = [];

		let entranceFeeTotal = 0;
		let sbRoomFee = 0;
		let dbRoomFee = 0;
		let paxFee = 0;
		let changesTotal = 0; 

		// SOME COMPUTATION FOR ADDITIONAL BILLS


		// ADD/SUBTRACT BILLS FOR PAX CHANGES
		let totalPax = pax_sbRoomCount + pax_dbRoomCount;
		let totalUserPax = adultCount + childCount;
		let defTotalUserPax = def_adultCount + def_childCount; 
		if (totalUserPax > totalPax && totalUserPax > defTotalUserPax) {   
			if (defTotalUserPax < totalPax) {
				paxFee = 500;
				listItem.push({
					['title']: 'PAX Exceeded (Max PAX = '+totalPax+')',
					['qty']:1,
					['total']: paxFee 
				});  
			}
		}else if (totalUserPax < totalPax && totalUserPax < defTotalUserPax) { 
			paxFee = -500;
			listItem.push({
				['title']: 'Decrease in PAX',
				['qty']:1,
				['total']: paxFee 
			});  
		} 


		// ADD/SUBTRACT BILLS FOR ENTRANCE FEE 
		if (entranceFee == "true") {

			// DAY OR NIGHT
			let adultFee = 0;  
			let childFee = 0;
			if (stayType == 1) {
				adultFee = (adultCount - def_adultCount)*80;
				childFee = (childCount - def_childCount)*50; 
			}else{
				adultFee = (adultCount - def_adultCount)*100;
				childFee = (childCount - def_childCount)*70; 
			}

			entranceFeeTotal = adultFee + childFee;

			if (totalUserPax > defTotalUserPax) { 
				// IF PAX HAS INCREASED     
				listItem.push({
					['title']: 'Add. Entrance Fee for increase in PAX',
					['qty']: totalUserPax - defTotalUserPax,
					['total']: entranceFeeTotal
				});   
			}else if((totalUserPax < defTotalUserPax)){
				// IF PAX HAS DECREASED   
				listItem.push({
					['title']: 'Sub. Entrance Fee for decrease in PAX',
					['qty']: totalUserPax - defTotalUserPax,
					['total']: entranceFeeTotal
				});   
			} 
		}

		// ADD MATTRESS
		let totalMattressCount  = mattressCount - def_mattressCount; 
		if (mattressCount > def_mattressCount) {  
			listItem.push({
				['title']: 'Add. Misc. Mattress',
				['qty']: totalMattressCount,
				['total']: (totalMattressCount) * 350
			}); 
			// mattressCount = mattressCount + def_mattressCount;
		}else if(mattressCount < def_mattressCount){ 
			// totalMattressCount = totalMattressCount;
			listItem.push({
				['title']: 'Sub. Misc. Mattress',
				['qty']: totalMattressCount,
				['total']: (totalMattressCount) * 350
			}); 
			// mattressCount = mattressCount *-1;
		}

		// ADD/SUBTRACT BILLS FOR ROOMS
		if (sbRoomCount > def_sbRoomCount) {
			sbRoomFee =  ((sbRoomCount - def_sbRoomCount)*1500)*stayLength;
			listItem.push({
				['title']: 'Increased Single Bedroom count <br/>' +
				'<p class="blue-text" style="font-size: 0.8rem">('+(sbRoomCount - def_sbRoomCount)+' Single Bedroom x P'+1500+' Room Fee x '+stayLength+' Day/s)',
				['qty']: sbRoomCount - def_sbRoomCount,
				['total']:sbRoomFee
			});  
		}else if(sbRoomCount < def_sbRoomCount){
			sbRoomFee =  ((sbRoomCount - def_sbRoomCount)*1500)*stayLength;

			listItem.push({
				['title']: 'Decreased Single Bedroom count'+
				'<p class="blue-text" style="font-size: 0.8rem">('+(sbRoomCount - def_sbRoomCount)+' Single Bedroom x P'+1500+' Room Fee x '+stayLength+' Day/s)',
				['qty']: sbRoomCount - def_sbRoomCount,
				['total']: sbRoomFee
			});  	
		}

		if (dbRoomCount > def_dbRoomCount) {
			dbRoomFee = ((dbRoomCount - def_dbRoomCount)*2000)*stayLength;
			listItem.push({
				['title']: 'Increased Double Bedroom count'+
				'<p class="blue-text" style="font-size: 0.8rem">('+(dbRoomCount - def_dbRoomCount)+' Double Bedroom x P'+2000+' Room Fee x '+stayLength+' Day/s)',
				['qty']: dbRoomCount - def_dbRoomCount,
				['total']: dbRoomFee
			});  
		}else if(dbRoomCount < def_dbRoomCount){
			dbRoomFee = ((dbRoomCount - def_dbRoomCount)*2000)*stayLength;

			listItem.push({
				['title']: 'Decreased Single Bedroom count'+
				'<p class="blue-text" style="font-size: 0.8rem">('+(dbRoomCount - def_dbRoomCount)+' Double Bedroom x P'+2000+' Room Fee x '+stayLength+' Day/s)',
				['qty']: dbRoomCount - def_dbRoomCount,
				['total']: dbRoomFee
			});  	
		}

		// CREATE PARENT DIV 
		var div = document.createElement('div');
		var table = document.createElement('table');
		var thead = document.createElement('thead');
		var tbody = document.createElement('tbody');
		var tr = document.createElement('tr'); 
		var th_1 = document.createElement('th'); 
		var th_2 = document.createElement('th'); 
		var th_3 = document.createElement('th'); 
		th_1.innerHTML = "Fee Changes";
		th_2.innerHTML = "Quantity";
		th_3.innerHTML = "Price";
		tr.appendChild(th_1)
		tr.appendChild(th_2)
		tr.appendChild(th_3)
		thead.appendChild(tr)
		table.appendChild(thead)
		table.appendChild(tbody)

		// CREATE PARAGRAPH
		var paragraph = document.createElement('paragraph');
		// INSERT SOME HTML TEXT
		paragraph.innerHTML = "This will affect your overall payment, it may increase or decrese your reservation fee. <b> Changes are the ff:</b>";
		// APPEND
		div.appendChild(paragraph);
		div.appendChild(table)
		// CREATE UL 


		// APPEND ITEMS ELEMENTS TO DIV
		if (listItem.length > 0) {
			listItem.forEach((element, index) => {
				var tr=document.createElement('tr');
				var td_1=document.createElement('td');
				var td_2=document.createElement('td');
				var td_3=document.createElement('td');
				td_1.innerHTML=element['title'];
				td_2.innerHTML=element['qty'];
				td_3.innerHTML=element['total'];
				tr.appendChild(td_1);
				tr.appendChild(td_2);
				tr.appendChild(td_3);
				tbody.appendChild(tr);
			});
		}else{
			var tr=document.createElement('tr');
			var td_1=document.createElement('td');
			var td_2=document.createElement('td');
			var td_3=document.createElement('td');
			td_1.innerHTML="";
			td_2.innerHTML="No Changes";
			td_3.innerHTML="";
			tr.appendChild(td_1);
			tr.appendChild(td_2);
			tr.appendChild(td_3);
			tbody.appendChild(tr);
		}

		// div.appendChild(ul)
		swal({
			title: "Are you sure to update?", 
			content: div,
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) { 
				changesTotal = entranceFeeTotal + sbRoomFee + dbRoomFee + paxFee; 
				$.ajax({
					url: base_url + 'Payments/updateBills',
					type: 'post',
					dataType: 'json',
					data: {
						changesTotal,
						reservation_key,
						adultCount,
						childCount,
						sbRoomCount,
						dbRoomCount,
						mattressCount
					},
					success: function(data){
						if (data == true) {
							swal("Your reservation has been updated!", {
								icon: "success",
							}).then((success)=>{
								location.reload();
							});
						}
					}
				});
			} 
		});



	});

/*=====  End of SUBMIT EDIT RESERVATION  ======*/










	// ------------------------------------------------------------------------
	/*============================================
	=            ANIMATE CSS CALLBACK            =
	============================================*/
	
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
	
	/*=====  End of ANIMATE CSS CALLBACK  ======*/

	/*==========================================
	=            SHOW SLECTED IMAGE            =
	==========================================*/
	
	function showImage(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$("#imageContainerDiv").fadeIn('fast', function() {
					$('#imageContainer').attr('src', e.target.result);
				});
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	
	/*=====  End of SHOW SLECTED IMAGE  ======*/

	/*==========================================
	=            DELETE RESERVATION            =
	==========================================*/
	
	$(".btnDeleteReservation").click(function(event) {
		let reservation_key = $(this).attr('data-id');
		swal({
			title: "Delete Reservation?",
			text: "Once deleted, this cannot be restore anymore",
			icon: "error",
			buttons: true, 
			dangerMode: true, 
		})
		.then((setPayment) => {
			if (setPayment) { 
				$.ajax({
					url: base_url+'Reservation/deleteReservation',
					type: 'post',
					dataType: 'json',
					data: {
						reservation_key
					},
					success: function(data){
						if (data == true) {
							swal({
								title: "Reservation Deleted",
								text: "Your reservation has now been deleted.",
								icon: "success", 
							}).then((goHome)=>{ 
								window.location.href = base_url;
							});
						}else{
							swal({
								title: "ERROR OCCURED",
								text: data,
								icon: "error", 
							});
						}
					}
				});
				
			} 
		});	
	});
	
	/*=====  End of DELETE RESERVATION  ======*/

	/*========================================
	=            EDIT RESERVATION            =
	========================================*/
	
	$(".btnEditReservation").click(function(event) { 
		// reservationDetails
		// resEditingDiv
		$("#reservationDetails").fadeOut('fast', function() {
			$(this).css('display', 'none');
			$("#resEditingDiv").fadeIn('fast', function() {
				$(this).css('display', 'block');
			});
		});


	});		

	$(".btnCancelEditReservation").click(function(event) { 
		// reservationDetails
		// resEditingDiv
		$("#resEditingDiv").fadeOut('fast', function() {
			$(this).css('display', 'none');
			$("#reservationDetails").fadeIn('fast', function() {
				$(this).css('display', 'block');
			});
		});


	});	

	/*=====  End of EDIT RESERVATION  ======*/
	
	

	/*===============================
	=            PAYMENT            =
	===============================*/

	$("#fileInput").change(function(){
		showImage(this); 
	});
	$("#fileUpload").one('submit', function(event) { 
		event.preventDefault();
		let rID = $(".btnUpdatePayment").attr('data-id'); 
		swal({
			title: "Submit Payment?",
			text: "Once submitted, payment cannot be changed anymore",
			icon: "warning",
			buttons: true, 
		})
		.then((setPayment) => {
			if (setPayment) {
				var file_data = $('#fileInput').prop('files')[0];
				var form_data = new FormData();
				form_data.append('file', file_data); 
				$.ajax({
                        url: base_url+'Payments/updatePayment/'+rID, // point to server-side controller method
                        dataType: 'json', // what to expect back from the server
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (data) {  
                        	console.log(data)
                        	if (data == true) {
                        		swal("Payment method has been updated!", {
                        			icon: "success",
                        		}).then((success)=>{
                        			location.reload();
                        		});
                        	}else{
                        		swal(data.error, {
                        			icon: "error",
                        		});
                        	}
                        }
                        
                    });
			} 
		});	
	});
	/*=====  End of PAYMENT  ======*/

	//LAST --mark
	$(".btnPrintReceipt").on('click', function(event) {
		var form_data = $('#fileUpload').serialize();
		var rID = $(this).data('id');
		$.ajax({
            url: base_url+'Payments/downloadPDF/'+rID, // point to server-side controller method
            dataType: 'json', // what to expect back from the server
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (data) {  
            	console.log(data)
            }
        });
	});
});

