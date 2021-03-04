<?php
$addon_result = mysqli_query($db, "SELECT * FROM `BF_addons` WHERE `addon_name`='hCaptcha' LIMIT 1");
if(mysqli_num_rows($addon_result) == 1 && addon_activated('hCaptcha') == 'YES')
{
	if($_GET['admin_area'])
	{
		include('content/client_areas/'.WEBSITE_CLIENT_AREA.'/admin_actions/addon_manage.php');
	}
}
else
{
	$install_db1 = "
	INSERT INTO `BF_addons` (`addon_status`, `addon_name`, `addon_description`) VALUES
	('1', 'hCaptcha', 'Generate revenue when someone completes a captcha on your website.');";
	$install_db2 = "
	CREATE TABLE IF NOT EXISTS `BF_hCaptcha` (
  `hc_site_key` TEXT DEFAULT NULL,
  `hc_secret_key` TEXT DEFAULT NULL,
  `hc_register` int DEFAULT 1,
  `hc_login` int DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	mysqli_query($db, $install_db1)
	or die ("SQL error(hCaptcha - addon(install1)): " .mysqli_error($db));
	mysqli_query($db, $install_db2)
	or die ("SQL error(hCaptcha - addon(install2)): " .mysqli_error($db));
	$_SESSION['hCaptcha_INSTALL'] = "YES";
	include('content/client_areas/'.WEBSITE_CLIENT_AREA.'/admin_actions/addon_manage.php');
}
?>