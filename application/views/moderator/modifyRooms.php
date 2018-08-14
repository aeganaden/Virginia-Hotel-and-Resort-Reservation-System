<div class="row">
	<?php $this->load->view('moderator/nav'); ?>
</div>

<div class="row">
	<div class="col s2"></div>
	<div class="col s9">
		<blockquote>
			<h4 style="font-weight: 300" class="blue-text text-darken-4">MODIFY ROOMS</h4>
			<button class="btn waves-effect waves-light blue darken-4 right modal-trigger" data-target="mdlAddRooms"><i class="material-icons right">add</i>ADD MORE ROOMS</button>
		</blockquote>
		<div class="col s6">
			<ul class="tabs">
				<li class="tab col s6 grey lighten-4"> 
					<a class=" blue-text text-darken-4 waves-effect active " href="#singleRoomDiv">
						<i class="material-icons right circle blue darken-4 white-text hoverable btnEditSingleRoom modal-trigger" href="#mdlRoomDesc" style="padding: 1%; margin-top: 2%;">edit</i>
						Single Bedroom
					</a>
				</li> 
				<li class="tab col s6 grey lighten-4 ">
					<a class=" blue-text text-darken-4 waves-effect "  href="#doubleRoomDiv">
						<i class="material-icons right circle blue darken-4 white-text hoverable btnEditDoubleRoom modal-trigger" href="#mdlRoomDesc" style="padding: 1%; margin-top: 2%;">edit</i> 	
						Double Bedroom
					</a>
				</li>

			</ul> 
		</div>
		<div id="singleRoomDiv" class=" col s12">
			<?php $singleRooms = $this->Crud->fetch('room',array('room_type_id'=>1)) ?>
			<table class="datatable">
				<thead>
					<tr>
						<th>Room Name</th>
						<th>Room Status</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($singleRooms as $key => $value): ?>
						<?php 
						$status = "";
						$statusColor = ""; 
						$isCheked = "";
						switch ($value->room_status) {
							case 1:
							$status =  "RESEVED - ".$value->reservation_key;
							$statusColor = "blue-text"; 
							break;
							case 2:
							$status =  "CLEANING";
							$statusColor = "orange-text text-accent-3"; 
							break;
							case 3:
							$status =  "VACANT";
							$statusColor = "green-text"; 
							$isCheked = "checked";
							break; 
						} 
						?>
						<tr>
							<td><?=$value->room_name?></td> 
							<td><b class="<?=$statusColor?> roomstat<?=$value->room_id?>"><?=$status?></b></td> 
							<td>
								<?php if ($value->room_status != 1): ?>
									<div class="switch">
										<label>
											CLEANING
											<input type="checkbox" data-id="<?=$value->room_id?>" class="chkModifyRoomStatus" <?=$isCheked?>>
											<span class="lever"></span>
											VACANT
										</label>
									</div>
								<?php endif ?>
							</td>
						</tr> 
					<?php endforeach ?> 
				</tbody>
			</table> 
		</div>
		<div id="doubleRoomDiv" class=" col s12"> 
			<?php $doubleRooms = $this->Crud->fetch('room',array('room_type_id'=>2)) ?>
			<table class="datatable">
				<thead>
					<tr>
						<th>Room Name</th>
						<th>Room Status</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($doubleRooms as $key => $value): ?>
						<?php 
						$status = "";
						$statusColor = ""; 
						$isCheked = "";
						switch ($value->room_status) {
							case 1:
							$status =  "RESEVED - ".$value->reservation_key;
							$statusColor = "blue-text"; 
							break;
							case 2:
							$status =  "CLEANING";
							$statusColor = "orange-text text-accent-3"; 
							break;
							case 3:
							$status =  "VACANT";
							$statusColor = "green-text"; 
							$isCheked = "checked";
							break; 
						} 
						?>
						<tr>
							<td><?=$value->room_name?></td> 
							<td><b class="<?=$statusColor?> roomstat<?=$value->room_id?>"><?=$status?></b></td> 
							<td>
								<?php if ($value->room_status != 1): ?>
									<div class="switch">
										<label>
											CLEANING
											<input type="checkbox" data-id="<?=$value->room_id?>" class="chkModifyRoomStatus" <?=$isCheked?>>
											<span class="lever"></span>
											VACANT
										</label>
									</div>
								<?php endif ?>
							</td>
						</tr> 
					<?php endforeach ?> 
				</tbody>
			</table> 
		</div>
	</div>
	
</div>

<div id="mdlAddRooms" class="modal">
	<div class="modal-content">
		<blockquote>
			<h4 style="font-weight: 300">ADD ROOMS</h4>
		</blockquote>
		<div class="row">  
			<?php  $room_type = $this->Crud->fetch('room_type');  ?>
			<?php foreach ($room_type as $key => $value): ?>
				<div class="row">
					<div class="input-field col s1">
						<p>
							<label>
								<input type="checkbox" name="chkAddRoom" id="chkAddRoom_<?=$key?>" checked/> 
								<span></span>
							</label>
						</p>
					</div>
					<div class="input-field col s8">
						<i class="material-icons prefix">hotel</i>
						<input id="roomType_<?=$key?>" disabled value="<?=$value->room_type_name?>" type="text" class=" validate">
						<label for="roomType_<?=$key?>">Room Type</label>
					</div>


					<div class="input-field col s3">
						<i class="material-icons prefix">border_clear</i>
						<input id="addRoom_<?=$key?>" value="1" min="0" type="number" class=" validate">
						<label for="addRoom_<?=$key?>">Room Count</label>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-close waves-effect waves-light btn red left">cancel <i class="material-icons right">close</i></a>
		<a href="#!" class="waves-effect waves-light btn green btnSubmitRooms">ADD ROOMS <i class="material-icons right">add</i></a>
	</div>
</div>

<div id="mdlRoomDesc" class="modal">
	<div class="modal-content">
		<blockquote>
			<h4 style="font-weight: 300" class="roomDescTitle">ADD ROOMS</h4>
		</blockquote>


		<div class="row">
			<form class="col s12">
				<div class="row">
					<div class="input-field col s12">
						<textarea id="roomDescription" class="materialize-textarea"></textarea>
						<label for="roomDescription">Room Description</label>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class=" waves-effect waves-light btn blue darken-4 btnUpdateDesc" data-id="0">UPDATE</a>
		<a href="#!" class="modal-close waves-effect left waves-light btn red">CANCEL <i class="material-icons right">close</i></a>
	</div>
</div>
