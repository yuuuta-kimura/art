<?php

//////////////////////////////////////
// user/func_login_user.php
//////////////////////////////////////


function user_login($mail, $randpass,$db){

	$hit=0;

	/*
	$sql = sprintf('SELECT user_id, kanji_sei, kanji_mei FROM TM_USER WHERE mailaddress="%s" AND password="%s"',
	$mail,
	$randpass
	);
	$record=$db->query($sql);
	*/
	
	$sql ='SELECT user_id, kanji_sei, kanji_mei FROM TM_USER WHERE mailaddress=? AND password=?';
	$stmt = $db->prepare( $sql );
	$stmt->bindParam(1, $mail, PDO::PARAM_STR);	
	$stmt->bindParam(2, $randpass, PDO::PARAM_STR);
	$stmt->execute();
	
	//if($table = $record->fetch(PDO::FETCH_ASSOC)){
	if($table = $stmt->fetch(PDO::FETCH_ASSOC)){
		$hit=1;
	}
	
	if($hit==0){
		return array("", "", "");
	}else{
		return array($table['user_id'], $table['kanji_sei'], $table['kanji_mei']);
	}
	
}

function user_login_check($user_id, $randpass,$db){

	$hit=0;

	/*
	$sql = sprintf('SELECT user_id FROM TM_USER WHERE user_id=%d AND password="%s"',
	$user_id,
	$randpass
	);
	$record=$db->query($sql);
	*/
	
	$sql ='SELECT user_id FROM TM_USER WHERE user_id=? AND password=?';
	$stmt = $db->prepare( $sql );
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);	
	$stmt->bindParam(2, $randpass, PDO::PARAM_STR);
	$stmt->execute();
	
	
	//if($table = $record->fetch(PDO::FETCH_ASSOC)){
	if($table = $stmt->fetch(PDO::FETCH_ASSOC)){
		$hit=1;
	}
	
	return $hit;
	
}

function get_user_name($user_id, $randpass,$db){

	$hit=0;

	/*
	$sql = sprintf('SELECT * FROM TM_USER WHERE user_id=%d AND password="%s"',
	$user_id,
	$randpass
	);
	$record=$db->query($sql);
	*/
	
	$sql ='SELECT * FROM TM_USER WHERE user_id=? AND password=?';
	$stmt = $db->prepare( $sql );
	$stmt->bindParam(1, $user_id, PDO::PARAM_INT);	
	$stmt->bindParam(2, $randpass, PDO::PARAM_STR);
	$stmt->execute();
	
	
	//if($table = $record->fetch(PDO::FETCH_ASSOC)){
	if($table = $stmt->fetch(PDO::FETCH_ASSOC)){
		$hit=1;
	}

	if($hit==0){
		return array("", "", "", "");
	}else{
		return array($table['kanji_sei'], $table['kanji_mei'], $table['kana_sei'], $table['kana_mei']);
	}
	
}


?>