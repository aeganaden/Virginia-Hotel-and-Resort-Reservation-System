<div class="row">
	<?php $this->load->view('admin/nav'); ?>
</div>

<div class="row">
	<div class="col s2"></div>
	<div class="col s8"> 
		<blockquote>
			<h3 style="font-weight: 300">List of Moderators </h3>
		</blockquote>
		<button class="btn right waves-effect waves-light modal-trigger" data-target="mdlCreateModer"><i class="material-icons left">person_add</i>add moderator</button>
		<table class="datatable hover">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Created At</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php $moderators = $this->Crud->fetch('moderator'); ?>
				<?php if ($moderators): ?>
					<?php foreach ($moderators as $key => $value): ?>
						<?php 
						$status = $value->moderator_status == 1 ? "ACTIVE" : "INACTIVE";
						$status_color = $value->moderator_status == 1 ? "green-text" : "red-text";
						$status_chk = $value->moderator_status == 1 ? "checked" : "red-text"; 
						?>
						<tr>
							<td><?=$value->moderator_firstname?></td> 
							<td><?=$value->moderator_lastname?></td> 
							<td><?=date('M d, Y - h:i A',$value->moderator_created_at)?></td> 
							<td class="stat<?= $value->moderator_id ?> <?= $status_color ?>"><?= $status ?></td>
							<td>
								<div class="switch">
									<label>
										Deactivated
										<input <?= $status_chk ?> type="checkbox" data-id="<?=$value->moderator_id?>"  class="chk_moder_status">
										<span class="lever" ></span>
										Activated
									</label>
								</div>
							</td> 
						</tr> 
					<?php endforeach ?>
					<?php else: ?>
						<tr>
							<td></td>
							<td></td>
							<td>NO MODERATORS CREATED</td>
							<td></td>
							<td></td>
						</tr> 
					<?php endif ?> 
				</tbody>
			</table>
		</div>
		<div class="col s2"></div>
	</div>


	<!-- Modal Structure -->
	<div id="mdlCreateModer" class="modal modal-fixed-footer blue lighten-5">
		<div class="modal-content">
			<blockquote>
				<h4 style="font-weight: 300;">ADD MODERATOR</h4>
			</blockquote>
			<div class="row">
				<form id="frmAddModerator" method="post">
					<div class="row">
						<div class="input-field col s12 m6">
							<i class="material-icons prefix">account_circle</i>
							<input id="first_name" type="text" class="validate">
							<label for="first_name">First Name</label>
						</div>
						<div class="input-field col s12 m6">
							<input id="last_name" type="text" class="validate">
							<label for="last_name">Last Name</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="material-icons prefix">how_to_reg</i>
							<input id="username" type="text" class="validate">
							<label for="username">Username</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12 m6">
							<i class="material-icons prefix">lock</i>
							<input id="password" type="password" class="validate">
							<label for="password">Password</label>
						</div>
						<div class="input-field col s12 m6">
							<i class="material-icons prefix">lock</i>
							<input id="confirm_password" type="password" class="validate">
							<label for="confirm_password">Confirm Password</label>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="modal-footer blue lighten-5">
			<button class="btn right waves-effect waves-light btnAddModerator"><i class="material-icons left">person_add</i>add moderator</button>
			<a href="#!" class="modal-close waves-effect waves-green btn-flat left red white-text">Cancel</a>
		</div>
	</div>
