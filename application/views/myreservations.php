<div class="row ">
	<?php if ($this->Crud->fetch('reservation',array('reservation_key'=>$transactionID))): ?>

		<ul id="slide-out" class="side-nav fixed yellow darken-2">
			<li><div class="user-view">
				<div class="background">
					<img src="<?=base_url()?>assets/images/front.jpg" style="width: 100%; filter: blur(2px); height: auto;">
				</div>
				<a href="#!user"><img class="circle" src="<?=base_url()?>assets/images/11.gif"></a>
				<a href="#!name"><span class="white-text name">John Doe</span></a>
				<a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
			</div></li>
			<li><a href="#!"><i class="material-icons">event</i>Reservations</a></li> 
			<li><div class="divider"></div></li>
			<li><a class="subheader">Actions</a></li>
			<li><a href="<?=base_url()?>"><i class="material-icons">keyboard_backspace</i>Return</a></li> 
		</ul>
		<a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>


		<h1 class="center"><?=$transactionID?></h1>

		<?php else: ?>
			<h1 class="center">palpak</h1>
		<?php endif ?>

	</div>