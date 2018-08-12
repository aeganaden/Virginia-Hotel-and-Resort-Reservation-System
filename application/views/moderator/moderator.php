<div class="row">
	<?php $this->load->view('moderator/nav'); ?>
</div>

<div class="row">
	<div class="col s2"></div>
	<div class="col s9"> 
		<blockquote>
			<h4 style="font-weight: 300" class="blue-text text-darken-4">RESERVATIONS</h4>
		</blockquote>
		<div class="row">
			<div class="col s6">
				<ul class="tabs">
					<li class="tab col s6 grey lighten-4 "><a class=" blue-text text-darken-4 waves-effect active" href="#calendarView">Calendar</a></li> 
					<li class="tab col s6 grey lighten-4 "><a class=" blue-text text-darken-4 waves-effect "  href="#pendingReservations">Pending Reservations</a></li>
				</ul>
			</div>

			<div id="pendingReservations" class="col s12 datatables">  
				<?php 
				$reservations = $this->Crud->fetch('reservation', array('reservation_status'=>2, 'reservation_payment_status'=>1)); 
				$previousValue = null;
				?> 
				<table class="reponsive-table datatable">
					<thead>
						<tr>
							<th>Reservation Key</th>
							<th>Reserved at</th>
							<th>Check in Date</th>
							<th>Check out Date</th> 
							<th>Stay Type</th> 
							<th>Bank Slip</th>
							<th>Action</th>
						</tr>
					</thead> 

					<tbody>
						<?php if ($reservations): ?>
							<?php foreach ($reservations as $key => $value): ?>
								<?php if ($value->reservation_key!=$previousValue): ?> 
									<tr>
										<td><?=$value->reservation_key?></td>
										<td><?=date('M d, Y - h:i A', $value->reservation_reserved_at)?></td>
										<td><?=date('M d, Y', $value->reservation_in)?></td>
										<td><?=date('M d, Y', $value->reservation_out)?></td> 
										<td><?=$value->reservation_day_type == 1 ? "Day Stay": "Night Stay"?></td>   
										<td>   
											<a class="waves-effect waves-light btn-flat orange accent-3 modal-trigger btnViewImage" data-src="<?=base_url()?>assets/uploads/payments/<?=$value->reservation_payment_photo?>" href="#mdlViewImg"><i class="material-icons right">visibility</i>VIEW</a>

										</td>   
										<td>
											<button class="btn green waves-effect waves-light btnApproveRes" data-id="<?=$value->reservation_key?>">APPROVE</button>
											<button class="btn red waves-effect waves-light btnDenyRes" data-id="<?=$value->reservation_key?>">DENY</button>
										</td>   
									</tr>
								<?php endif ?>
								<?php  $previousValue = $value->reservation_key; ?>
							<?php endforeach ?>
							<?php else: ?>	
								<tr>
									<td></td> 
									<td></td> 
									<td></td> 
									<td class="center">NO PENDING RESERVATION</td> 
									<td></td> 
									<td></td> 
									<td></td>  
								</tr> 
							<?php endif ?>
						</tbody>
					</table>
				</div>
				<div id="calendarView" class="col s12"> 
					<div class="row" id="divCalendar" style="padding-top: 5%;">
						<div id='calendar'></div>
					</div>
					<div class="row" id="divAddRes" style="display: none;">
						<div class="col s1"></div>
						<div class="col s11">
							<br>
							<blockquote>
								<h5 style="font-weight: 300" class="orange-text text-accent-3">ADD RESERVATION</h5>
							</blockquote>
							<div class="row" id="resGuestDetailsDiv">
								<div class="col s6">
									<ul class="tabs" id="addReservationTab">
										<li class="tab col s6 grey lighten-4"><a class="active orange-text text-accent-3" href="#resDetails">RESERVATION DETAILS</a></li>
										<li class="tab col s6 grey lighten-4"><a  class="orange-text text-accent-3" href="#guestDetails">GUEST DETAILS</a></li>  
									</ul>
								</div>
								<div id="resDetails" class="col s12">
									<!--=========================================
									=            RESERVATION DETAILS            =
									==========================================--> 
									<br> 
									<!-- CHECK IN & CHECK OUT DATE -->
									<div class="row">
										<div class="input-field col s6">
											<i class="material-icons prefix">event</i> 
											<input value="" id="add_checkin" placeholder="Some Data"  type="text" class="datepicker picker1">
											<label for="add_checkin"><span class="">Check In</span></label>
										</div>
										<div class="input-field col s6">
											<i class="material-icons prefix">event</i>
											<input value="" id="add_checkout" placeholder="Some Data"  type="text" class="datepicker picker2">
											<label for="add_checkout"><span class="">Check out</span></label>
										</div>
									</div>

									<!-- LENGTH OF STAY AND STAY TYPE -->
									<div class="row"> 
										<div class="input-field col s12">
											<i class="material-icons prefix">brightness_4</i>
											<select id="add_stayType">
												<option value="" disabled>Choose Stay Type</option>
												<option value="1" selected>Day Stay</option>
												<option value="2">Night Stay</option> 
											</select>
											<label>Stay Type</label> 
										</div>
									</div>

									<!-- GUEST COUNT -->
									<div class="row">
										<div class="input-field col s6">
											<i class="material-icons prefix">face</i>
											<input value="1" id="add_adultCount" min="1" type="number" class="validate">
											<label for="add_adultCount"><span class="">Adult Count</span></label>
										</div>
										<div class="input-field col s6">
											<i class="material-icons prefix">child_care</i>
											<input value="0" placeholder="Some Data" id="add_childCount" min="0" type="number" class="validate">
											<label for="add_childCount"><span class="">Child Count</span></label>
										</div>
									</div>

									<!-- ROOMS -->
									<?php  $room_type = $this->Crud->fetch('room_type');  ?>
									<?php foreach ($room_type as $key => $value): ?>
										<?php $room_max =  $this->Crud->countResult('room',array("room_type_id"=>$value->room_type_id,"room_status"=>3));  ?>
										<div class="row">
											<div class="input-field col s1">
												<p>
													<label>
														<input type="checkbox" name="chkRoom" id="chkRoom_<?=$key?>" checked/> 
														<span></span>
													</label>
												</p>
											</div>
											<div class="input-field col s5">
												<i class="material-icons prefix">hotel</i>
												<input id="roomType_<?=$key?>" disabled data-pax="<?=$value->room_type_pax?>" value="<?=$value->room_type_name?>" type="text" class=" validate">
												<label for="roomType_<?=$key?>">Room Type</label>
											</div>

											<div class="input-field col s3">
												<i class="material-icons prefix">monetization_on</i>
												<input id="icon_prefix" disabled value="P<?=number_format($value->room_type_price)?>" type="text" class="validate">
												<label for="icon_prefix">Room Price</label>
											</div>

											<div class="input-field col s3">
												<i class="material-icons prefix">border_clear</i>
												<input id="Room_<?=$key?>" value="1" min="0" max="<?=$room_max?>" type="number" class=" validate">
												<label for="Room_<?=$key?>">Room Count</label>
											</div>
										</div>
									<?php endforeach ?>

									<button class="btn waves-effect waves-light left red btnReturnCalendar"><i class="material-icons right">cancel</i>CANCEL</button>

									<button class="btn waves-effect waves-light right orange accent-3 btnProceedGuest"><i class="material-icons right">chevron_right</i>Guest Details</button>
									<!--====  End of RESERVATION DETAILS  ====-->
									
								</div>
								<div id="guestDetails" class="col s12">
									<div class="row">
										<div class="input-field col s4">
											<i class="material-icons prefix">account_circle</i>
											<input id="add_firstname" type="text" class="validate">
											<label for="add_firstname">First Name</label>
										</div>
										<div class="input-field col s4">
											<input id="add_lastname" type="tel" class="validate">
											<label for="add_lastname">Last Name</label>
										</div>
										<div class="input-field col s4">
											<i class="material-icons prefix">supervisor_account</i>
											<select id="add_gender">
												<option value="" disabled>Choose your gender</option>
												<option value="male" selected>Male</option>
												<option value="female">Female</option> 
											</select>
											<label>Gender</label>
										</div>
									</div>
									<div class="row">
										<div class="input-field col s4">
											<i class="material-icons prefix">contact_phone</i>
											<input id="add_phone" type="text" class="validate">
											<label for="add_phone">Phone Number</label>
										</div>
										<div class="input-field col s8">
											<i class="material-icons prefix">contact_mail</i>
											<input id="add_email" type="email" class="validate">
											<label for="add_email">Email</label>
										</div>
										
									</div>
									<div class="row">
										<div class="input-field col s12">
											<i class="material-icons prefix">store_mall_directory</i> 
											<input id="add_address" type="text" class="validate">
											<label for="add_address">Address</label>
										</div> 
									</div>
									<div class="row">
										<div class="input-field col s12">
											<i class="material-icons prefix">insert_comment</i>  
											<textarea id="add_request" class="materialize-textarea"></textarea>
											<label for="add_request">Note/Request</label>
										</div>
									</div>

									<button class="btn waves-effect waves-light left grey btnReturnResDes"><i class="material-icons left">chevron_left</i>Reservation Details</button>
									<button class="btn waves-effect waves-light right orange accent-3  btnProceedSubmit"><i class="material-icons right">chevron_right</i>SUMMARY</button>

								</div> 
							</div>

							<!-- SUMMARY DIV -->
							<div class="row" id="summaryDiv" style="display: none;">
								<div class="row">
									<div class="col s4">
										<div class="col s12">
											<div class="card blue darken-2">
												<div class="card-content white-text">
													<span class="card-title">Your stay:</span>
													<p>Type of stay <span class="stayType right  yellow-text text-lighten-2">-</span></p>
													<p>Check-in Date <span class="checkInDate right yellow-text text-lighten-2">-</span></p>
													<p>Check-out Date <span class="checkOutDate right yellow-text text-lighten-2">-</span></p>
													<p>Length of Stay <span class="stayLength right yellow-text text-lighten-2">-</span></p>
												</div> 
											</div>
										</div>
									</div>
									<div class="col s1"></div>
									<div class="col s7">
										<div class="col s12">
											<div class="card blue darken-2">
												<div class="card-content white-text">
													<span class="card-title center">SUMMARY</span>
													<div class="divider white"></div> 
													<br><br>
													<div class="row">
														<div class="col s4"><b>ROOM</b></div>
														<div class="col s2"><b>QTY</b></div>
														<div class="col s2"><b>PRICE</b></div>
														<div class="col s2"><b>DAYS</b></div>
														<div class="col s2"><b>TOTAL</b></div>
														<!-- ROOMS -->
														<div class="roomsDiv"> 
														</div> 
													</div> 
													<?php 
													// FETCH TAX
													$tax = $this->Crud->fetch('settings');
													$tax = $tax[0];
													?>
													<div class="row">
														<p><b>Room Costs</b> <span class="right totalRoomCosts yellow-text">P1000</span></p>
														<p><b>Length of Stay</b> <span class="right stayLength yellow-text">P1000</span></p>
														<p><b>Tax %</b> <span class="right taxPercent yellow-text" data-tax="<?=$tax->settings_tax?>"><b><?=$tax->settings_tax?>%</b></span></p>
														<p><b>Tax Fee</b> <span class="right taxFee yellow-text">P1000</span></p>
														<p><b>Fees</b> <span class="right addFee yellow-text"></span></p>
													</div>
													<div class="row">
														<h5 class="white-text right">TOTAL: <span class="totalCosts yellow-text">P1000</span></h5>
													</div>

												</div>


											</div>
										</div>
									</div>
								</div>
								<button class="btn waves-effect waves-light left grey btnReturnGuestDes"><i class="material-icons left">chevron_left</i>Guest Details</button>
								<button class="btn waves-effect waves-light right orange accent-3 btnSubmitReservation"><i class="material-icons right">check</i>SUBMIT</button>
							</div>
						</div>
					</div>
				</div> 
			</div>
		</div>

		<!-- IMAGE VIEWING MODAL -->
		<div id="mdlViewImg" class="modal modal-fixed-footer blue lighten-5">
			<div class="modal-content">
				<blockquote>
					<h4>BANK SLIP</h4>
				</blockquote>
				<div class="divider black"></div>
				<br>
				<center>
					<img class="materialboxed responsive-img" id="imgContainer" src="" alt="">
				</center>
			</div>
			<div class="modal-footer blue lighten-5">
				<a href="#!" class="modal-close waves-effect waves-green btn">CLOSE</a>
			</div>
		</div>



		<!-- RESERVATION DETAILS VIEWING MODAL -->
		<div id="mdlViewResDetails" class="modal modal-fixed-footer grey lighten-4">
			<div class="modal-content">
				<blockquote>
					<h4 style="font-weight: 300">RESERVATION DETAILS - <span class="green-text titleKey"></span></h4>
				</blockquote>
				<div class="divider black"></div>
				<br> 
				<div class="row">
					<div class="col s6">
						<div class="card blue darken-4">
							<div class="card-content white-text">
								<div class="row">
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons">event</i> | CHECK IN:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="checkin"></span>
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons">event_busy</i> | CHECK OUT:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="checkout"></span> 
									</div>
								</div>	
								<div class="row">
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons">hourglass_empty</i> | STAY LENGTH:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="lengthStay"></span> 
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons">brightness_4</i> | STAY TYPE:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="stayType"></span> 
									</div>
								</div>
								<div class="row">  
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons">face</i> | ADULT/S:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="adultCount"></span> 
									</div>
								</div>
								<div class="row">
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons">child_care</i> | CHILD/REN:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="childCount"></span> 
									</div>
								</div>
								
							</div>
						</div>
					</div> 
					<div class="col s6">
						<div class="card orange accent-3 black-text">
							<div class="card-content">
								<div class="row" id="roomType1" style="display: none"> 
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons prefix">hotel</i> | <span id="roomType1_lbl" ></span>:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="roomType1_count"></span> 
									</div>
								</div>
								<div class="row" id="roomType2" style="display: none"> 
									<div class="col s6">
										<p class="valign-wrapper">
											<i class="material-icons prefix">hotel</i> | <span id="roomType2_lbl" ></span>:
										</p>
									</div>
									<div class="col s6">
										<span class="right" id="roomType2_count"></span> 
									</div>
								</div>
							</div>
						</div>

						<div class="card orange lighten-4">
							<div class="card-content">
								<blockquote>
									<h6 class="black-text miscsTitle">MISCELLANEOUS</h6>
									<div class="row" id="miscsDiv">
										
									</div>
									<h5 class="black-text">TOTAL FEE: <span class="totalFee right"></span></h5>
								</blockquote>
							</div>
						</div>
					</div>
				</div>  
			</div>
			<div class="modal-footer grey lighten-5">
				<a href="#!" class="modal-close waves-effect waves-light btn left red"><i class="material-icons left">close</i>CLOSE</a>
				<a href="#!" class="waves-effect waves-light btn orange accent-3 right btnCheckout"><i class="material-icons right">input</i>CHECKOUT</a>
				<a href="#addBills" class="modal-trigger waves-effect waves-light btnAddBills btn blue right" style="margin-right: 3%;"><i class="material-icons right">add</i>ADD BILLS</a> 
			</div>
		</div>


		<div id="addBills" class="modal">
			<div class="modal-content">
				<blockquote>
					<h4 style="font-weight: 300">ADD BILLS - <span class="green-text titleKey"></span></h4>
				</blockquote>
				<div class="divider black"></div>
				<br> 
				<div class="row"  id="addBillsContent">
					<div class="row">
						<div class="col s4 input-field">
							<input id="miscName" name="miscName[]" placeholder="E.g Umbrella" type="text" class="validate">
							<label for="miscName">Miscellaneous Name</label>
						</div>
						<div class="col s4 input-field">
							<input id="miscPrice" name="miscPrice[]" placeholder="" type="text" class="validate">
							<label for="miscPrice">Price</label>
						</div>
						<div class="col s3 input-field">
							<input id="miscQty" name="miscQty[]" min="1" value="1" max="250" type="number" class="validate">
							<label for="miscQty">Quantity</label>
						</div>
						<div class="col s1"> 
						</div>
					</div>

				</div>
				<button class="btn waves-effect blue waves-light btnAddMore">ADD MORE</button>
			</div>
			<div class="modal-footer">
				<a href="#!" class="waves-effect waves-green btn orange accent-3 btnUpdateBilling" data-key="">ADD BILLS</a>
			</div>
		</div>
