$(document).ready(function() {
	$('.datatable').DataTable();
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
					$(".titleKey").html(rKey);
					$("#checkin").val(moment.unix(data.reservation_in).format("MMMM Do, YYYY"));
					$("#checkout").val(moment.unix(data.reservation_out).format("MMMM Do, YYYY"));
					$("#lengthStay").val(data.stay_length + " Day/s");
					$("#stayType").val(data.stay_type);
					$("#adultCount").val(data.reservation_adult + " Adult/s");
					$("#childCount").val(data.reservation_child + " Child/ren");
					if (data.reservation_roomCount > 0) {
						$("#roomType1").css('display', 'block');
						$("#roomType1_lbl").val(data.room_1_type);
						$("#roomType1_count").val(data.reservation_roomCount);
					}else{
						$("#roomType1").css('display', 'none'); 
					}
					if (data.room_2 > 0) {
						$("#roomType2").css('display', 'block');
						$("#roomType2_lbl").val(data.room_2_type);
						$("#roomType2_count").val(data.room_2);
					}else{
						$("#roomType2").css('display', 'none');
					}
					var instance = M.Modal.getInstance(document.getElementById('mdlViewResDetails'));
					instance.open();
				}  
			}); 
		},
		select:  function(startDate, endDate) {
			// alert('selected ' + startDate.format() + ' to ' + endDsate.subtract(1,'day').format());
			swal({
				title: "ADD RESEVATION?",
				icon: 'info',
				text: 'Click okay to proceed to reservation details',
				buttons: true,
			}).then((proceed)=>{
				if (proceed) {

				}
			});
		}, 
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
						icon: 'success',
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
			buttons: true,
			icon: 'info'
		}).then((approve)=>{
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
							icon: 'success'
						}).then((reload)=>{ 
							location.reload();
						})
					}else{
						swal({
							title: data[0],
							icon: 'error',
							text: data[1]
						}) 
					}
				}
			});
		});
		
	});

	$(".btnDenyRes").click(function(event) {
		let rKey = $(this).data('id');

		swal({
			title: 'DENY THIS RESERVATION?',
			text: 'Once denied this status will no longer be changed',
			dangerMode: true,
			buttons: true,
			icon: 'error'
		}).then((deny)=>{
			if (deny) {
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
								icon: 'success'
							}).then((reload)=>{ 
								location.reload();
							})
						}
					}
				});
			}
		});
	});



});


