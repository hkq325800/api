<?php
	require_once 'session.php';
	require_once 'common.php';
	$account = trim($_POST['username']);//$_SERVER['DOCUMENT_ROOT']
	//$id=file_get_contents(./../api/personalPro/public/getid?account='.$account);
	$id=file_get_contents('./getId?account='.$account);
	set_user($id,$account);
	//echo current_account().current_userid();
	redirect_to('./../');
?>