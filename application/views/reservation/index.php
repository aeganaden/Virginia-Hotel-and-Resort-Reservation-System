<?php $this->load->view('includes/socialmedia'); ?>
<?php $this->load->view('includes/nav'); ?>


<div class="container"style="padding:5% 0 5% 0">
	<div class="row" >
		<div class=" col-lg-12 col-sm-12 col-xs-12 stepLine text-center">

			<div class="col-md-3 stepActive" id="divStep1">
				<h4 class="text-warning ">1<span class="StepActives"> Select Rooms</span></h4>
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
					<button class="exitButton pull-right btn-control btn btn-danger text-light color-red">Cancel</button>
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

										$roomCount = $this->Crud->countResult('rooms', array('room_status'=>3,'room_type_id'=>$value->room_type_id));  
										?>
										<h6 class="text-muted">Available: <span class="text-dark"><?=$roomCount?></span></h6>

										<div class="container-fluid row"> 
											<h6 class="text-muted">Quantity</h6> 
											<div class="col-md-6 col-xs-12">

												<select type="number" class="qty form-control roomQty" data-id="<?=$value->room_type_id?>" data-price="<?=$value->room_type_price?>">
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
									<div class="row" id="viewItemsDiv">
										<div class="container">
											<div class="container">
												<h6 class="text-muted">Select a room to start booking</h6>
											</div>
										</div>
									</div>
									<div class="col-lg-12 col-sm-12 col-xs-12"align="right">
										<!--price-->
										<h4 class="text-secondary">P <span id="totalPrice">00.00</span></h4>
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
		<div class="container-checkIn text-darker">
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
				<input type="number" class="form-control" min="0" required>
			</div>
			<div class="col-md-2">
				<label  >Children:</label>
				<input type="number" class="form-control" min="0" required>
			</div>
			<div class="col-md-2"> 
				<center>
					<button type="button" class="btn btn-primary proceed" style="margin-top: 20%;"
					data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Next</button> 
				</center>
			</div>
		</div>
	</div> 
</div>


<!--====  End of SELECT DATES  ====-->

