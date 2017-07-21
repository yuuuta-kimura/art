<?php

	require('dbconnect.php');
	require('../pdosql.php');
	//mysql_set_charset('utf8'); 

	$db = dbconnect();

	$mail=htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES);
	$artistid=htmlspecialchars($_POST['artist_id'], ENT_QUOTES);

	if($artistid==0){

		$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_ARTIST WHERE mailaddress=%s',
					$db->quote($mail)
					);
	}else{
		
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_ARTIST WHERE mailaddress=%s AND artist_id != %d',
					$db->quote($mail),
					$artistid
					);		
	}


	$res = $db->query($sql);
	if ($res->fetchColumn() > 0) {		
		$error = 'duplicate';
	}else{
		$error = 'none';
	}
	
	$db=NULL;

	header("Content-Type: application/json; charset=utf-8");		

	echo json_encode($error);

?>