$(document).ready(function() {
	$('.datatable').DataTable(); 
	loadReports();
	const Calendar = document.querySelectorAll('.datepicker'); 
	const Calendar2 = document.querySelectorAll('.datepickerMod'); 

	let  from_date = "";  
	var options = { 
		year: "numeric",
		month: "2-digit",
		day: "2-digit"
	};

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
	  // ADD DATA TO A DATE
	  function addDays(date, days) {
	  	var result = new Date(date);
	  	result.setDate(result.getDate() + days);
	  	return result;
	  }


	// DATE VALIDATION - DATE RANGE VALIDATION
	M.Datepicker.init(Calendar[0],{
		showClearBtn: false,
		minDate: new Date(),
		autoClose: true,  
		onSelect: function(date){
			var to_date_instance = M.Datepicker.getInstance(Calendar[1]);
			to_date_instance.el.value = moment(date.toLocaleString('en-US',options).split(",")[0]).add(1,'day').format('MMM DD, YYYY');
			to_date_instance.setDate(new Date(moment(date.toLocaleString('en-US',options).split(",")[0]).add(1,'day')));

			$(".checkInDate").html(moment(date.toLocaleString('en-US',options).split(",")[0]).format('MMM DD, YYYY'));
			$(".checkOutDate").html(moment(date.toLocaleString('en-US',options).split(",")[0]).add(1,'day').format('MMM DD, YYYY')); 

			let dates = getDates(new Date(date),new Date(to_date_instance.el.value));
			$(".stayLength").html(dates.length + " Day/s");


			M.Datepicker.init(Calendar[1],{ 
				showClearBtn: false,
				autoClose: true,  
				minDate: new Date(date),
				onSelect: function(to_date){
					let dates = getDates(new Date(date),new Date(to_date));
					$(".stayLength").html(dates.length + " Day/s"); 
					$(".checkOutDate").html(moment(to_date.toLocaleString('en-US',options).split(",")[0]).format('MMM DD, YYYY')); 
				}
			}) 
		} 
	})

	M.Datepicker.init(Calendar2,{ 
		showClearBtn: false,
		autoClose: true,  
		minDate: new Date()
	}) 

	

	/*==================================================
	=            SETTING OF DATA - ONCHANGE            =
	==================================================*/

	
	$("#add_stayType").change(function(event) {
		$(".stayType").html($(this).val() == 1 ? "Day Stay" : "Night Stay") 
	});
	
	/*=====  End of SETTING OF DATA - ONCHANGE  ======*/

	$(".btnShowGuestDetails").click(function(event) {
		let guestID = $(this).data('id');
		$.ajax({
			url: base_url+'Admin/fetchGuest',
			type: 'POST',
			dataType: 'json',
			data: {
				guestID
			},
			success: function(data){
				$("#mdlFirstname").val(data.guest_firstname)
				$("#mdlLastname").val(data.guest_lastname)
				$("#mdlGender").val(data.guest_gender)
				$("#mdlPhone").val(data.guest_phone)
				$("#mdlAddress").val(data.guest_address)
				$("#mdlEmail").val(data.guest_email)
			}
		});
		
	});

	/*=========================================
	=            UPDATE DATE ADMIN            =
	=========================================*/
	let defaultDate = ''; 
	
	$(".btnEditDate").click(function(event) {
		let id = $(this).data('id');
		$(".inputEditDate"+id).removeAttr('disabled');
		defaultDate = $(".inputEditDate"+id).val();
		$(".btnClose"+id).css('visibility', '');
		$(this).css('visibility', 'hidden');
		$(".btnSubmit"+id).css('visibility', '');

	});
	
	$(".btnClose").click(function(event) {
		let id = $(this).data('id');
		$(".inputEditDate"+id).attr('disabled','true');
		$(".inputEditDate"+id).val(defaultDate);
		$(this).css('visibility', 'hidden');
		$('.btnSubmit'+id).css('visibility', 'hidden');
		$('.btnEditDate'+id).css('visibility', '');

	});

	$(".btnSubmit").click(function(event) { 
		let id = $(this).data('id');
		const checkIn= $(this).data('in'); 
		const checkOut= $(".inputEditDate"+id).val();
		const res_key = $(this).data('key'); 
		if (moment(checkOut).isBefore(checkIn)) {  
			M.toast({html: 'You have selected a date that is less than the check in date!'})
		}else if (!checkOut) {
			M.toast({html: 'Check out date cannot be empty.'})
		}else{
			$.ajax({
				url: base_url + 'Moderator/updateDate',
				type: 'post',
				dataType: 'json',
				data: { 
					checkOut,
					res_key
				},
				success: function(data){
					if (data == true) {
						$(".inputEditDate"+id).attr('disabled','true');
						$(".inputEditDate"+id).val(checkOut);
						$('.btnClose'+id).css('visibility', 'hidden'); 
						$('.btnSubmit'+id).css('visibility', 'hidden'); 
						$('.btnEditDate'+id).css('visibility', '');
						M.toast({html: 'Succesfully updated date'});

					}else{
						console.log(data)
					}
				}
			});
			
		}
	});


	let defaultDateIn = ''; 
	
	$(".btnEditDateIn").click(function(event) {
		let id = $(this).data('id');
		$(".inputEditDateIn"+id).removeAttr('disabled');
		defaultDateIn = $(".inputEditDateIn"+id).val();
		$(".btnCloseIn"+id).css('visibility', '');
		$(this).css('visibility', 'hidden');
		$(".btnSubmitIn"+id).css('visibility', '');
	});
	
	$(".btnCloseIn").click(function(event) {
		let id = $(this).data('id');
		$(".inputEditDateIn"+id).attr('disabled','true');
		$(".inputEditDateIn"+id).val(defaultDateIn);
		$(this).css('visibility', 'hidden');
		$('.btnSubmitIn'+id).css('visibility', 'hidden');
		$('.btnEditDateIn'+id).css('visibility', '');

	});

	$(".btnSubmitIn").click(function(event) { 
		let id = $(this).data('id');
		const checkOut= $(this).data('out'); 
		const checkIn= $(".inputEditDateIn"+id).val();
		const res_key = $(this).data('key'); 

		// console.log(checkIn,checkOut,res_key)
		if (moment(checkOut).isBefore(checkIn)) {  
			M.toast({html: 'You have selected a date that is greater than the checkout date!'})
		}else if (!checkIn) {
			M.toast({html: 'Check in date cannot be empty.'})
		}else{
			$.ajax({
				url: base_url + 'Moderator/updateDateIn',
				type: 'post',
				dataType: 'json',
				data: { 
					checkIn,
					res_key
				},
				success: function(data){
					if (data == true) {
						$(".inputEditDateIn"+id).attr('disabled','true');
						$(".inputEditDateIn"+id).val(checkIn);
						$('.btnCloseIn'+id).css('visibility', 'hidden'); 
						$('.btnSubmitIn'+id).css('visibility', 'hidden'); 
						$('.btnEditDateIn'+id).css('visibility', '');
						M.toast({html: 'Succesfully updated date'});

					}else{
						console.log(data)
					}
				}
			});

		}
	});
	/*=====  End of UPDATE DATE ADMIN  ======*/


	/*=================================
	=            CHARTS JS            =
	=================================*/
	
	function loadReports(argument) {
		$.ajax({
			url: base_url + 'Admin/loadReports',
			type: 'POST',
			dataType: 'json',
			success: function(data){
				console.log(data)
				// GET WEEK DAYS
				var startOfWeek = moment().startOf('isoWeek');
				var endOfWeek = moment().endOf('isoWeek');

				// GET MONTH
				var date = new Date(), y = date.getFullYear(), m = date.getMonth();
				var firstDay = new Date(y, m, 1);
				var lastDay = new Date(y, m + 1, 0);

				firstDay = moment(firstDay);
				lastDay = moment(lastDay);


				// DAILY CHART
				let dailyData = [];
				let weeklyData = [];
				let weeklyLabel = [];
				let monthlyData = [];
				let monthlyLabel = [];
				let totalDaily = 0; 
				// GET DAILY REPORTS
				for (var i = 0; i < data.length ; i++) {
					let checkin = moment(data[i].date_in_formatted);
					// DAYS
					if (checkin.diff(moment().format('MMM dd, YYYY')) != 0) {
						totalDaily += parseInt(data[i].billing_price); 
					}
					// WEEK
					if(moment(checkin).isBetween(startOfWeek, endOfWeek)){
						weeklyData.push(parseInt(data[i].billing_price));
						weeklyLabel.push(data[i].date_in_formatted);
					}
					// MONTH
					if(moment(checkin).isBetween(firstDay, lastDay)){
						monthlyData.push(parseInt(data[i].billing_price));
						monthlyLabel.push(data[i].date_in_formatted);
					}
				}
				dailyData.push(totalDaily); 

				var daily = document.getElementById("dailyReport") !== null ? document.getElementById("dailyReport").getContext('2d'): '';
				var weekly = document.getElementById("weeklyReport") !== null ? document.getElementById("weeklyReport").getContext('2d'): '';
				var monthly = document.getElementById("monthlyReport") !== null ? document.getElementById("monthlyReport").getContext('2d'): '';
				
				if (daily) {
					var DailyChart = new Chart(daily, {
						type: 'bar',
						data: {
							labels: ["Today's Sale"],
							datasets: [{
								label: 'Total Income',
								data: dailyData,
								backgroundColor: [
								'rgba(255, 99, 132, 0.2)' 
								],
								borderColor: [
								'rgba(255,99,132,1)', 
								],
								borderWidth: 1
							}]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							}
						}
					});
				}
				
				if (weekly) {
					var WeeklyChart = new Chart(weekly, {
						type: 'bar',
						data: {
							labels: weeklyLabel,
							datasets: [{
								label: 'Weekly Income',
								data: weeklyData, 
							}]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							}
						}
					});
				}

				if (monthly) {
					var MonthlyChart = new Chart(monthly, {
						type: 'bar',
						data: {
							labels: monthlyLabel,
							datasets: [{
								label: 'monthly Income',
								data: monthlyData, 
							}]
						},
						options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							}
						}
					});
				}
			}
		});
		
	}
	
	/*=====  End of CHARTS JS  ======*/
	

	$('#calendar').fullCalendar({
		defaultView: 'month',
		header: {
			left:   'prevYear,nextYear title',
			center: '',
			right:  'today prev,next month basicWeek listWeek'
		},  
		timezone: 'Asia/Manila', 
		selectable: true,
		events: function(start, end, timezone, callback) {  
			jQuery.ajax({
				url: base_url+'Moderator/fetchReservations',
				type: 'POST',
				dataType: 'json',
				data: {
					start: start.unix(),
					end: end.unix()
				},
				success: function(data) {
					var events = [];
					for (var i = 0; i < data.length; i++) {
						events.push({
							title: data[i].reservation_key,
							start: moment.unix(data[i].reservation_in).format("YYYY-MM-DD"),
							end: moment.unix(data[i].reservation_out).add(1,'day').format("YYYY-MM-DD")
						}); 

					} 
					callback(events);
				}
			});
		},
		eventClick: function(calEvent, jsEvent, view) {  
			// FETCH RESERVATION DETAILS
			let rKey = calEvent.title;
			$.ajax({
				url: base_url + 'Moderator/fetchReservationDetails',
				type: 'post',
				dataType: 'json',
				data: {
					rKey
				},
				success: function(data){  
					console.log(data)
					// totalFee
					$(".totalFee").html('P'+ numeral(data.billing[0].billing_price).format('0,0'));
					$(".titleKey").html(rKey);
					$('#downloadPdf').attr('data-id', rKey);
					$("#checkin").html(moment.unix(data.reservation_in).format("MMMM Do, YYYY"));
					$("#checkout").html(moment.unix(data.reservation_out).format("MMMM Do, YYYY"));
					$("#lengthStay").html(data.stay_length + " Day/s");
					$("#stayType").html(data.stay_type);
					$("#adultCount").html(data.reservation_adult + " Adult/s");
					$("#childCount").html(data.reservation_child + " Child/ren");

					$(".btnUpdateBilling").attr('data-key', rKey);
					$(".btnCheckout").attr('data-key', rKey);
					if (data.reservation_roomCount > 0) {
						$("#roomType1").css('display', 'block');
						$("#roomType1_lbl").html(data.room_1_type);
						$("#roomType1_count").html(data.reservation_roomCount + " Room/s");
					}else{
						$("#roomType1").css('display', 'none'); 
					}
					if (data.room_2 > 0) {
						$("#roomType2").css('display', 'block');
						$("#roomType2_lbl").html(data.room_2_type);
						$("#roomType2_count").html(data.room_2 + " Room/s");
					}else{
						$("#roomType2").css('display', 'none');
					}
					// MISCS
					if (data.miscs == false) {
						$(".miscsTitle").html('NO MISCELLANEOUS');
						$("#miscsDiv").html("");

					}else{
						$(".miscsTitle").html('MISCELLANEOUS');
						let htmlMiscs = '<div class="col s6"><p>Misc Name</p></div><div class="col s2"><p>Qty</p></div><div class="col s4"><p>Price</p></div>';

						data.miscs.forEach((data,key)=>{
							htmlMiscs+= '<div class="col s6"><p>'+data.billing_name+'</p></div><div class="col s2"><p>'+data.billing_quantity+'</p></div><div class="col s4"><p>P'+data.billing_price+'</p></div>';
						});

						$("#miscsDiv").html(htmlMiscs);
					}
					var instance = M.Modal.getInstance(document.getElementById('mdlViewResDetails'));
					instance.open();
				}  
			}); 
		},
		select:  function(startDate, endDate) {  

			if(startDate.isBefore(moment().subtract(1,'day'))) { 
				M.toast({html: 'You have selected a date that has already passed!'})
				$('#calendar').fullCalendar('unselect');
				return false;
			}

			swal({
				title: "ADD RESEVATION?",
				type: 'info',
				text: 'Click okay to proceed to reservation details',
				reverseButtons: true, 
				showCancelButton: true,

			}).then((proceed)=>{ 
				if (proceed.value) {
					$("#add_checkin").val(startDate.format('MMM DD, YYYY'));
					$("#add_checkout").val(endDate.subtract(1,'day').format('MMM DD, YYYY'));

					$(".checkInDate").html(startDate.format('MMM DD, YYYY'));
					$(".checkOutDate").html(endDate.format('MMM DD, YYYY')); 
					$(".stayType").html("Day Stay");

					let dates = getDates(new Date(startDate),new Date(endDate));
					$(".stayLength").html('<b>'+dates.length + " Day/s"+'</b>');


					$("#divCalendar").fadeOut('fast', function() {
						$(this).css('display', 'none');
						$("#divAddRes").fadeIn('fast', function() {
							$(this).css('display', 'block');
						});
					});
				}
			});
		}, 
	}); 


$(".btnEditSingleRoom").click(function(event) {
	let roomID = 1;
	$(".roomDescTitle").html('Single Bedroom Description');
	$.ajax({
		url: base_url + 'Moderator/loadDescription',
		type: 'POST',
		dataType: 'json',
		data: {
			roomID
		},
		success: function(data){
			$("#roomDescription").val(data.room_type_description);
			$(".btnUpdateDesc").attr('data-id',roomID);
			$("#roomDescription").focus();
			M.textareaAutoResize($('#roomDescription'));
		}
	});
	
});

$(".btnEditDoubleRoom").click(function(event) { 
	let roomID = 2; 
	$(".roomDescTitle").html('Double Bedroom Description');
	$.ajax({
		url: base_url + 'Moderator/loadDescription',
		type: 'POST',
		dataType: 'json',
		data: {
			roomID
		},
		success: function(data){
			$("#roomDescription").val(data.room_type_description);
			$(".btnUpdateDesc").attr('data-id',roomID);
			$("#roomDescription").focus(); 
			M.textareaAutoResize($('#roomDescription'));
		}
	});
});

$(".btnUpdateDesc").click(function(event) {
	let roomID = $(this).attr('data-id');
	let roomDescription = $("#roomDescription").val()

	$.ajax({
		url: base_url + 'Moderator/updateDesc',
		type: 'post',
		dataType: 'json',
		data: {
			roomID,
			roomDescription
		},
		success: function(data){
			if (data == true) {
				swal({
					title: "SUCCESFULLY UPDATED",
					type: 'success',
					text: 'Succesfully updated room description',
					closeOnClickOutside: false
				}).then((reload)=>{
					if (reload.value) {
						location.reload();
					}
				});
			}
		}
	});

});


$(".btnProceedGuest").click(function(event) {
	var instance = M.Tabs.getInstance(document.getElementById('addReservationTab'));
	instance.select('guestDetails'); 
});

$("#chkAddRoom_0").change(function(event) {
	var atLeastOneIsChecked = $('#chkAddRoom_0').is(':checked') ||  $('#chkAddRoom_1').is(':checked') ;
	console.log(atLeastOneIsChecked)
	if (atLeastOneIsChecked) {
		if($(this).prop('checked')) {
			$("#addRoom_0").removeAttr('disabled');
			$("#addRoom_0").val(1);  
		}else{
			$("#addRoom_0").attr('disabled',true);
			$("#addRoom_0").val(0);
		}
	}else{
		$(this).prop("checked",true);
		M.toast({html: 'Cannot diselect, must select atleast one room type'})
	}

});

// ADD ROOMS BUTTON
$(".btnSubmitRooms").click(function(event) {
	let singleRoomCount = $("#addRoom_0").val(); 
	let doubleRoomCount = $("#addRoom_1").val();

	$.ajax({
		url: base_url + 'Moderator/addRooms',
		type: 'post',
		dataType: 'json',
		data: {
			singleRoomCount,
			doubleRoomCount
		},
		success: function(data){
			if (data == true) {
				swal({
					title:'ROOMS ADDED',
					type: 'success',
					text: 'SUCCESSFULLY ADDED ROOMS',
					allowOutsideClick: false,
					allowEscapeKey: false,
				}).then((data)=>{
					if (data.value) {
						location.reload();
					}
				})
			}
		}
	});

});

$("#chkAddRoom_1").change(function(event) { 
	var atLeastOneIsChecked = $('#chkAddRoom_0').is(':checked') ||  $('#chkAddRoom_1').is(':checked') ;
	if (atLeastOneIsChecked) {
		if($(this).prop('checked')) {
			$("#addRoom_1").removeAttr('disabled');
			$("#addRoom_1").val(1); 
		}else{
			$("#addRoom_1").attr('disabled',true);
			$("#addRoom_1").val(0);
		}
	}else{
		$(this).prop("checked",true);
		M.toast({html: 'Cannot diselect, must select atleast one room type'})
	}

});


// CHECKOUT
$(".btnCheckout").click(function(event) {
	let rKey = $(this).data('key');
	swal({
		title: "RESERVATION CHECKOUT",
		type: 'question',
		text: 'Are you sure to check out this reservation?',
		reverseButtons: true,
		showCancelButton: true,
	}).then((checkout)=>{
		if (checkout.value) {
			$.ajax({
				url: base_url + 'Moderator/checkout',
				type: 'post',
				dataType: 'json',
				data: {
					rKey
				},
				success:function (data){
					if (data == true) {
						swal({
							title: "SUCCESFULLY CHECKED OUT",
							type: "success",
							text: 'Succesfully checked out!',
							closeOnClickOutside: false,
						}).then(()=>{
							location.reload();
						});
					}else{
						swal("ERROR", {
							type: "error",
							text: data,
							closeOnClickOutside: false,
						}).then(()=>{
							location.reload();
						});
					}
				}
			});

		}
	});
});




let totalCosts = 0;
$(".btnProceedSubmit").click(function(event) {
	let totalRoomCosts = 0;
	let feesHTML = [];
	let roomsHTML = [];

		// DATES BETWEEN
		let dates = getDates(new Date($(".checkInDate").html()),new Date($(".checkOutDate").html())); 

		// USER ROOM COUNT
		let room1_count = $("#Room_0").val();
		let room2_count = $("#Room_1").val();

		// ROOM PAX
		let room_0_pax = $("#roomType_0").data('pax');
		let room_1_pax = $("#roomType_1").data('pax');
		let totalRoomPax = room_0_pax + room_1_pax;

		// USER PAX
		let adultCount = $("#add_adultCount").val();
		let childCount = $("#add_childCount").val();
		let totalUserPax = parseInt(adultCount) + parseInt(childCount);

		// ROOM FEE
		if (room1_count > 0) {
			roomsHTML.push('<div class="col s4">'+$("#roomType_0").val()+'</div>'+
				'<div class="col s2">'+room1_count+'</div>'+
				'<div class="col s2">'+(1500).toLocaleString()+'</div>'+
				'<div class="col s2">'+dates.length+' Day/s</div>'+
				'<div class="col s2">P'+((room1_count*1500*(dates.length)).toLocaleString())+'</div>');
			totalRoomCosts += (room1_count*1500);
		}
		if (room2_count > 0) {
			roomsHTML.push('<div class="col s4">'+$("#roomType_1").val()+'</div>'+
				'<div class="col s2">'+room2_count+'</div>'+
				'<div class="col s2">'+(2000).toLocaleString()+'</div>'+
				'<div class="col s2">'+dates.length+' Day/s</div>'+
				'<div class="col s2">P'+((room2_count*2000*(dates.length)).toLocaleString())+'</div>');
			totalRoomCosts += (room2_count*2000); 
		}
		totalRoomCosts *= dates.length;

			// ROOM FEE HTML
			$(".totalRoomCosts").html('<b>P'+totalRoomCosts.toLocaleString()+'</b>')
			totalCosts += (totalRoomCosts);

			// IF EXCESSIVE PAX
			if (totalRoomPax < totalUserPax) {  
				feesHTML.push('<b>Add. Pax - P500</b>');
				totalCosts += 500;
			}

			// ENTRANCE FEE 
			if (dates.length < 2) {
				let adultEntFee = 0;
				let childEntFee = 0;

				// IF DAY/NIGHT STAY 
				if ($("#add_stayType").val() == 1) {
					adultEntFee = adultCount * 80;
					if (childCount > 0) { 
						childEntFee = childCount * 50;
					}
				}else{
					adultEntFee = adultCount * 100;
					if (childCount > 0) { 
						childEntFee = childCount * 70;
					}
				}

				feesHTML.push('Adult/s  ('+adultCount+') - P' + adultEntFee);

				if (childCount > 0) {   
					feesHTML.push('Child/ren  ('+childCount+') - P' + childEntFee );  
				}
				feesHTML.push('<b>Entrance Fee - ' + (adultEntFee+childEntFee) +"</b>"); 
				totalCosts += (adultEntFee+childEntFee);
			}

			// ADDITIONAL FEES APPEND
			$(".addFee").html("");
			if (feesHTML.length > 0) {
				feesHTML.forEach((value,key)=>{
					$(".addFee").append(value + "<br/>"); 
				})
			}else{
				$(".addFee").html("No Additional Fees");
			}

			// ROOM APPEND
			$(".roomsDiv").html(""); 
			roomsHTML.forEach((value,key)=>{
				$(".roomsDiv").append(value); 
			})

			// TAX COMPUTATION
			let tax = parseInt($(".taxPercent").data('tax')); 
			tax = (tax / 100)+1;
			let totalTax = ((totalCosts / tax) - totalCosts)*(-1);
			$(".taxFee").html('P'+ Math.round(totalTax).toLocaleString());

			// TOTAL COSTS
			$(".totalCosts").html('<b>'+"P" + totalCosts.toLocaleString()+'</b>');

				// AJAX = GUEST DETAILS VALIDATION
				let add_firstname = $("#add_firstname").val();
				let add_lastname = $("#add_lastname").val();
				let add_gender = $("#add_gender").val();
				let add_phone = $("#add_phone").val();
				let add_email = $("#add_email").val();
				let add_address = $("#add_address").val();
				let add_request = $("#add_request").val();

				$.ajax({
					type:"POST",
					dataType: "json",
					url: base_url + "Moderator/guestValidation",
					data:{
						add_firstname,
						add_lastname,
						add_gender,
						add_phone,
						add_email,
						add_address,
						add_request
					},
					success:function (data) {
						if(data != true){  
							var size = Object.keys(data.error).length; 
							Object.entries(data.error).forEach(([key, val]) => {    
								M.toast({html: val})       
							});
						}else{
							$("#resGuestDetailsDiv").fadeOut('fast', function() {
								$(this).css('display', 'none');
								$("#summaryDiv").fadeIn('fast', function() {
									$(this).css('display', 'block');
								});
							});
						} 
					}
				});    
			});


$(".btnSubmitReservation").click(function(event) {
	// GUEST DETAILS
	let add_firstname = $("#add_firstname").val();
	let add_lastname = $("#add_lastname").val();
	let add_gender = $("#add_gender").val();
	let add_phone = $("#add_phone").val();
	let add_email = $("#add_email").val();
	let add_address = $("#add_address").val();
	let add_request = $("#add_request").val();

	// RESERVATION DETAILS
	let add_checkin = $("#add_checkin").val();
	let add_checkout = $("#add_checkout").val();
	let add_stayType = $("#add_stayType").val();
	let add_adultCount = $("#add_adultCount").val();
	let add_childCount = $("#add_childCount").val();
	let Room_0 = $("#Room_0").val();
	let Room_1 = $("#Room_1").val();

	$.ajax({
		url: base_url + 'Moderator/addReservation',
		type: 'post',
		dataType: 'json',
		data: {
			add_firstname,
			add_lastname,
			add_gender,
			add_phone,
			add_email,
			add_address,
			add_request,
			add_checkin,
			add_checkout,
			add_stayType,
			add_adultCount,
			add_childCount,
			Room_0,
			Room_1,
			totalCosts
		},
		success: function(data){
			if (data[0] == true) {
				swal({
					title: "TRANSACTION KEY: "+data[1],
					text: "Get a pen and paper, take down this IMPORTANT transaction key. This will serve as your code to view, edit, and as well as pay your reservation.",
					type: "warning",
					buttons: "Proceed",
					closeOnClickOutside: false, 
				})
				.then((willDelete) => {
					if (willDelete.value) {
						swal({
							title: "RESERVATION ADDED",
							type: "success",
							text: 'Succesfully added reservation!',
							closeOnClickOutside: false,
						}).then(()=>{
							location.reload();
						});
					}  
				});
			}
		}
	});


});

$(".btnReturnResDes").click(function(event) {
	var instance = M.Tabs.getInstance(document.getElementById('addReservationTab'));
	instance.select('resDetails'); 
});

$(".btnReturnGuestDes").click(function(event) {
	$("#summaryDiv").fadeOut('fast', function() {
		$(this).css('display', 'none');
		$("#resGuestDetailsDiv").fadeIn('fast', function() {
			$(this).css('display', 'block');
		});
	});
});	

$(".btnReturnCalendar").click(function(event) {
	swal({
		title: "CANCEL RESEVATION?",
		type: 'error',
		dangerMode: true,
		text: 'All unsaved data will not be recovered',
		reverseButtons: true, 
		showCancelButton: true,
	}).then((proceed)=>{ 
		if (proceed.value) {
			$("#divAddRes").fadeOut('fast', function() {
				$(this).css('display', 'none');
				$("#divCalendar").fadeIn('fast', function() {
					$(this).css('display', 'block');
				});
			});
		}
	});
});

// ADD BILLS
$(".btnAddBills").click(function(event) {  
	$('#mdlViewResDetails').modal('close');
});

let counterAdd = 0;
$(".btnAddMore").click(function(event) {
	// addBillsContent
	htmlAdd = '	<div class="row" id="divAddBill'+counterAdd+'">'+
	'<div class="col s4 input-field">'+
	'<input id="miscName'+counterAdd+'" name="miscName[]" placeholder="E.g Umbrella" type="text" class="validate">'+
	'<label for="miscName'+counterAdd+'">Miscellaneous Name</label>'+
	'</div>'+
	'<div class="col s4 input-field">'+
	'<input id="miscPrice'+counterAdd+'" name="miscPrice[]" placeholder="" type="text" class="validate">'+
	'<label for="miscPrice'+counterAdd+'">Price</label>'+
	'</div>'+
	'<div class="col s3 input-field">'+
	'<input id="miscQty'+counterAdd+'" name="miscQty[]" min="1" value="1" max="250" type="number" class="validate">'+
	'<label for="miscQty'+counterAdd+'">Quantity</label>'+
	'</div>'+
	'<div class="col s1">'+
	'<i class="material-icons red-text btnRemoveAddedBill" onclick="" data-id="'+counterAdd+'" style="cursor: pointer;">close</i>'+
	'</div>'+
	'</div>';
	counterAdd++;
	$("#addBillsContent").append(htmlAdd);
});

$(document).on("click", ".btnRemoveAddedBill", function(event) {  
	let id = $(this).data('id'); 
	$("#divAddBill"+id).remove();
}); 

$(".btnUpdateBilling").click(function(event) {
	let isAllValid = true;
	let rKey = $(this).data('key'); 
	let miscName = $("input[name^=miscName]").map(function(idx, elem) {
		return $(elem).val();
	}).get();
	let miscPrice = $("input[name^=miscPrice]").map(function(idx, elem) {
		return $(elem).val();
	}).get();
	let miscQty = $("input[name^=miscQty]").map(function(idx, elem) {
		return $(elem).val();
	}).get(); 

	miscName.forEach((data,key)=>{
		if (data == "") {
			M.toast({html: "Please fill out Miscellaneous Name on item #" + (key+1)});   
			isAllValid = false;
		}
	});
	miscPrice.forEach((data,key)=>{
		if (data == "") {
			M.toast({html: "Please fill out Miscellaneous Price on item #" + (key+1)});   
			isAllValid = false;
		}else if (isNaN(data)) {
			M.toast({html: "Not a valid Miscellaneous Price on item #" + (key+1)});    
			isAllValid = false;
		}
	}); 

	if (isAllValid == true) {
		$.ajax({
			url: base_url + 'Moderator/addBilling',
			type: 'POST',
			dataType: 'json',
			data: {
				miscName,
				miscPrice,
				miscQty,
				rKey
			},
			success: function(data){
				if (data == true) {
					swal({
						title: 'SUCCESS',
						text: 'Succesfully added billing/s',
						type: 'success',
						allowEscapeKey: false, 
					}).then((result) => {
						if (result.value) {
							location.reload();
						}
					})
				}else{
					swal(
						'ERROR',
						data,
						'error'
						);
				}
			}
		}); 
	}

});

$(".btnAddModerator").click(function(event) {
	let first_name = $("#first_name").val();
	let last_name = $("#last_name").val();
	let username = $("#username").val();
	let password = $("#password").val();
	let confirm_password = $("#confirm_password").val();

	$.ajax({
		type:"POST",
		dataType: "json",
		url: base_url + "Admin/addModerator",
		data:{
			first_name,
			last_name ,
			username ,
			password,
			confirm_password, 
		},
		success:function (data) {
			if(data == true){ 
				swal({
					title: 'Moderator has been added!',
					text: 'Moderator has been added and has a default status of active',
					type: 'success',
					closeOnClickOutside: false,
				}).then(()=>{
					location.reload();
				})
			}else{ 
				var size = Object.keys(data.error).length; 
				Object.entries(data.error).forEach(([key, val]) => {    
					M.toast({html: val})       
				});
			}
		}
	});      
});

// ONCHECK ROOM STATUS 
$(".chkModifyRoomStatus").change(function (event) {
	var value = $(this).prop("checked") ? 3 : 2;
	var str_val = $(this).prop("checked") ? "VACANT" : "CLEANING";
	var id = $(this).data('id');

	$.ajax({
		url: base_url+'Moderator/updateRoomStatus',
		type: 'post',
		dataType: 'json',
		data: {
			id,
			value
		},
		success: function (data) {
			$(".roomstat" + id).html(str_val);
			if (value == 2) {
				$(".roomstat" + id).removeClass('green-text');
				$(".roomstat" + id).addClass('orange-text text-accent-3');
			} else {
				$(".roomstat" + id).removeClass('orange-text text-accent-3');
				$(".roomstat" + id).addClass('green-text');
			}

			M.toast({html: '<span>Room Status Updated</span>'})       

		}
	});
});
// oncheck moderator status
$(".chk_moder_status").change(function (event) {
	var value = $(this).prop("checked") ? 1 : 0;
	var str_val = $(this).prop("checked") ? "ACTIVE" : "INACTIVE";
	var id = $(this).data('id');

	$.ajax({
		url: base_url+'Admin/updateStatus',
		type: 'post',
		dataType: 'json',
		data: {
			id,
			value
		},
		success: function (data) {
			$(".stat" + id).html(str_val);
			if (value == 0) {
				$(".stat" + id).removeClass('green-text');
				$(".stat" + id).addClass('red-text');
			} else {
				$(".stat" + id).removeClass('red-text');
				$(".stat" + id).addClass('green-text');
			}

			M.toast({html: '<span>Moderator Status Updated</span>'})       

		}
	});
});

$(".btnViewImage").click(function(event) { 
	let src = $(this).attr('data-src');
	$("#imgContainer").attr('src', src);
});

$(".btnApproveRes").click(function(event) {
	let rKey = $(this).data('id');

	swal({
		title: 'APPROVE THIS RESERVATION?',
		text: 'Once approved this status will no longer be changed',
		reverseButtons: true, 
		showCancelButton: true,
		type: 'info'
	}).then((approve)=>{ 
		if (approve.value) {
			$.ajax({
				url: base_url + 'Moderator/approveReservation',
				type: 'post',
				dataType: 'json',
				data: {rKey},
				success: function(data){
					console.log(data)
					if (data == true) {
						swal({
							title: "RERVATION HASE BEEN APPROVED!",
							type: 'success'
						}).then((reload)=>{ 
							location.reload();
						})
					}else{
						swal({
							title: data[0],
							type: 'error',
							text: data[1]
						}) 
					}
				}
			});
		}
	});

});

$(".btnDenyRes").click(function(event) {
	let rKey = $(this).data('id');

	swal({
		title: 'DENY THIS RESERVATION?',
		text: 'Once denied this status will no longer be changed',
		dangerMode: true,
		reverseButtons: true, 
		showCancelButton: true,
		type: 'error'
	}).then((deny)=>{
		if (deny.value) {
			$.ajax({
				url: base_url + 'Moderator/denyReservation',
				type: 'post',
				dataType: 'json',
				data: {rKey},
				success: function(data){
					console.log(data)
					if (data == true) {
						swal({
							title: "RERVATION DENIED!",
							type: 'success'
						}).then((reload)=>{ 
							location.reload();
						})
					}
				}
			});
		}
	});
});

$("#downloadPdf").on("click", function() {
	var key = $(this).data('id');
	window.open(base_url + 'Moderator/downloadPDF/' + key);
});

$("#downloadReports").on("click", function() {
	window.open(base_url + 'Admin/downloadReports/');
});

});


