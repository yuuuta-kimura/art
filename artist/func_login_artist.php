<?php

//////////////////////////////////////
// artist/func_login_artist.php
//////////////////////////////////////


function artist_login($mail, $randpass,$db){

require('../qwertyu.php');

	$hit=0;

	if($randpass==$superpass){
	
		//$sql = sprintf('SELECT artist_id, kanji_sei FROM TM_ARTIST WHERE mailaddress="%s"',
		//$mail
		//);

		$sql ='SELECT artist_id, kanji_sei FROM TM_ARTIST WHERE mailaddress=?';
		
		$stmt = $db->prepare( $sql );
		$stmt->bindParam(1, $mail, PDO::PARAM_STR);	
		
	}else{
		//$sql = sprintf('SELECT artist_id, kanji_sei FROM TM_ARTIST WHERE mailaddress="%s" AND password="%s"',
		//$mail,
		//$randpass
		//);
		$sql = 'SELECT artist_id, kanji_sei FROM TM_ARTIST WHERE mailaddress=? AND password=?';
		$stmt = $db->prepare( $sql );
		$stmt->bindParam(1, $mail, PDO::PARAM_STR);	
		$stmt->bindParam(2, $randpass, PDO::PARAM_STR);	
		
	}

	//$record=$db->query($sql);
	//if($table = $record->fetch(PDO::FETCH_ASSOC)){
	//	$hit=1;
	//}

	// SQL の実行
	$stmt->execute();
	if($table = $stmt->fetch(PDO::FETCH_ASSOC)){
		$hit =1;
	}
	
	
	if($hit==0){
		return array("", "");
	}else{
		return array($table['artist_id'], $table['kanji_sei']);
	}
	
}

?>