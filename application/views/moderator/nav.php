<nav class="orange darken-4">
	<div class="nav-wrapper">
		<a href="<?=base_url()?>Moderator" class="brand-logo tooltipped" data-position="right" data-tooltip="Hello, Moderator <?=$moderData['data'][0]->moderator_firstname?>!"> 
			<i class="material-icons right ">supervised_user_circle</i>
		</a>
		<a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
		<ul class="right hide-on-med-and-down">
			<li><a href="<?=base_url()?>Moderator">Reservations<i class="material-icons left">event_note</i></a></li>  
			<li><a href="<?=base_url()?>Moderator/modifyRooms">Modify Room<i class="material-icons left">meeting_room</i></a></li>  
			<li><a href="<?=base_url()?>Moderator/logout">Log out <i class="material-icons left">arrow_back</i></a></li> 
		</ul>
	</div>
</nav>


<ul class="sidenav" id="mobile-demo">
	<li><a href="<?=base_url()?>Moderator">Reservations<i class="material-icons left">event_note</i></a></li>   
	<li><a href="<?=base_url()?>Moderator">Modify Room<i class="material-icons left">meeting_room</i></a></li>   
	<li><a href="<?=base_url()?>Moderator/logout">Log out <i class="material-icons left">arrow_back</i></a></li> 
</ul>