<?php
	require_once 'session.php';
	require_once 'common.php';
	$province = trim($_POST['province']);
	$city = trim($_POST['city']);
	if(isset($_POST['county'])){
		$county = trim($_POST['county']);
		set_city($county);
	}
	else {
		$county='';
		set_city($city);
	}
	redirect_to('./../');
?>