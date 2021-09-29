<?php
//##### ADMIN ONLY PAGE
session_start();
$_SESSION['title'] = 'Discord';
include('includes/header.php');
?>


<?php
include('includes/navbar-logged.php');

if ($_SESSION['role'] == 'admin') {
	//##### ADMIN ONLY PAGE
} else {
	//else send to welcome page with error message
	$_SESSION['error'] = "You do not have access to that area.";
	header("Location: /welcome.php");
	exit;
}

$db_request = new db_request();
$discordCommands = $db_request->getAllDiscordCommands();

$prefix = '!';

$discordRoles = $db_request->getDiscordRolesByGuildID('510683153195728900');
$discordChannels = $db_request->getDiscordChannelsByGuildID('510683153195728900');
?>

<div class="container">
	<div class="row">
		<div class="col-xl-10 col-lg-10 col-md-12 pt-3 mx-auto">


			<div class="card border border-dark shadow rounded mt-4">
				<h5 class="card-header">Discord</h5>
				<div class="card-body">
					<div class="row border-bottom mb-2">
						<div class="col-auto text-center pe-0">
							Toggle
						</div>
						<div class="col-3 col-lg-2 text-center ps-0">
							Command
						</div>
						<div class="col-auto text-center">
							Command Settings
						</div>
					</div>
					<div class="row">
						<div class="col-auto pe-0">
							<ul class="list-group me-0 pe-0" id="commands">
								<?php

		            foreach((array) $discordCommands as $command) {
									$checked = '';
									if ($command['enabled'] == 1) {$checked = ' checked';}
									echo '<li class="list-group-item border-end-0 rounded-0"><input class="form-check-input me-1" type="checkbox" data-commandID="'.$command['commandID'].'" title="'.$command["commandName"].'" value="'. $command['enabled'] .'"'.$checked.'></li>';
		            }

		            ?>
							</ul>
					  </div>
					  <div class="col-3 col-lg-2 ps-0">
					    <div class="list-group" id="list-tab" role="tablist">

								<?php

		            foreach((array) $discordCommands as $command) {
									echo '<a class="list-group-item list-group-item-action rounded-0" id="list-'.$command["commandName"].'-list" data-bs-toggle="list" href="#list-'.$command["commandName"].'" role="tab" aria-controls="'.$command["commandName"].'">'.$command["commandName"].'</a>';
		            }

		            ?>

					    </div>
					  </div>
					  <div class="col">
					    <div class="tab-content" id="nav-tabContent">

								<?php

								foreach((array) $discordCommands as $command) {
									echo '<div class="tab-pane fade" id="list-'.$command["commandName"].'" role="tabpanel" aria-labelledby="list-'.$command["commandName"].'-list" data-commandID="'.$command['commandID'].'">';
								?>
								<p class="lead text-wrap text-center"><b><?php echo $prefix . $command["commandName"]; ?></b></p>
								<p class="lead text-wrap"><?php echo $command["description"]; ?></p>
								<div class="row">
									<div class="col-md-6 col-sm-10 mb-3 mb-md-1">
										<ul class="list-group roles">
										  <li class="list-group-item list-group-item-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Selected roles are allowed to use this command.">
												Roles Permission
										  </li>

											<?php
											foreach((array) $discordRoles as $role) {
												$db_request_cmd = new db_request();
												$commandPerm = $db_request_cmd->getDiscordPermissionByCommandIDandRoleID($command['commandID'], $role['roleID']);
												$permChecked = '';
												if ($commandPerm) {$permChecked = ' checked';}
											 ?>
											 <li class="list-group-item">
		 								    <input class="form-check-input text-truncate me-1" type="checkbox" value="<?php echo $role['roleID'];?>" aria-label="<?php echo $role['roleName'];?>"<?php echo $permChecked;?>>
		 								    <?php echo $role['roleName'];?>
		 								  </li>
											<?php
											}
											 ?>

										</ul>
									</div>

									<div class="col-md-6 col-sm-10">
										<ul class="list-group channels">
											<li class="list-group-item list-group-item-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Command is allowed to be used in selected Channels">
												Channel Permission
											</li>

											<?php
											foreach((array) $discordChannels as $channel) {
												$db_request_cmd = new db_request();
												$commandPerm = $db_request_cmd->getDiscordPermissionByCommandIDandChannelID($command['commandID'], $channel['channelID']);
												$permChecked = '';
												if ($commandPerm) {$permChecked = ' checked';}
											 ?>
											 <li class="list-group-item">
												<input class="form-check-input me-1" type="checkbox" value="<?php echo $channel['channelID'];?>" aria-label="<?php echo $channel['channelName'];?>"<?php echo $permChecked;?>>
												<?php echo $channel['channelName'];?>
											</li>
											<?php
											}
											 ?>

										</ul>
									</div>
								</div>
								<?php
								echo '</div>';
								}
								?>

					    </div>
					  </div>
					</div>


				</div>
			</div>


		</div> <!-- col -->
	</div> <!-- row -->
</div> <!-- container -->

<script type="text/javascript" src="js/discord.js"></script>
<?php
include('includes/footer.php');
?>
