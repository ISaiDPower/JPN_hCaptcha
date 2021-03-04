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
			?>
			<script type="text/javascript">
			  var onloadCallback = function() {
			    hcaptcha.render('BF_captcha', {
			      'sitekey' : '<?php echo $hc_site_key; ?>',
			    });
			  };
			  hcaptcha.reset();
			</script>
			<div id="BF_captcha"></div>
			<script src="https://hcaptcha.com/1/api.js?onload=onloadCallback&render=explicit" async defer></script>
			<?php
		}
	}
	else
	{
		echo ('<!-- Invalid installation of hCaptcha addon, please reinstall it. -->');
	}
}  ?>