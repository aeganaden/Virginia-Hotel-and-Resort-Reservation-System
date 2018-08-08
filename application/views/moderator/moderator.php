<div class="row">
	<?php $this->load->view('moderator/nav'); ?>
</div>

<div class="row">
	<div class="col s2"></div>
	<div class="col s9"> 
		<blockquote>
			<h4 style="font-weight: 300">RESERVATIONS</h4>
		</blockquote>
		<div class="row">
			<div class="col s6">
				<ul class="tabs">
					<li class="tab col s6 grey lighten-4 "><a class="active blue-text text-darken-4 waves-effect"  href="#pendingReservations">Pending Reservations</a></li>
					<li class="tab col s6 grey lighten-4 "><a class="blue-text text-darken-4 waves-effect" href="#calendarView">Calendar</a></li> 
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
					<div class="row" style="padding-top: 5%;">
						<div id='calendar'></div>
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
					<img class="materialboxed" id="imgContainer" src="" alt="">
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
				<!-- CHECK IN & CHECK OUT DATE -->
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">event</i> 
						<input disabled value="" id="checkin" placeholder="Some Data" type="text" class="validate">
						<label for="checkin"><span class="">Check In</span></label>
					</div>
					<div class="input-field col s6">
						<i class="material-icons prefix">event</i>
						<input disabled value="" id="checkout" placeholder="Some Data" type="text" class="validate">
						<label for="checkout"><span class="">Check out</span></label>
					</div>
				</div>

				<!-- LENGTH OF STAY AND STAY TYPE -->
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">hourglass_empty</i>
						<input disabled value=" Day/s" id="lengthStay" placeholder="Some Data" type="text" class="validate lengthStay">
						<label for="lengthStay"><span class="">Length of Stay</span></label>
					</div>
					<div class="input-field col s6">
						<i class="material-icons prefix">brightness_4</i>
						<input disabled value="" id="stayType" placeholder="Some Data" type="text" class="validate">
						<label for="stayType"><span class="">Stay Type</span></label>
					</div>
				</div>

				<!-- GUEST COUNT -->
				<div class="row">
					<div class="input-field col s6">
						<i class="material-icons prefix">face</i>
						<input disabled value=" Adult/s" placeholder="Some Data" id="adultCount" type="text" class="validate adultCount">
						<label for="adultCount"><span class="">Adult Count</span></label>
					</div>
					<div class="input-field col s6">
						<i class="material-icons prefix">child_care</i>
						<input disabled value=" Child/ren" placeholder="Some Data" id="childCount" type="text" class="validate childCount">
						<label for="childCount"><span class="">Child Count</span></label>
					</div>
				</div>

				<!-- ROOMS -->
				<div class="row" id="roomType1" style="display: none;">
					<div class="input-field col s6">
						<i class="material-icons prefix">hotel</i>
						<input id="roomType1_lbl" disabled placeholder="Some Data" value="" type="text" class="  validate">
						<label for="roomType1_lbl" class="">Room Type</label>
					</div>

					<div class="input-field col s6">
						<i class="material-icons prefix">border_clear</i>
						<input id="roomType1_count" disabled placeholder="Some Data" value=" Bedroom" type="text" class="  validate">
						<label for="roomType1_count" class="">Room Count</label>
					</div> 
				</div>

				<div class="row" id="roomType2" style="display: none;">
					<div class="input-field col s6">
						<i class="material-icons prefix">hotel</i>
						<input id="roomType2_lbl" disabled placeholder="Some Data" value="" type="text" class="  validate">
						<label for="roomType2_lbl" class="">Room Type</label>
					</div>

					<div class="input-field col s6">
						<i class="material-icons prefix">border_clear</i>
						<input id="roomType2_count" disabled placeholder="Some Data" value=" Bedroom" type="text" class="  validate">
						<label for="roomType2_count" class="">Room Count</label>
					</div> 
				</div>

			</div>
			<div class="modal-footer grey lighten-5">
				<a href="#!" class="modal-close waves-effect waves-green btn">CLOSE</a>
			</div>
		</div>
