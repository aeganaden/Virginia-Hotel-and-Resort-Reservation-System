<?php 

session_start();
 //$connection = mysqli_connect('localhost','root','','virginia_db');
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="icon" href="images/capture.jpg">
	<link rel="shortcut icon" href="images/capture.jpg">
	<title>Guest Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script> 

	<style>
	.underline{border-bottom:1px solid #777777;margin-bottom:15px;}
	.overline{border-top:1px solid #777777;padding:15px 15px;}
	/*navbar*/
	.navbar-brand{margin:0;width:120px;height:110px;}
	.navbar-brand img{width:100%;}
	.logo-mobile{display:none}
	.logo-pc{display:inherit;}
	.nav-collapse{display:flex;justify-content:center}
	.nav-link{margin-left: 10px;margin-right:10px;font-size:1.125em;}

	/*steps*/
	.Steps{font-size:0.85em;}
	.stepLine{display:inline-flex;}
	/*Container check in check out*/
	.info{display:inline-flex;}
	/*Container room*/
	.qty-box{display:inline-flex;}
	.qty{width:100%;}
	.btn-book{padding:0;}
	.margin{margin-bottom:15px;}

	.form-group:first-child{float:left;width:45%;margin-right:10px}
	.form-group:nth-child(2){float:left;width:37%;margin-right:10px}
	.form-group:nth-child(3){float:left;width:12.9%}
	.form-group:nth-child(4){float:left;width:45%;margin-right:20px}
	.form-group:nth-child(5){float:left;width:50%;}
	.jumbotron{padding:1.5rem 1rem;}

	@media (max-width: 1028px) {
		/*backgrounnd main +others*/

		/*navbar*/
		.navbar-brand{margin:0;width:75px;height:75px;}

		.nav-collapse{display:initial;}
		.nav-link{margin-left:5px;margin-right:5px;font-size:1em;}
		.navbar.navbar-toggler-icon{border-color: white}
		.txt{font-size:3em;}

		/*steps*/

		.stepLine h4{font-size:1em;}	
		.form-group:first-child{width:40%;margin-right:2px;}
		.form-group:nth-child(2){float:left;width:35%;margin-right:2px}
		.form-group:nth-child(3){float:left;width:23%}

	}
	/*Mobile*/
	@media (max-width: 668px) {
		/*backgrounnd main +others*/

		/*navbar*/
		.navbar-brand{margin:0;width:75px;height:75px;}
		.logo-mobile{display:inherit;}
		.logo-pc{display:none}
		.nav-collapse{display:initial;}
		.nav-link{margin-left:5px;margin-right:5px;font-size:1em;}
		.navbar.navbar-toggler-icon{border-color: white}


		/*steps*/
		.stepLine{display:initial;border:0;}
		.stepHide{display:none}
		.stepActive{font-size:1.225em;text-align:center;border-bottom:1px solid #777777;margin-bottom:15px}

		/*confirmation*/
		.btn-submit{width:100%}
		.form-group:first-child{float:left;width:100%}
		.form-group:nth-child(2){float:left;width:100%}
		.form-group:nth-child(3){float:left;width:100%}
		.form-group:nth-child(4){float:left;width:100%}
		.form-group:nth-child(5){float:left;width:100%}

		/*Mobile*/
		@media (max-width: 388px) {

		}

	</style>
</head>
<body class="bg-light">
	
	<div class="d-inline-flex col-xl-12 col-lg-12 col-sm-12 col-xs-12 bg-warning ">
		<h6 class="p-1 margin-bottom"><i class="fab fa-facebook-square fa-lg text-light"></i></h6>
		<h6 class="p-1 margin-bottom"><i class="fab fa-instagram fa-lg text-light"></i></h6>
		<h6 class="p-1 margin-bottom flex-fill"><i class="fab fa-twitter-square fa-lg text-light"></i></h6>
		<h6 class="p-1 margin-bottom text-light"style="margin-bottom: 0">6669591 /  9852943 / 57085848</h6>
	</div>
	<div class="container-fluid bg-primary">
		<nav class="navbar navbar-expand-sm  bg-primary navbar-dark">
			<!-- Brand -->
			<a class="navbar-brand logo-mobile"href="Home.php">
				<img class="img-fluid"src="images/11.gif">
			</a>
			

			<!-- Toggler/collapsibe Button -->
			<button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon "></span>
			</button>

			<!-- Navbar links -->
			<div class="nav-collapse collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item ">
						<a class="nav-link text-light" href="Home.php">Home</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link text-light" href="aboutUs.php">About Us</a>
					</li>
					<li class="nav-item ">
						<a class="nav-link text-light" href="rooms.php">Rooms</a>
					</li>
				</ul>

				<a class="navbar-brand logo-pc"href="Home.php">
					<img class="img-fluid"src="images/11.gif">
				</a>

				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link text-light" href="amenities.php">Amenities</a>
					</li>
					<li class="nav-item">
						<a class="nav-link text-light" href="gallery.php">Gallery</a>
					</li> 
					<li class="nav-item ">
						<a class="nav-link text-light" href="ContactUs.php">Contact Us</a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<div class="container bg-light"style="padding-top:15px">

		<div class="row">
			<div class="col-lg-12">
				<a href="confirmReservation.php"><u>
					< &nbsp; Back
				</u></a>
			</div>
			<br/>
			<div class=" col-lg-12 col-sm-12 col-xs-12 stepLine underline">
				<div class="p-2 stepHide">
					<h4 class="text-muted">1 <span class="Steps"> Select Dates</span></h4>
				</div>
				<div class="p-2 stepHide">
					<h4 class="text-muted ">2 <span class="Steps"> Select Rooms</span></h4>
				</div>
				<div class="p-2 stepHide">
					<h4 class="text-muted">3 <span class="Steps"> Confirm Reservation</span></h4>
				</div>
				<div class="p-2 stepActive">
					<h4 class="text-warning">4 <span class="stepActives"> Guest Details</span></h4>
				</div>
			</div>
		</div>
	</div>		

	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 clearfix">
					<form action="guestDetailsProcess.php" method="POST">
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
								<label for="telNum"class="control-label">Telephone Number <span class="required"></span></label>
								<input type="text" name="telNumber"  maxlength="7" value="" placeholder="e.g. 4567890" class="form-control" id="telephoneNumber">
							</div>
							<div class="form-group">
								<label for="mobNum" class="control-label">Mobile Number <span class="required">*</span></label>
								<input type="text" name="mobileNumber" maxlength="11" value="" placeholder="e.g. 09987654321" class="form-control" id="mobileNumber" required>
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
								<h6 class="text-muted d-flex justify-content-between">Check-In Date: <span class="text-primary"><?php echo date("F d, Y", strtotime($_SESSION['checkIn']));?></span></h6>
								<h6 class="text-muted d-flex justify-content-between">Check-Out Date: <span class="text-primary"><?php echo date("F d, Y", strtotime($_SESSION['checkOut']));?></span></h6>
								<h6 class="text-muted d-flex justify-content-between">No. of Adult/s: <span class="text-primary"><?php echo $_SESSION['numOfAdult'];?></span></h6>
								<h6 class="text-muted d-flex justify-content-between">No. of Children: <span class="text-primary"><?php echo $_SESSION['numOfChildren'];?></span></h6>
								<h6 class="text-muted d-flex justify-content-between">Room Type: <span class="text-primary"><?php echo $_SESSION['roomN'];?></span></h6>
								
								<?php 
								if((empty($_SESSION['qtyDouble']) and empty($_SESSION['roomM']))){}
									else{
										echo "<h6 class='text-muted d-flex justify-content-between'> &nbsp; <span class ='text-primary'>".$_SESSION['roomN']."</span></h6>";
									}
									?>						``	
									<h5 class="text-dark d-flex justify-content-between">TOTAL: <span class="text-primary"><?php echo number_format ($_SESSION['price'], 2)?></span></h5>
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
								<label><input type="checkbox" id="agreement" onclick="check()" name="agreement" value="agree"> I agree to all the terms as set out in the <a href="info.php"target="blank">Terms and Condition</a> for this website, including those as set out under guaranteed reservation.</label>
							</div>
							
						</div>
						<div class=" overline col-lg-12 col-sm-12 col-xs-12"align="right">
							<button type="submit" name="addGuestBtn" class="btn btn-primary"> SUBMIT </button>
							<!--button type="submit"class="btn btn-primary btnSubmit"data-toggle="modal" data-target="#myModal">SUBMIT</button-->			
						</div>								
					</form>

					
				</div>	
			</div>
		</div>
	</div>
	

		
	</body>
	</html>