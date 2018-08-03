 <ul id="slide-out" class="sidenav sidenav-fixed blue">
 	<li>
 		<div class="user-view">
 			<div class="background">
 				<img src="<?=base_url()?>assets/images/front.jpg" style="width: 100%; filter: blur(2px); height: auto;">
 			</div>
 			<a href="#"><img class="circle" src="<?=base_url()?>assets/images/11.gif"></a>
 			<a href="#"><span class="white-text name"><?=ucwords($fullname)?></span></a>
 			<a href="#"><span class="white-text email"><?=$guest->guest_email?></span></a>
 		</div>
 	</li>
 	<li>
 		<a href="<?=base_url()?>Reservation/viewReservation/<?=$reservation[0]->reservation_key?>"><i class="material-icons">event</i>Reservations</a>
 	</li>   
 	<li><a href="<?=base_url()?>Payments/index/<?=$reservation[0]->reservation_key?>"><i class="material-icons">credit_card</i>Payments</a></li>   
 	<li><a class="subheader">Actions</a></li>
 	<li><a href="<?=base_url()?>"><i class="material-icons">keyboard_backspace</i>Return</a></li>  
 </ul>
 <a href="#" style="padding: 1%;" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>