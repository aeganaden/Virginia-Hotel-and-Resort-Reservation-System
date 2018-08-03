
<script src="<?=base_url()?>assets/js/lightbox.js"></script>
<script src="<?=base_url()?>assets/js/main.js"></script>
<script>
	
	function appendCode(){
		let transactionID = $("#transaction_id").val();
		$.ajax({
			url: base_url+'Reservation/reservationExists',
			type: 'post',
			dataType: 'json',
			data: {transactionID},
			success: function(data){ 
				if (data == true) {
					var action_src = base_url + "Reservation/viewReservation/" +transactionID;
					var form = document.getElementById('viewReservationForm');
					console.log(action_src);
					window.location.href = action_src;
				}else{
					alert('Reservation does not exists.')
				}
			}
		});
		
	}
</script>
</body>
</html>

