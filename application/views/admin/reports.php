<div class="row">
	<?php $this->load->view('admin/nav'); ?>
</div>


<div class="row">
	<div class="col s2"></div>
	<div class="col s8"> 
		<blockquote>
			<h3 style="font-weight: 300">REPORTS</h3>
		</blockquote>
		<div class="row">
			<div class="col s6">
				<ul class="tabs">
					<li class="tab col s6 grey lighten-4"><a href="#reservation">RESERVATION REPORT</a></li>
					<li class="tab col s6 grey lighten-4"><a class="active" href="#income">INCOME REPORT</a></li> 
				</ul>
			</div>
			<div id="reservation" class="col s12">

				<?php 
				// @changes - already included
				$reservations = $this->Crud->fetch_distinct('reservation',array('reservation_status !='=>4)); 
				// @emdchanges
				?>
				<table class="datatable">
					<thead>
						<th>Reservation Key</th>
						<th>Check in</th>
						<th>Check out</th>
						<th>Reservation Status</th>
						<th>Reservation Requests</th>
						<th>Guest Details</th>
						
					</thead>
					<tbody>
						<?php foreach ($reservations as $key => $value): ?>
							<?php 
							$status = "";
							$status_color = "";
							switch ($value->reservation_status) {
								case 1: 
								$status = "APPROVED";
								$status_color = "green-text";
								break;
								case 2: 
								$status = "PENDING";
								$status_color = "orange-text text-accent-3";
								break;
								case 3: 
								$status = "DENIED";
								$status_color = "red-text";
								break;
								case 4: 
								$status = "EXPIRED";
								$status_color = "red-text";
								break;
								case 5: 
								$status = "CHECKED OUT";
								$status_color = "blue-text";
								break;

							}
							?>
							<tr>
								<td><?=$value->reservation_key?></td>
								<td>
									<?php if ($value->reservation_status == 1 || $value->reservation_status == 2): ?>
										<div class="row valign-wrapper">
											<div class="col s8">
												<input  type="text" disabled="" value="<?=date('M d, Y',$value->reservation_in)?>" class="datepickerMod inputEditDateIn<?=$key?>">
											</div>
											<div class="col s4">
												<i class="material-icons btnEditDateIn btnEditDateIn<?=$key?>"   data-id="<?=$key?>"  style="cursor: pointer;">edit</i>
												<i class="material-icons red-text btnCloseIn btnCloseIn<?=$key?>" data-id="<?=$key?>"  style="cursor: pointer; visibility: hidden">close</i>
												<i class="material-icons btnSubmitIn btnSubmitIn<?=$key?>" data-out="<?=date('M d, Y',$value->reservation_out)?>"  data-key="<?=$value->reservation_key?>" data-id="<?=$key?>"  style="cursor: pointer; visibility: hidden;">arrow_forward</i>

											</div>
										</div>
										<?php else: ?>
											<?=date('M d, Y',$value->reservation_in)?>
										<?php endif ?>
									</td>
									<td> 
										<?php if ($value->reservation_status == 1 || $value->reservation_status == 2): ?>
											<div class="row valign-wrapper">
												<div class="col s8">
													<input  type="text" disabled="" value="<?=date('M d, Y',$value->reservation_out)?>" class="datepickerMod inputEditDate<?=$key?>">
												</div>
												<div class="col s4">
													<i class="material-icons btnEditDate btnEditDate<?=$key?>"   data-id="<?=$key?>"  style="cursor: pointer;">edit</i>
													<i class="material-icons red-text btnClose btnClose<?=$key?>" data-id="<?=$key?>"  style="cursor: pointer; visibility: hidden">close</i>
													<i class="material-icons btnSubmit btnSubmit<?=$key?>" data-in="<?=date('M d, Y',$value->reservation_in)?>"  data-key="<?=$value->reservation_key?>" data-id="<?=$key?>"  style="cursor: pointer; visibility: hidden;">arrow_forward</i>
												</div>
											</div>
											<?php else: ?>
												<?=date('M d, Y',$value->reservation_out)?>
											<?php endif ?>

											

										</td>
										<td><span class="<?=$status_color?>"><?=$status?></span></td>
										<td><?=$value->reservation_requests?></td>
										<td><button class="btn waves-effect waves-light modal-trigger btnShowGuestDetails" data-target="guestDetails" data-id="<?=$value->guest_id?>"><i class="material-icons right">remove_red_eye</i>view</button></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table></div>
						<div id="income" class="col s12">
							<div class="row">
								<div class="col s9">
									<ul class="tabs">
										<li class="tab col s4 grey lighten-4"><a class="blue-text active" href="#daily">Daily</a></li>
										<li class="tab col s4 grey lighten-4"><a class="blue-text " href="#weekly">Weekly</a></li>
										<li class="tab col s4 grey lighten-4"><a class="blue-text "href="#monthly">Monthly</a></li>
									</ul>
								</div>
								<div id="daily" class="col s12">
									<canvas id="dailyReport" width="400" height="250"></canvas>
								</div>
								<div id="weekly" class="col s12">
									<canvas id="weeklyReport" width="400" height="250"></canvas>
								</div>
								<div id="monthly" class="col s12">
									<canvas id="monthlyReport" width="400" height="250"></canvas>
								</div> 
							</div>

						</div> 
					</div>
				</div>
				<div class="col s2"></div>
			</div>

			<!--  -->

			<div id="guestDetails" class="modal">
				<div class="modal-content">
					<blockquote>
						<h5 style="font-weight: 300">GUEST DETAILS</h5>
					</blockquote>
					<br>
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">account_circle</i>
							<input id="mdlFirstname" disabled="" value="0" type="text" class="validate black-text">
							<label for="mdlFirstname">First Name</label>
						</div>
						<div class="input-field col s6"> 
							<input id="mdlLastname" disabled value="0" type="text" class="validate black-text">
							<label for="mdlLastname">Last Name</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">group</i>
							<input id="mdlGender" disabled value="0" type="text" class="validate black-text">
							<label for="mdlGender">Gender</label>
						</div>
						<div class="input-field col s6"> 
							<i class="material-icons prefix">local_phone</i> 
							<input id="mdlPhone" disabled value="0" type="text" class="validate black-text">
							<label for="mdlPhone">Phone Number</label>
						</div>
					</div>
					<div class="input-field col s12"> 
						<i class="material-icons prefix">location_city</i> 
						<input id="mdlAddress" disabled value="0" type="text" class="validate black-text">
						<label for="mdlAddress">Address</label>
					</div>
					<div class="input-field col s12"> 
						<i class="material-icons prefix">email</i> 
						<input id="mdlEmail" disabled value="0" type="text" class="validate black-text">
						<label for="mdlEmail">Email</label>
					</div>
				</div>
				<div class="modal-footer">
					<a href="#!" class="modal-close waves-effect waves-light btn orange accent-3">CLOSE</a>
				</div>
			</div>