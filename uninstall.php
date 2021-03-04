<?php
	$addon_db = "BF_hCaptcha";

	if($addon_db != "no_db")
	{
		$queryucu = "DROP TABLE IF EXISTS `$addon_db`";
		mysqli_query($db, $queryucu);
	}
	$queryuc = "DELETE FROM `BF_addons` WHERE `addon_name`='hCaptcha'";
	mysqli_query($db, $queryuc);
	array_push($succeses2, "Thank you for using JPN's hCaptcha addon. Hope you enjoyed.");
	include('content/client_areas/' . $current_client_area . '/admin_actions/BF_addons.php');
	?>