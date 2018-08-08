<form action="<?=base_url()?>Moderator/checkCredentials" method="post">
	<div class="row valign-wrapper">
		<div class="col s4"></div>
		<div class="col s4"> 
			<div class="card teal lighten-5" style="margin-top: 40%;">
				<div class="card-content grey-text text-darken-4">
					<span class="card-title center">MODERATOR LOGIN</span>
					<div class="divider black">	</div>
					<div class="row">
						<div class="col s1"></div>
						<div class="col s10">
							<?php if ($this->session->flashdata('error')): ?>
								<div class="row">
									<blockquote>
										<span class="red-text"><?=$this->session->flashdata('error');?></span>
									</blockquote>
								</div>
							<?php endif ?>
							<div class="input-field"> 
								<i class="material-icons prefix">account_circle</i>
								<input id="username" name="username" type="text" class="validate">
								<label for="username">Username</label>
							</div>
							<div class="input-field">
								<i class="material-icons prefix">lock</i>
								<input id="password" name="password" type="password" class="validate">
								<label for="password">Password</label>
							</div>
							<center>
								<i>Are you an admin? <a href="<?=base_url()?>Admin">Login here</a></i>
							</center>
						</div>
						<div class="col s1"></div>
					</div>

					<div class="row">
						<button class="waves-effect waves-light btn right blue darken-4" type="submit"><i class="material-icons right">input</i>LOGIN</button>
					</div>		
				</div> 
			</div> 
		</div>
		<div class="col s4"></div>
	</div> 
</form>