$(document).ready(function() {
	$('.datatable').DataTable();

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
	});