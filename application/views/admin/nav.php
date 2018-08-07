<nav class="blue darken-3">
	<div class="nav-wrapper">
		<a href="<?=base_url()?>Admin" class="brand-logo tooltipped" data-position="right" data-tooltip="Hello, Admin!"> 
			<i class="material-icons right ">supervised_user_circle</i>
		</a>
		<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
		<ul class="right hide-on-med-and-down">
			<li><a href="<?=base_url()?>Admin/logout">Log out <i class="material-icons left">arrow_back</i></a></li> 
		</ul>
	</div>
</nav>


<ul class="sidenav" id="mobile-demo">
	<li><a href="<?=base_url()?>Admin/logout">Logout</a></li> 
</ul>