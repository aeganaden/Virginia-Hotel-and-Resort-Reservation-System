
<html>
<head>
	<title><?=$title?></title>
	<style>
	.bord1{
		border:solid 2px black;
	}
	.bord2{
		border:solid 2px pink;
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
					<?php if ($reservation[$key]->reservation_roomCount > 0): ?>
						<strong>Room Type:</strong> <?=$room_type->room_type_name?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<strong>Room Count:</strong> <?=$reservation[$key]->reservation_roomCount?> Bedroom
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<strong>Room Price:</strong> P<?=number_format($room_type->room_type_price)?>
						<div style="margin-top: 5px;"></div>
					<?php endif;?>
				<?php endforeach?>
			</div>
			<div style="margin-top: 20px;"></div>
			<!-- vertically-centered -->
			<div style="font-size: 18px;">
				<div style="margin-left: 480px;">
					<strong>Subtotal:</strong> P<?=number_format($billing_total - $totalTax)?>
				</div>
				<div style="margin-left: 463px; margin-top: -5px;">
					<strong>VAT (<?=$tax . '%'?>):</strong> P<?=number_format($totalTax)?>
				</div>
				<div style="margin-left: 492px; margin-top: -5px;">
					<strong>TOTAL:</strong> P<?=number_format($billing_total)?>
				</div>
			</div>

			<!-- vertically-centered from left side -->
			<!-- <div style="margin-left: 480px;font-size: 18px;">
				<span>
					<strong>Subtotal:</strong> P<?=number_format($billing_total - $totalTax)?>
				</span>
				<br>
				<span>
					<strong>VAT (<?=$tax . '%'?>):</strong> P<?=number_format($totalTax)?>
				</span>
				<br>
				<span>
					<strong>TOTAL:</strong> P<?=number_format($billing_total)?>
				</span>
			</div> -->
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