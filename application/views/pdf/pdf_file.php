
<html>
<head>
	<title><?=$title?></title>
	<style>
	.bord1{
		border:solid 2px  black;
	}
	img {
		height:auto;
		width: 19%;
	}
	.header{
		text-align: center;
	}
	.center_text{
		text-align: center;
	}
	body{
		font-family:chelvetica;
	}
	.body_head{
		border-top: solid 1px black;
		font-size: 20px;
	}
	.resort{
		font-weight: bold;
		font-size: 20px;
	}
	.center {
		margin: auto;
		width: 50%;
		padding: 10px;
	}
	.footer{
		border-top: solid 1px black;
	}
	.summary{
		text-align: center;
		border-bottom: solid 1px black;
		width:80%;
		margin-top: 20px;
		font-weight: bold;
		font-size: 20px;
		color:#e67e22;
	}
</style>
</head>
<body>

	<div class="header">
		<img src="<?=base_url()?>assets/images/11.gif"/><br>
		<span class="resort">Virginia & Boy Lodge and Resort</span> <br>
		502 M.H. Del Pilar ST. Brgy. San Rafael Montalban Rizal
	</div><br>

	<div> <!-- body -->
		<div class="body_head">
			<div style="margin-top: 25px;"></div>
			<span style='font-weight:bold;'>NAME - </span><span style='font-weight:normal;'><?=$fullname?></span><br>
			<span style='font-weight:bold;'>E-MAIL - </span><span style='font-weight:normal;'><?=$email?></span><br><br>
			<span style='font-weight:bold;'>PAYMENTS </span><?=$reservation[0]->reservation_payment_status != 0 ? "- <span style='color:#2ecc71;'>SUBMITTED</span>" : "";?><br>
			<span style='font-weight:bold;'>TRANSACTION - </span><span style='color:#3498db;'><?=$id?></span>
		</div>
		<div class="body_body">
			<div class="center summary">
				SUMMARY
			</div>
			<div style="margin-top: 20px;"></div>
			<div style="font-size: 17px;">
				<strong>Check In:</strong> <?=date('M d, Y - h:i A', $reservation[0]->reservation_in)?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<strong>Check Out:</strong> <?=date('M d, Y - h:i A', $reservation[0]->reservation_out)?>
				<div style="margin-top: 5px;"></div>
				<strong>Length of Stay:</strong> <?=$difference->d + 1?> Day/s
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<strong>Stay Type:</strong> <?=$stay_type?>
				<div style="margin-top: 5px;"></div>
				<?php foreach ($reservation as $key => $value): ?>
					<?php
$room_type = $this->Crud->fetch('room_type', array("room_type_id" => $value->room_type_id));
$room_type = $room_type[0];
?>
					<strong>Room Type:</strong> <?=$room_type->room_type_name?>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<strong>Room Count:</strong> <?=$reservation[0]->reservation_roomCount?> Bedroom
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<strong>Room Price:</strong> P<?=number_format($room_type->room_type_price)?>
					<div style="margin-top: 5px;"></div>
				<?php endforeach?>
			</div>
			<div style="margin-top: 20px;"></div>
			<div style="margin-left: 500px; font-size: 20px;">
				<span>
					<strong>TOTAL:</strong> P<?=number_format($billing_total)?>
				</span>
				<br>
				<span>
					<strong>TAX:</strong> P<?=number_format($totalTax)?>
				</span>
			</div>
		</div>
	</div>

	<div style="margin-top: 100px;"></div>
	<div class="footer" style=""> <!-- footer -->
		<div style="margin-top: 5px;"></div>
		<span style="font-weight: bold;font-size: 17px;">Virginia & Boy Lodge and Resort</span><br>
		Address: 502 M.H. Del Pilar ST. Brgy. San Rafael Montalban Rizal<br>
		Tel: 6669591 / 9852943 / 5708584<br>
		Mobile: 09087404449<br>
		E-mail: Virginia&Boy@gmail.com<br>
	</div>
</body>

</html>