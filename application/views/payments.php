	<?php
$reservation = $this->Crud->fetch('reservation', array('reservation_key' => $transactionID));
if ($reservation) {
	$guest = $this->Crud->fetch('guest', array('guest_id' => $reservation[0]->guest_id));
	$guest = $guest[0];
	$fullname = $guest->guest_firstname . " " . $guest->guest_lastname;
}
?>
	<?php if ($reservation): ?>
		<?php $this->load->view('includes/materialize/sidenav', compact('fullname', 'guest', 'reservation'));?>

		<div class="row" id="content">
			<div class="col s1"></div>
			<div class="col s10">
				<div class="row">
					<blockquote class="color-o-ac3">
						<h4 class="black-text" style="font-weight: 300">
							PAYMENTS <?=$reservation[0]->reservation_payment_status != 0 ? "- <span class='green-text'>SUBMITTED</span>" : "";?>
						</h4>

					</blockquote>
				</div>

				<div class="row">
					<h5 class="black-text" style="font-weight: 300">TRANSACTION ID - <span style="font-weight: 500;" class="orange-text accent-3"><?=$reservation[0]->reservation_key?></span> </h5>
				</div>

				<?php
$stay_type = $reservation[0]->reservation_day_type == 1 ? "Day Stay" : "Night Stay";

// Compute length of stay
$datetime1 = new DateTime(date('Y-m-d', $reservation[0]->reservation_in));
$datetime2 = new DateTime(date('Y-m-d', $reservation[0]->reservation_out));
$difference = $datetime1->diff($datetime2);

?>

				<div class="row" id="paymentDiv">
					<div class="card light-blue darken-4">
						<form enctype="multipart/form-data" accept-charset="utf-8" name="fileUpload" id="fileUpload"  method="post">
							<div class="card-content white-text">
								<div class="row">
									<div class="col s12">
										<div class="col s7">
											<h5 class="yellow-text text-lighten-5 flow-text center">SUMMARY</h5>
											<div class="divider"></div>
											<br>

											<div class="row">
												<div class="input-field col s6">
													<i class="material-icons prefix">event</i>

													<input disabled value="<?=date('M d, Y - h:i A', $reservation[0]->reservation_in)?>" id="checkin" name="checkin" type="text" class="checkin validate white-text">
													<label for="checkin"><span class="white-text">Check In</span></label>
												</div>
												<div class="input-field col s6">
													<i class="material-icons prefix">event</i>
													<input disabled value="<?=date('M d, Y - h:i A', $reservation[0]->reservation_out)?>" id="checkout" type="text" name="checkout" class="checkout validate white-text">
													<label for="checkout"><span class="white-text">Check out</span></label>
												</div>
											</div>

											<div class="row">
												<div class="input-field col s6">
													<i class="material-icons prefix">hourglass_empty</i>
													<input disabled value="<?=$difference->d + 1?> Day/s" id="lengthStay" name="lengthStay" type="text" class="validate white-text lengthStay">
													<label for="lengthStay"><span class="white-text">Length of Stay</span></label>
												</div>
												<div class="input-field col s6">
													<i class="material-icons prefix">brightness_4</i>
													<input disabled value="<?=$stay_type?>" id="roomCount" name="stay_type" type="text" class="validate white-text roomCount">
													<label for="roomCount"><span class="white-text">Stay Type</span></label>
												</div>
											</div>

											<div class="row">
												<div class="input-field col s6">
													<i class="material-icons prefix">face</i>
													<input disabled value="<?=$reservation[0]->reservation_adult?> Adult/s" id="lengthStay" type="text" class="validate white-text lengthStay" name="adult_count">
													<label for="lengthStay"><span class="white-text">Adult Count</span></label>
												</div>
												<div class="input-field col s6">
													<i class="material-icons prefix">child_care</i>
													<input disabled value="<?=$reservation[0]->reservation_child?> Child/ren" id="roomCount" type="text" class="validate white-text roomCount" name="child_count">
													<label for="roomCount"><span class="white-text">Child Count</span></label>
												</div>
											</div>
											<?php foreach ($reservation as $key => $value): ?>
												<?php
$room_type = $this->Crud->fetch('room_type', array("room_type_id" => $value->room_type_id));
$room_type = $room_type[0];
?>
												<?php if ($reservation[$key]->reservation_roomCount > 0): ?>
													<div class="row">
														<div class="input-field col s4">
															<i class="material-icons prefix">hotel</i>
															<input id="icon_prefix" disabled value="<?=$room_type->room_type_name?>" type="text" name="room_type" class=" white-text validate">
															<label for="icon_prefix" class="white-text">Room Type</label>
														</div>


														<div class="input-field col s4">
															<i class="material-icons prefix">border_clear</i>
															<input id="icon_prefix" disabled value="<?=$reservation[$key]->reservation_roomCount?> Bedroom" type="text" class=" white-text validate">
															<label for="icon_prefix" class="white-text">Room Count</label>
														</div>

														<div class="input-field col s4">
															<i class="material-icons prefix">monetization_on</i>
															<input id="icon_prefix" disabled value="P<?=number_format($room_type->room_type_price)?>" type="text" class=" white-text validate" name="room_price">
															<label for="icon_prefix" class="white-text">Room Price</label>
														</div>
													</div>
												<?php endif?>
											<?php endforeach?>
											<?php
$billing = $this->Crud->fetch('billing', array('reservation_key' => $reservation[0]->reservation_key));
$billing_total = 0;
$billing_total_negative = 0;
foreach ($billing as $key => $value) {
	$billing_total += ($value->billing_price * $value->billing_quantity);
	if ($value->billing_price * $value->billing_quantity > 0) {
	} else {
		$billing_total_negative += ($value->billing_price * $value->billing_quantity) * -1;
	}
	// echo "$billing_total"."<br>";
}
$billing_total = $billing_total + $billing_total_negative;
$miscs = $this->Crud->fetch_like('billing', 'billing_name', 'Misc.', array('reservation_key' => $reservation[0]->reservation_key));
?>

											<?php if ($miscs): ?>
												<div class="row">
													<h5>Miscellaneous</h5>
													<table>
														<thead>
															<tr>
																<th>Misc. Name</th>
																<th>Misc. Quantity</th>
																<th>Misc. Price</th>
																<th>Total</th>
															</tr>
														</thead>

														<tbody>
															<?php foreach ($miscs as $key => $value): ?>
																<tr>
																	<td><?=$value->billing_name?></td>
																	<td><?=$value->billing_quantity?></td>
																	<td><?=$value->billing_price?></td>
																	<td><?=($value->billing_quantity * $value->billing_price)?></td>
																</tr>
															<?php endforeach?>
														</tbody>
													</table>
												</div>
											<?php endif?>
											<div class="divider"></div>

											<div class="row">
												<div class="row right"  style="margin-right: 3%;">
													<h5>TOTAL : <span class="orange-text accent-2" id="totalPrice">P<?=number_format($billing_total)?></span></h5>
													<h6>DP: <span class="orange-text accent-2" id="dpPrice">P500</span></h6>
												</div>
											</div>

											<?php if ($reservation[0]->reservation_payment_status == 0 && $reservation[0]->reservation_status != 4): ?>
												<div class="row">

													<div class="col s8">
														<div class="file-field input-field" id="bankSlip">
															<div class="btn">
																<span>Upload bank slip</span>
																<input name="fileInput" id="fileInput" type="file" required>
															</div>
															<div class="file-path-wrapper">
																<input class="file-path white-text validate" type="text">
															</div>
														</div>
													</div>
													<div class="col s4" id="imageContainerDiv">
														<img class="responsive-img materialboxed " id="imageContainer" src="" alt="">

													</div>
												</div>
											<?php endif?>
										</div>
										<div class="col s5">
											<h5 id="attention" class="yellow-text text-lighten-5 flow-text center animated infinite tada">ATTENTION</h5>
											<div class="divider"></div>
											<br>
											<p>1. All reservations payment must be settle their payment within <span class="orange-text accent-2">24 hours</span>, hence it will EXPIRE.</p>
											<br>
											<p>2. Once payment has been settled, it <u class="orange-text accent-2"><i>cannot</i></u> be changed anymore</p>
											<br>
											<p>3. <span class="orange-text accent-2">Bank details </span> for the payments thru <span class="orange-text accent-2">	bank deposit</span> are provided <u class="orange-text accent-2"><i>here</i></u></p>
											<br>
											<h5 class="yellow-text text-lighten-5 flow-text center">BANK DETAILS</h5>
											<div class="divider"></div>
											<br>

											<span class="valign-wrapper"><i class="material-icons circle orange accent-3 grey-text text-darken-3" style="margin-right: 2%; padding: 1%;">assignment_ind</i> Account Name: Virginia and Boy</span>
											<br>
											<span class="valign-wrapper"><i class="material-icons circle orange accent-3 grey-text text-darken-3" style="margin-right: 2%; padding: 1%;">payment</i> Account Number: 07261954</span>
											<br>

											<h5 class="yellow-text text-lighten-5 flow-text center">CONTACTS</h5>
											<div class="divider"></div>
											<br>
											<p><i>Have further questions? Reach us thru the ff:</i></p>
											<br>
											<span class="valign-wrapper"><i class="material-icons circle orange accent-3 grey-text text-darken-3" style="margin-right: 2%; padding: 1%;">call</i> 6669591 / 9852943 / 5708584</span>
											<br>
											<span class="valign-wrapper"><i class="material-icons circle orange accent-3 grey-text text-darken-3" style="margin-right: 2%; padding: 1%;">call</i> 0908-740-4449</span>
											<br>
											<span class="valign-wrapper"><i class="material-icons circle orange accent-3 grey-text text-darken-3" style="margin-right: 2%; padding: 1%;">email</i>Virginia&Boy@gmail.com</span>
										</div>
									</div>
								</div>
								<div class="divider"></div>
								<br>
								<?php if ($reservation[0]->reservation_payment_status == 0 && $reservation[0]->reservation_status != 4): ?>
									<button type="submit" class="btn right white-text btnUpdatePayment" data-id="<?=$reservation[0]->reservation_key?>">SUBMIT PAYMENT</button>
								<?php endif;?>
								<br><br>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<?php else: ?>
			<div class="container" style="padding-top: 5%;">
				<center>
					<img src="<?=base_url()?>assets/images/error-404.svg"  style="width: 20%;" alt="">
					<h1 class="center"> NO RESERVATION FOUND</h1>
					<a href="<?=base_url()?>" class="waves-effect waves-light btn">RETURN HOME</a>
				</center>
			</div>

		<?php endif?>
	</div>