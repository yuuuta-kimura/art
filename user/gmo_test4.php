<?php

require('func_gmo.php');


////////////////////////////////////
// 決済変更

//インプット
$AccessID="3f57e6ffb91a0c2b313fdb43635a7016";
$AccessPass="655355c35cd2aae5c2a6baee8fccc75a";
$Method="VOID"; //VOID:取消 RETURN:返品 RETURNX:月跨り返品

//リターン変数
$Forward="";
$Approve="";
$TranID="";
$TranDate="";


list ($Forward, $Approve, $TranID, $TranDate) = gmo_void($AccessID,$AccessPass,$Method);

if(empty($Forward)){
	echo '決済変更エラー：'.$Approve;
}else{
	echo '決済変更成功';
}


?>

