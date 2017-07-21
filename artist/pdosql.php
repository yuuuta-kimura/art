<?php

function my_execute( $conn, $sql, $param = array() ) {
	//-------------------
	//クエリのセット
	//-------------------
	$stmt = $conn->prepare( $sql );
	//-------------------
	//クエリの実行
	//-------------------
	$stmt->execute();
 
	return $stmt;
}

	
?>