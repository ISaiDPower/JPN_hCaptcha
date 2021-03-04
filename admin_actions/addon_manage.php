<?php
$selectInstall = mysqli_query($db, "SELECT * FROM BF_hCaptcha WHERE 1") or die('SQL Error: '.mysqli_error($db));
if(mysqli_num_rows($selectInstall) !== 1)
{
	$_SESSION['hCaptcha_INSTALL'] = "YES";
}
else
{
	$_SESSION['hCaptcha_INSTALL'] = "DONE";
}
if($_SESSION['hCaptcha_INSTALL'] == "YES")
{
	if($_POST['btn_install_hCaptcha'] == 1)
	{
		if(strlen($_POST['m_site_key']) > 4)
		{
			$m_site_key = e($_POST['m_site_key']);
		}
		else
		{
			array_push($errors, "Your hCaptcha site key must have minimum 5 characters.");
		}
		if(strlen($_POST['m_secret_key']) > 2)
		{
			$m_secret_key = e($_POST['m_secret_key']);
		}
		else
		{
			array_push($errors, "Your hCaptcha secret key must have minimum 3 characters.");
		}
		$m_register = (isset($_POST['m_register']) && $_POST['m_register'] == 1) ? 1 : 0;
		$m_login = (isset($_POST['m_login']) && $_POST['m_login'] == 1) ? 1 : 0;
		$m_theme = (isset($_POST['m_theme']) && $_POST['m_theme'] == 1) ? 1 : 0;
		if(count($errors) == 0)
		{
			mysqli_query($db, "INSERT INTO `BF_hCaptcha` (`hc_site_key`, `hc_secret_key`, `hc_register`, `hc_login`) VALUES ('$m_site_key', '$m_secret_key', '$m_register', '$m_login')");
			array_push($successes, 'You succesfully installed hCaptcha addon!');
			$_SESSION['hCaptcha_INSTALL'] = "DONE";
		}
	}
	if($_SESSION['hCaptcha_INSTALL'] == "YES")
	{
		?>
		<?php display_messages(); ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow mb-4">
					<div class="card-header py-3">
						<center><h5 class="m-0 font-weight-bold text-primary">hCaptcha Addon Setup</h5></center>
					</div>
					<div class="card-body">
						<form method="post" action="client_area?admin_area=1&addon_use=hCaptcha&install_process=1">
							<p style="color: green;">Please complete the fields with real and valid information. If you encounter problems, check out the <a href="https://github.com/ISaiDPower/BF_JPNhCaptcha" target="_blank">GitHub repository</a>.</p>
							<p>hCaptcha site key: </p>
							<div class="input-group mb-4 border p-2">
								<input type="text" placeholder="Enter your hCaptcha site key" name="m_site_key" aria-describedby="button-addon3" class="form-control border" required="">
							</div>
							<p>hCaptcha secret key: </p>
							<div class="input-group mb-4 border p-2">
								<input type="password" placeholder="Enter your hCaptcha secret key" name="m_secret_key" aria-describedby="button-addon3" class="form-control border" required="">
							</div>
							<p>Require hCaptcha on registration: </p>
							<div class="input-group mb-4 border p-2">
								<select class="form-control" name="m_register" required="">
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								</select>
							</div>
							<p>Require hCaptcha on login: </p>
							<div class="input-group mb-4 border p-2">
								<select class="form-control" name="m_login" required="">
									<option value="1" selected>Yes</option>
									<option value="0">No</option>
								</select>
							</div>
							<button id="button-addon3" type="submit" name="btn_install_hCaptcha" value="1" class="btn btn-warning px-4" style="color: white;"><i class="fa fa-archive mr-2"></i> Install</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php if($_SESSION['hCaptcha_INSTALL'] == "YES")
		{ 
			die(); 
		} 
	}
}
if(isset($_GET['set_site_key']) && $_GET['set_site_key'] == 1)
{
	$set_token = e($_POST['set_site_key']);
	if(strlen($set_token) > 2)
	{
		mysqli_query($db, "UPDATE `BF_hCaptcha` SET `hc_site_key`='$set_token' WHERE 1");
		array_push($successes, 'You successfully set your hCaptcha site key.');
	}
	else
	{
		array_push($errors, 'Your hCaptcha site key must have minimum 3 characters');
	}
}
if(isset($_GET['set_secret_key']) && $_GET['set_secret_key'] == 1)
{
	$set_token = e($_POST['set_secret_key']);
	if(strlen($set_token) > 2)
	{
		mysqli_query($db, "UPDATE `BF_hCaptcha` SET `hc_secret_key`='$set_token' WHERE 1");
		array_push($successes, 'You successfully set your hCaptcha secret key.');
	}
	else
	{
		array_push($errors, 'Your hCaptcha secret key must have minimum 3 characters');
	}
}
if(isset($_GET['set_register']) && $_GET['set_register'] == 1)
{
	$set_register = (isset($_POST['set_register']) && $_POST['set_register'] == 1) ? 1 : 0;
	mysqli_query($db, "UPDATE `BF_hCaptcha` SET `hc_register`='$set_register' WHERE 1");
	array_push($successes, 'You successfully modified if hCaptcha is shown on registrations.');
}
if(isset($_GET['set_login']) && $_GET['set_login'] == 1)
{
	$set_login = (isset($_POST['set_login']) && $_POST['set_login'] == 1) ? 1 : 0;
	mysqli_query($db, "UPDATE `BF_hCaptcha` SET `hc_login`='$set_login' WHERE 1");
	array_push($successes, 'YYou successfully modified if hCaptcha is shown on logins.');
}
$resultsc = mysqli_query($db, "SELECT * FROM `BF_hCaptcha` WHERE 1") or die ("SQL error(c - admin(admin_area-get_hCaptcha-from_list)): " .mysqli_error($db));
if(mysqli_num_rows($resultsc) > 0)
{
	while($pstats = mysqli_fetch_assoc($resultsc))
	{
		$hc_site_key = $pstats['hc_site_key'];
		$hc_secret_key = $pstats['hc_secret_key'];
		$hc_register = $pstats['hc_register'];
		$hc_login = $pstats['hc_login'];
	}
}
else
{
	die('Invalid installation of hCaptcha addon, please reinstall it.');
}
display_messages(); ?>
<script type="text/javascript">
  var onloadCallback = function() {
    hcaptcha.render('captcha', {
      'sitekey' : '<?php echo $rcv_site_key; ?>',
    });
    hcaptcha.reset();
  };
</script>
<div class="row">
	<div class="col-lg-12">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">hCaptcha Addon Config</h6>
			</div>
			<div class="card-body">
				<p style="color: green;">Please complete the fields with real and valid information. If you encounter problems, check out the <a href="https://github.com/ISaiDPower/BF_JPNhCaptcha" target="_blank">GitHub repository</a>.</p>
				<i class="fa fa-cube"></i><b style="font-family: Muli, sans-serif;"> hCaptcha site key:</b><br> <code><pre><?php echo htmlspecialchars($hc_site_key);?></pre></code><br>
				<i class="fa fa-cube"></i><b style="font-family: Muli, sans-serif;"> hCaptcha secret key:</b><br> <a href="javascript:void(0);" onclick="toggleShowKey()" id="secretkey">(Click to retrieve credentials)</a><br>
				<i class="fa fa-cube"></i><b style="font-family: Muli, sans-serif;"> hCaptcha enabled on registrations:</b> <?php echo ($hc_register == 1) ? 'Yes' : 'No'; ?><br>
				<i class="fa fa-cube"></i><b style="font-family: Muli, sans-serif;"> hCaptcha enabled on login:</b> <?php echo ($hc_login == 1) ? 'Yes' : 'No'; ?><br>
				<p>hCaptcha example: </p>
				<div id="captcha"></div>
				<script src="https://hcaptcha.com/1/api.js?onload=onloadCallback&render=explicit" async defer></script>
				</div>
				<script type="text/javascript">
					let toggleShow = 0;
					function toggleShowKey() {
						if(toggleShow == 0) {
							document.getElementById('secretkey').innerHTML = '(Click to retrieve credentials)';
							toggleShow = 1;
						}
						else {
							document.getElementById('secretkey').innerHTML = '<?php echo $hc_secret_key; ?>';
							toggleShow = 0;
						}
					}
				</script>
			</div>
		</div>
	</div>

	<!-- Content Row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Manage hCaptcha</h6>
				</div>
				<div class="card-body">
					<p>Site key: </p>
					<form method="post" action="client_area?admin_area=1&addon_use=hCaptcha&set_site_key=1">
						<input type="text" name="set_site_key" class="form-control" placeholder="Enter your hCaptcha site key" required="">
						<button id="button-addon3" style="margin-top: 5px;" type="submit" name="btn_ptype" value="1" class="btn btn-success px-4"><i class="fa fa-hashtag mr-2"></i> Set site key</button>
					</form><br>
					<p>Secret key: </p>
					<form method="post" action="client_area?admin_area=1&addon_use=hCaptcha&set_secret_key=1">
						<input type="text" name="set_secret_key" class="form-control" placeholder="Enter your hCaptcha secret key" required="">
						<button id="button-addon3" style="margin-top: 5px;" type="submit" name="btn_ptype" value="1" class="btn btn-success px-4"><i class="fa fa-hashtag mr-2"></i> Set secret key</button>
					</form><br>
					<p>hCaptcha enabled on registrations: </p>
					<form method="post" action="client_area?admin_area=1&addon_use=hCaptcha&set_register=1">
						<select class="form-control" name="set_register" required="">
							<option value="1" <?php echo ($hc_register == 1) ?? 'selected'; ?>>Yes</option>
							<option value="0" <?php echo ($hc_register == 0) ?? 'selected'; ?>>No</option>
						</select>
						<button id="button-addon3" style="margin-top: 5px;" type="submit" name="btn_ptype" value="1" class="btn btn-success px-4"><i class="fa fa-hashtag mr-2"></i> Modify register priority</button>
					</form><br>
					<p>hCaptcha enabled on logins: </p>
					<form method="post" action="client_area?admin_area=1&addon_use=hCaptcha&set_login=1">
						<select class="form-control" name="set_login" required="">
							<option value="1" <?php echo ($hc_login == 1) ?? 'selected'; ?>>Yes</option>
							<option value="0" <?php echo ($hc_login == 0) ?? 'selected'; ?>>No</option>
						</select>
						<button id="button-addon3" style="margin-top: 5px;" type="submit" name="btn_ptype" value="1" class="btn btn-success px-4"><i class="fa fa-hashtag mr-2"></i> Modify login priority</button>
					</form><br>
				</div>
			</div>
		</div>
	</div>
