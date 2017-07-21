<?php

	require('../dbconnect.php');
	require('../pdosql.php');
	//mysql_set_charset('utf8'); 

	$db = dbconnect();

	$mail=htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES);


	$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_ARTIST WHHERE mailaddress=%s',
				$db->quote($mail)
				);
					
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