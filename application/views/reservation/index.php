<?php $this->load->view('includes/socialmedia'); ?>
<?php $this->load->view('includes/nav'); ?>


<div class="container"style="padding:5% 0 5% 0">
	<div class="row" >
		<div class=" col-lg-12 col-sm-12 col-xs-12 stepLine text-center">

			<div class="col-md-3 stepActive" id="divStep1">
				<h4 class="text-warning">1<span class="StepActives"> Select Rooms</span></h4>
			</div>
			<div class="col-md-2 stepHide" id="divStep2">
				<h4 class="text-muted">2<span class="Steps"> Select Dates</span></h4>
			</div>
			<div class="col-md-3 stepHide" id="divStep3">
				<h4 class="text-muted ">3 <span class="Steps"> Confirm Reservation</span></h4>
			</div>
			<div class="col-md-2 stepHide" id="divStep4">
				<h4 class="text-muted ">4 <span class="Steps"> Guest Details</span></h4>
			</div>

			<div class="col-md-2">
				<div class="col-md-4"></div>
				<div class="col-md-8 float-right">
					<button class="exitButton pull-right btn-control btn btn-danger text-light" data-step="1">Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<hr>
</div>



<div class="container">
	<div class="alert alert-warning" role="alert" id="alertDiv" style="display: none">
		<i class="fas fa-exclamation-triangle"></i>
		<span style="padding: 0 1% 0"></span>
	</div>
</div>


<!--==================================
=            SELECT ROOMS            =
===================================-->

<div class="row" id="divSelectRooms">
	
	<div class="container contBody"> 
		<div class="col-lg-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="jumbotron col-lg-8 col-sm-8 col-xs-12">
					<h3 class="text-primary" style="font-family:Quicksand,sans-serif">Type of stay</h3>
					<br>
					<div class="custom-control custom-radio custom-control-inline">
						<h5 style="font-family:Quicksand,sans-serif">
							<input id="dayChk" type="radio" checked name="dayType" value="1" class="custom-control-input">
							<label class="custom-control-label" for="dayChk">Day</label>
						</h5>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<h5 style="font-family:Quicksand,sans-serif">
							<input id="nightChk" type="radio" name="dayType" value="2" class="custom-control-input">
							<label class="custom-control-label" for="nightChk">Night</label>
						</h5>
					</div>
					<hr>
					<h3 class="text-primary" style="font-family:Quicksand,sans-serif">Rooms</h3>
					<br>
					<?php foreach ($roomType as $value): ?>
						<div class="row">
							<!--container-image-->
							<div class="col-lg-4 col-sm-4 col-xs-12">
								<img class="img-fluid"src="<?=base_url()?>assets/uploads/room-types/<?=$value->room_type_image?>"/>
							</div>
							<div class="col-lg-8 col-sm-8 col-xs-12">
								<div class="row margin">
									<!--name ng room-->
									<div class="col-lg-8 col-sm-7 col-xs-12">
										<h5 class="text-warning text-title" id="roomName<?=$value->room_type_id?>">
											<?=$value->room_type_name?> 
										</h5>
									</div>
									<!--price-->
									<div class="col-lg-4 col-sm-5 col-xs-12"><h5 class="text-dark text-price">PHP <?=$value->room_type_price?></h5>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12">
										<!--short description-->
										<p class="text-muted text-justify"><?=$value->room_type_description?></p>

										<!--good for: -->
										<h6 class="text-muted">Good for: <span class="text-dark"><?=$value->room_type_pax?> persons</span></h6>

										<!--available of rooms-->
										<!-- fetch available rooms -->
										<?php  

										$roomCount = $this->Crud->countResult('room', array('room_status'=>3,'room_type_id'=>$value->room_type_id));  
										?>
										<h6 class="text-muted">Available: <span class="text-dark"><?=$roomCount?></span></h6>

										<div class="container-fluid row"> 
											<h6 class="text-muted">Quantity</h6> 
											<div class="col-md-6 col-xs-12">

												<select type="number" class="qty form-control roomQty" 
												data-id="<?=$value->room_type_id?>" 
												data-price="<?=$value->room_type_price?>"
												data-pax="<?=$value->room_type_pax?>"
												>
												<?php for ($i=0; $i <= $roomCount; $i++): ?>
													<option><?=$i?></option> 
												<?php endfor; ?>
											</select>
										</div>
									</div> 
								</div>
							</div>
						</div>
					</div>
					<hr>
					<br>
				<?php endforeach ?>


			</div>
			<div class="col-lg-4 col-sm-4 col-xs-12">
				<div class="row">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h4 class="text-secondary underline">Your reservation</h4>
					</div>
					<div class="col-lg-12 col-sm-12 col-xs-12">

						<div class="row">
							<div class="col-md-12"> 
								<div class="row">
									<div class="col-md-6"><h6>Room</h6></div>
									<div class="col-md-3"><h6>Qty</h6></div>
									<div class="col-md-3"><h6>Price</h6></div>
								</div>
								<div class="row viewItemsDiv">
									<div class="container">
										<div class="container">
											<h6 class="text-muted">Select a room to start booking</h6>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-sm-12 col-xs-12"align="right">
									<!--price-->
									<h4 class="text-secondary">P <span class="roomCosts">00.00</span></h4>
								</div>
								<div class="col-lg-12 col-sm-12 col-xs-12"> 
									<button class="btn btn-primary btn-block btnProceed" date-step="1">Proceed</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> 
	</div>
</div>
</div>

<!--====  End of SELECT ROOMS  ====-->




<!--==================================
=            SELECT DATES            =
===================================-->


<div class ="container" id="divSelectDates" style="display: none"> 
	<div class="jumbotron col-xl-12 col-lg-12 col-sm-12 col-xs-12">
		<!-- ROOM PAX INFORMATION -->
		<div class="row">
			<h6 class="p-2 text-muted"><b>NOTE:</b> 
				<ul>
					<li>If you exceed the total PAX, you will be charged <b>P500</b></li>
					<li>For reservation who have length of stay that is less than 2 days. Entrance Fee will be charged:</li>
					<ul>
						<li> <b>Day Time Entrance Fee</b></li>
						<ul>
							<li>Adults - <b>P80</b></li>
							<li>Child below 4ft - <b>P50</b></li>
						</ul>
						<li><b> Night Time Entrance Fee</b></li>
						<ul>
							<li>Adults - <b>P100</b></li>
							<li>Child below 4ft - <b>P70</b></li>
						</ul>
					</ul>
				</ul>
			</h6>
			<div class="d-inline-flex col-lg-12 col-sm-12 col-xs-12 paxInfoDiv">
			</div>
		</div>

		<div class="container-checkIn text-darker">

			<div class="row col-md-12">
				<div class="input-group input-daterange datepicker col-md-6" data-provide="datepicker">
					<div class="col-md-6">
						<label>Check in Date:</label>
						<input type="text" class="form-control startDate"  name="ReserveDate" placeholder="MM-DD-YYYY" required>
					</div>
					<div class="col-md-6">
						<label>Check out Date:</label>
						<input type="text" class="form-control endDate"   name="toReserveDate" placeholder="MM-DD-YYYY" required>
					</div>
					<div class="input-group-addon"></div>
				</div>

				<div class="col-md-2">
					<label >Adult:</label>
					<input id="inputAdult" type="number" class="form-control" onkeydown="return false"  min="0" value="0" required>
				</div>
				<div class="col-md-2">
					<label  >Children:</label>
					<input id="inputChild" type="number" class="form-control" onkeydown="return false"  min="0" value="0" required>
				</div>
				<div class="col-md-2">  
					<br> 
					<button class="btn btn-primary btn-block btnProceed" date-step="2">Proceed</button> 
				</div>
			</div>
		</div>
	</div> 
</div>


<!--====  End of SELECT DATES  ====-->



<!--=========================================
=            CONFIRM RESERVATION            =
==========================================-->
<!-- FETCH SETTINGS -->
<?php 
$settings = $this->Crud->fetch('settings',array("settings_id"=>1));

$tax = $settings ? $settings[0]->settings_tax : 10;
?>

<div class="container" id="divConfirmReservation" style="display: none; margin-bottom: 5%;">
	<div class="col-lg-12 col-sm-12 col-xs-12">
		<div class="row d-flex">

			<div class="mr-auto col-lg-4 col-sm-12 col-xs-12"style="height:100%">
				<div class="row jumbotron jumbo">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h5 class="text-dark underline">Your Stay</h5>
					</div>
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h6 class="text-dark d-flex justify-content-between">
							Type of stay: <span class="text-primary stayType"></span>
						</h6>
						<h6 class="text-dark d-flex justify-content-between">
							Check in: <span class="text-primary checkInText"></span>
						</h6>
						<h6 class="text-dark d-flex justify-content-between">
							Check out: <span class="text-primary checkOutText"></span>
						</h6>
						<h6 class="text-dark d-flex justify-content-between">Days:
							<span class="text-primary totalDays"></span>
						</h6>

					</div>
				</div> 
			</div>

			<div class="col-lg-7 col-sm-12 col-xs-12" style="height:100%">
				<div class="row jumbotron">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h4 class="d-flex justify-content-between text-dark underline">
							Total Room Cost <span class="text-primary roomCosts"></span>
						</h5>
					</div>
					<div class="col-lg-12 col-sm-12 col-xs-12"> 
						<div class="row">
							<div class="col-md-6"><h6>Room</h6></div>
							<div class="col-md-3"><h6>Qty</h6></div>
							<div class="col-md-3"><h6>Price</h6></div>
						</div>
						<div class="row viewItemsDiv"> 
						</div>
						<h6 class="underline"></h6>
					</div>
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h6 class="text-muted d-flex justify-content-between">
							Room Cost: <span class="text-primary roomCosts"></span>
						</h6>
						<h6 class="text-muted d-flex justify-content-between">
							Length of stay: <span class="text-primary totalDays"></span>
						</h6>
						<h6 class="text-muted d-flex justify-content-between">
							Tax %: <span class="text-primary"><span class="taxCosts"><?=$tax?></span>%</span>
						</h6>
						<h6 class="text-muted d-flex justify-content-between">
							Tax Fee: <span class="text-primary"><span class="taxFee"></span></span>
						</h6>
						<h6 class="text-muted d-flex justify-content-between">
							Fees: <span class="text-primary feeCosts"></span>
						</h6>
						<h6 class="text-muted d-flex justify-content-between">
							TOTAL ROOM CHARGE: <span class="text-primary"><b class="totalCharge"></b></span>
						</h6>
					</div>
				</div>
				<div class="col-lg-12 col-sm-12 col-xs-12"align="right"style="padding: 0">
					<button class="btn btn-primary btn-block btnProceed" date-step="3">Proceed</button> 
				</div>
			</div>


		</div>
	</div>
</div>


<!--====  End of CONFIRM RESERVATION  ====-->



<!--===================================
=            GUEST DETAILS            =
====================================-->

<div class="container" id="divGuestDetails" style="display: none; margin-bottom: 5%;">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 clearfix"> 
				<h3>Personal Information</h3>
				<div class="col-lg-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label for="firstName"  class="control-label">First Name <span class="required">*</span></label>
						<input type="text"  name="fName" maxlength="40" value="" class="form-control" id="firstName" placeholder="Firstname" required>
					</div>

					<div class="form-group">
						<label for="lastName"class="control-label">Last Name <span class="required">*</span></label>
						<input type="text" name="lName" maxlength="40" value="" class="form-control" id="lastName" placeholder="Lastname" required>
					</div>
					<div class="form-group">
						<label for="gender" name="gender" class="control-label">Gender <span class="required">*</span></label>
						<select name="gender" class="form-control" id="gender">
							<option value="male" >Male</option>
							<option value="female">Female</option>
						</select>
					</div>
					<div class="form-group">
						<label for="mobNum" class="control-label">Mobile Number <span class="required">*</span></label>
						<input type="number" min="1" name="mobileNumber" maxlength="11" value="" placeholder="e.g. 09987654321" class="form-control" id="mobileNumber" required>
					</div>
					<div class="form-group">
						<label for="address"class="control-label">Address <span class="required"></span></label>
						<input type="text" name="address"  value="" placeholder="Address" class="form-control" id="address">
					</div>
					<div class="form-group">
						<label for="email"class="control-label">Email-Address <span class="required">*</span></label>
						<input type="email" name="email"  value="" placeholder="Email Address" class="form-control" id="emailAddress">
					</div>
					<div class="form-group">
						<label for="lastName"class="control-label">Special Request</label>
						<textarea name="specialRequest" placeholder="Special Requests" class="form-control" rows="5" id="comment"></textarea>
					</div>

				</div>
			</div>

			<div class="col-lg-4 col-sm-4 col-xs-12">
				<div class="row jumbotron">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h5 class="text-dark underline">Reservation Details Summary</h5>
					</div>
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h6 class="text-muted d-flex justify-content-between">Check-In Date: <span class="text-primary checkInText"></span></h6>
						<h6 class="text-muted d-flex justify-content-between">Check-Out Date: <span class="text-primary checkOutText"></span></h6>
						<h6 class="text-muted d-flex justify-content-between">No. of Adult/s: <span class="text-primary adultText"></span></h6>
						<h6 class="text-muted d-flex justify-content-between">No. of Children: <span class="text-primary childText"></span></h6>
						<h6 class="text-muted d-flex justify-content-between">Room Type: <span class="text-primary roomsText"></span></h6>
						<h5 class="text-dark d-flex justify-content-between">Stay Type: <span class="text-primary stayType"></span></h5>
						<h5 class="text-dark d-flex justify-content-between">TOTAL: <span class="text-primary totalCharge"></span></h5>
					</div>
				</div>
				<div class="row jumbotron">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<h5 class="text-dark underline">NOTICE</h5>
					</div>
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<p>
							<em>This is non-refundable!</em>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-12 col-sm-12 col-xs-12">

				<div class="checkbox col-xs-12">
					<label><input type="checkbox" id="agreement" name="agreement"> I agree to all the terms as set out in the <a data-toggle="modal" data-target="#termsModal" class="text-primary">Terms and Condition</a> for this website, including those as set out under guaranteed reservation.</label>
				</div>

			</div>
			<div class=" overline col-lg-12 col-sm-12 col-xs-12"align="right">
				<button class="btn btn-primary btn-block btnProceed" date-step="4">Proceed</button> 
			</div>	 
		</div>	
	</div>
</div>
</div>

<!--====  End of GUEST DETAILS  ====-->


<!--===============================================
=            TERMS AND CONDITION MODAL            =
================================================-->

<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Terms and Condition</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h1 class="text-warning underline text-center">Rules and Regulations</h1>

				<h6 class="text-muted">1. A Fee of P50 will charge for every electronics or Electrical appliance brougth in for personal use (cassette, mini component, ETC.)</h6>
				<h6 class="text-muted">2.Eating and drinking at the pool side is strictly prohibited. </h6>
				<h6 class="text-muted">3.Do not swim while under the influence of drugs & liqour.</h6>
				<h6 class="text-muted">4.Do not bring breakable glass or sharp objects that might cause or injury to guests.</h6>
				<h6 class="text-muted">5.Children should be accompanied by adult at all time.</h6>
				<h6 class="text-muted">6.Wear proper swimming attire. <br/>
					&nbsp;&nbsp; For Males:<br/>
					&nbsp;&nbsp; &nbsp;&nbsp;* Swimming trunk or gartered short.<br/>
					&nbsp;&nbsp; For Females:<br/>
				&nbsp;&nbsp; &nbsp;&nbsp;* Bathing suit or short(colored) and garterized short.</h6>
				<h6 class="text-muted">7. Please notify staff in case of emergency.</h6>
				<h6 class="text-muted">8. Drugs fire arms and deadly weapons are strictly prohibited.</h6>
				<h6 class="text-muted">9. No pets allowed.</h6>
				<h6 class="text-muted">10. Don't leave your valuable things unattended.</h6>
				<h6 class="text-muted">11. Room guest will pay in swimming during their stay.</h6>
				<h6 class="text-muted">12. All sales are absolute no refunds.</h6>
				<h6 class="text-muted">13. Rates are subject to change without prior notice.</h6>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> 
			</div>
		</div>
	</div>
</div>

<!--====  End of TERMS AND CONDITION MODAL  ====-->



