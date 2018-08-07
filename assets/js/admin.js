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
				console.log(data);
			}
		});      
	});
});