	<?php 
	$reservation = $this->Crud->fetch('reservation',array('reservation_key'=>$transactionID)); 
	if ($reservation) {
		$guest = $this->Crud->fetch('guest',array('guest_id'=>$reservation[0]->guest_id));
		$guest = $guest[0];
		$fullname = $guest->guest_firstname." ".$guest->guest_lastname;
	}
	?>
	<?php if ($reservation): ?>
		<?php $this->load->view('includes/materialize/sidenav', compact('fullname','guest','reservation')); ?>
		

		<div class="row" id="content">


			<div class="row"> 
				<div class="col s1"></div> 
				<div class="col s10"> 
					<div class="row">
						<blockquote class="color-o-ac3"> 
							<h4 class="black-text" style="font-weight: 300">
								RESERVATION <?= $reservation[0]->reservation_status == 1 ? "- <span class='green-text'>APPROVED</span>" : "";  ?>
								<?php if ($reservation[0]->reservation_status != 1): ?>
									<a href="#!" class="btn right red btnDeleteReservation" data-id="<?=$reservation[0]->reservation_key?>"><i class="material-icons right">clear</i>cancel reservation</a>
								<?php endif ?>
							</h4>

						</blockquote> 
					</div>

					<div class="row"> 
						<h5 class="black-text" style="font-weight: 300">TRANSACTION ID - <span style="font-weight: 500;" class="orange-text accent-3"><?=$reservation[0]->reservation_key?></span> </h5>
					</div>

					<div class="row"> 
						<div class="col s12 m5">
							<div class="card ">
								<div class="card-image">
									<img style="filter: blur(1px);" src="<?=base_url()?>assets/images/IMG_6334.jpg">
									<span class="card-title">Reservation Details</span>
									<a class="btn-floating halfway-fab waves-effect waves-light red" id="btnShowReservation"><i class="material-icons">play_arrow</i></a>
								</div>
								<div class="card-content grey lighten-4"> 
									<div class="row">	

										<div class="collection">
											<a href="#!" class="collection-item grey lighten-4 black-text">
												<?php switch ($reservation[0]->reservation_status) {
													case 1: 
													echo '<span class="new badge green" data-badge-caption="">APPROVED</span>';
													break;

													case 2: 
													echo '<span class="new badge orange accent-3" data-badge-caption="">PENDING</span>';
													break;

													case 3: 
													echo '<span class="new badge red" data-badge-caption="">DENIED</span>';
													break;

													case 4: 
													echo '<span class="new badge red" data-badge-caption="">EXPIRED</span>';
													break;

												} ?>
												Reservation Status	
											</a>
											<a href="#!" class="collection-item grey lighten-4 black-text">
												<span class="new badge <?= $reservation[0]->reservation_payment_status == 0 ? "orange accent-3" : "green"?>" data-badge-caption=""><?= $reservation[0]->reservation_payment_status == 0 ? "NOT YET SETTLED" : "SETTLED"?></span>
												Payment Status:
											</a><a href="#!" class="collection-item grey lighten-4 black-text">
												<span class="new badge blue" data-badge-caption=""><?=date('M d, Y - h:i A', $reservation[0]->reservation_reserved_at)?></span>
												Reserved at:
											</a>
											<?php if ($reservation[0]->reservation_payment_status == 0): ?>
												<a href="#!" class="collection-item grey lighten-4 black-text">
													<span class="new badge red accent-3" data-badge-caption=""><?=date('M d, Y - h:i A', strtotime('+1 day',$reservation[0]->reservation_reserved_at))?></span>
													Will expire at:
												</a> 
											<?php endif ?>
										</div>

									</div>
									<?php if ($reservation[0]->reservation_payment_status == 0): ?>
										<div class="row">	
											<a href="<?=base_url()?>Payments/index/<?=$reservation[0]->reservation_key?>" class="btn orange accent-3 black-text right waves-effect waves-light" id="btnProceedPayment"><i class="material-icons right">open_in_new</i>Proceed to payment</a>
										</div>
									<?php endif ?>
								</div> 
							</div>
						</div>

						<div class="col s12 m7"> 
							<!-- RESERVATION DETAILS -->
							<?php 
							$stay_type = $reservation[0]->reservation_day_type == 1 ? "Day Stay" : "Night Stay";
							$time_in = $reservation[0]->reservation_day_type == 1 ? "8:00 AM": "6:00 PM";
							$time_out = $reservation[0]->reservation_day_type == 1 ? "5:00 PM": "5:00 AM";
							?>
							<div class="card orange accent-3" id="reservationDetails"  style="display: none">
								<div class="card-content white-text">

									<!--=============================================
									=            VIEWING RESERVATION DIV            =
									==============================================-->


									<div class="row"> 
										<span class="card-title black-text center">
											<!-- style="display: none;" -->
											<?php if ($reservation[0]->reservation_payment_status == 0): ?>
												<i class="material-icons right circle white hoverable btnEditReservation" style="padding: 0.9% 1.5%; cursor: pointer;">mode_edit</i>
											<?php endif ?>
											Reservation Details
										</span>
										<div class="divider black"></div> 
										<br>

										<div class="row">
											<div class="input-field col s6">
												<i class="material-icons prefix black-text">event_available</i>

												<input id="icon_prefix" disabled value="<?=date('M d, Y', $reservation[0]->reservation_in)?> - <?=$time_in?>" type="text" class="validate">
												<label for="icon_prefix">Check In</label>
											</div>

											<div class="input-field col s6">
												<i class="material-icons prefix black-text">event_busy</i>
												<input id="icon_prefix" disabled value="<?=date('M d, Y', $reservation[0]->reservation_out)?> - <?=$time_out?>" type="text" class="validate">
												<label for="icon_prefix">Check Out</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s12">
												<i class="material-icons prefix black-text">brightness_4</i>
												<input id="icon_prefix" disabled value="<?=$stay_type?>" type="text" class="validate">
												<label for="icon_prefix">Reservation Type</label>
											</div>
										</div>
										<div class="row">
											<div class="input-field col s6">
												<i class="material-icons prefix black-text">face</i>
												<input id="icon_prefix" disabled value="<?=$reservation[0]->reservation_adult?> Adult/s" type="text" class="validate">
												<label for="icon_prefix">Adult Count</label>
											</div>

											<div class="input-field col s6">
												<i class="material-icons prefix black-text">child_care</i>
												<input id="icon_prefix" disabled value="<?=$reservation[0]->reservation_child?> Child/ren" type="text" class="validate">
												<label for="icon_prefix">Child Count</label>
											</div>
										</div>
										<?php foreach ($reservation as $key => $value): ?>
											<?php 
											$room_type = $this->Crud->fetch('room_type',array("room_type_id"=>$value->room_type_id));
											$room_type = $room_type[0];
											?>
											<div class="row">
												<div class="input-field col s6">
													<i class="material-icons prefix black-text">hotel</i>
													<input id="icon_prefix" disabled value="<?=$room_type->room_type_name?>" type="text" class="validate">
													<label for="icon_prefix">Room Type</label>
												</div>

												<div class="input-field col s6">
													<i class="material-icons prefix black-text">border_clear</i>
													<input id="icon_prefix" disabled value="<?=$value->reservation_roomCount?> Bedroom" type="text" class="validate">
													<label for="icon_prefix">Room Count</label>
												</div>
											</div>
										<?php endforeach ?> 
									</div>
									
									<!--====  End of VIEWING RESERVATION DIV  ====-->
								</div> 
							</div> 
							<div class="card lime lighten-5" id="resEditingDiv"   style="display: none">
								<div class="card-content">
									<div class="row">
										<span class="card-title black-text center"> 
											<i class="material-icons right circle red white-text hoverable btnCancelEditReservation" style="padding: 0.9% 1.5%; cursor: pointer;">arrow_back</i>
											Edit Reservation
										</span>
										<div class="divider black"></div> 
										<br>
										<blockquote>
											<p class="flow-text card-title">NOTE</p> 
											<span>Reservation price may change due to room quantity changes, excess pax, and room type changes. </span>
										</blockquote>
										<div class="row">
											<div class="input-field col s6">
												<i class="material-icons prefix black-text">face</i>
												<input id="adultCount" data-def="<?=$reservation[0]->reservation_adult?>" value="<?=$reservation[0]->reservation_adult?>" min="1" max="100" type="number" class="validate">
												<label for="adultCount">Adult Count</label>
											</div>

											<div class="input-field col s6">
												<i class="material-icons prefix black-text">child_care</i>
												<input id="childCount" data-def="<?=$reservation[0]->reservation_child?>" value="<?=$reservation[0]->reservation_child?>" min="0" max="100" type="number" class="validate">
												<label for="childCount">Child Count</label>
											</div>
										</div>
										<?php 
										$room_type = $this->Crud->fetch('room_type');
										// Compute length of stay
										$datetime1 = new DateTime(date('Y-m-d',$reservation[0]->reservation_in)); 
										$datetime2 = new DateTime(date('Y-m-d',$reservation[0]->reservation_out));
										$difference = $datetime1->diff($datetime2);
										$entranceFee = ($difference->d+1) < 2 ? "true" : "false";
										?> 
										<?php foreach ($room_type as $key => $value): ?>
											<?php  											 
											$room_max =  $this->Crud->countResult('room',array("room_type_id"=>$value->room_type_id,"room_status"=>3)); 
											$room_count = 0;
											if ($reservation[$key]->reservation_roomCount) {
												$room_count = $reservation[$key]->reservation_roomCount;
											}else{
												$room_count = 0;
											}
											?>
											<div class="row valign-wrapper">
												<div class="input-field col s1">
													<p>
														<label>
															<input type="checkbox" name="chkRoom" id="chkRoom_<?=$key?>" <?=$room_count != 0 ? "checked":""?> /> 
															<span></span>
														</label>
													</p>
												</div>

												<div class="input-field col s6">
													<i class="material-icons prefix black-text">hotel</i>
													<input id="icon_prefix" disabled value="<?=$value->room_type_name?>" type="text" class="validate">
													<label for="icon_prefix">Room Type</label>
												</div>
												<div class="input-field col s5">
													<i class="material-icons prefix black-text">border_clear</i>
													<input id="Room_<?=$key?>" <?=$room_count != 0 ? "":"disabled"?> data-pax="<?=$value->room_type_pax?>" data-def="<?=$room_count?>" value="<?=$room_count?>" min="1" max="<?=$room_max?>" type="number" class="validate">
													<label for="Room_<?=$key?>"">Room Count</label>
												</div>

											</div>
										<?php endforeach ?> 
										<a class="waves-effect waves-light blue darken-3 btn right btnConfirmReservation"  data-days="<?=($difference->d+1)?>" data-staytype = "$reservation[0]->reservation_day_type" data-entrance ="<?=$entranceFee?>" data-id="<?=$reservation[0]->reservation_key?>"><i class="material-icons right">cloud_upload</i>UPDATE RESERVATION</a>

									</div>
								</div>
							</div>
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

			<?php endif ?>
		</div>
