<?php if(addon_activated("hCaptcha") == "YES") {
	global $db; 
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
		if($hc_login == 1)
		{
			$captcha = (isset($_POST['h-captcha-response'])) ? $_POST['h-captcha-response'] : false;
			if($captcha == false){
				array_push($errors, 'Please submit the captcha.');
			}
			else
			{
				$response = json_decode(file_get_contents("https://hcaptcha.com/siteverify?secret=$hc_secret_key&response=".$captcha), 1);
				if($response['success'] == false)
				{
					array_push($errors, 'The captcha verification failed.');
				}
			}
		}
	}
	else
	{
		echo ('<!-- Invalid installation of hCaptcha addon, please reinstall it. -->');
	}
}  ?>