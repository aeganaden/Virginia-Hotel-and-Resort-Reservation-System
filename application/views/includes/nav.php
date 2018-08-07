<nav class="navbar navbar-expand-sm  bg-primary navbar-dark">
	<!-- Brand -->
	<a class="navbar-brand logo-mobile"href="#">
		<img class="img-fluid" src="<?=base_url()?>assets/images/11.gif">
	</a>


	<!-- Toggler/collapsibe Button -->
	<button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
		<span class="navbar-toggler-icon "></span>
	</button>

	<!-- Navbar links -->
	<div class="nav-collapse collapse navbar-collapse" id="collapsibleNavbar">
		<ul class="navbar-nav">
			<li class="nav-item ">
				<a class="nav-link text-light" href="<?=base_url()?>">Home</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link text-light" href="<?=base_url()?>Welcome/viewAboutUs">About Us</a>
			</li>
			<li class="nav-item ">
				<a class="nav-link text-light" href="<?=base_url()?>Welcome/viewRooms">Rooms</a>
			</li>
		</ul>

		<a class="navbar-brand logo-pc"href="#">
			<img class="img-fluid"src="<?=base_url()?>assets/images/11.gif">
		</a>

		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link text-light" href="<?=base_url()?>Welcome/viewAmenities">Amenities</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-light" href="<?=base_url()?>Welcome/viewGallery">Gallery</a>
			</li> 
			<li class="nav-item ">
				<a class="nav-link text-light" href="<?=base_url()?>Welcome/contactUs">Contact Us</a>
			</li>
			<li class="nav-item" style="border-left: 3px solid white;"> 
				<a href="<?=base_url()?>Admin"><i class="material-icons" style="padding-top: 40%; cursor: pointer; padding-left: 50%; color: white">input</i></a>
			</li>
		</ul>
	</div>
</nav>