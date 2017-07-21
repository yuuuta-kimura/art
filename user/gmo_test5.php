<?php

require('func_gmo.php');


////////////////////////////////////
// 実売上

//インプット
$AccessID="cf6a6c83bcdc4ee7ffb8935f7bad4dfd";
$AccessPass="5849437e372c590c299e11b73a1a8afc";
$Amount = 20000;


//リターン変数
$Forward="";
$Approve="";
$TranID="";
$TranDate="";


//list ($Forward, $Approve, $TranID, $TranDate) = gmo_sale($AccessID,$AccessPass,$Amount);

list ($Forward, $Approve, $TranID, $TranDate) = gmo_sales($AccessID,$AccessPass,$Amount);


if(empty($Forward)){
	echo '決済変更エラー：'.$Approve;
}else{
	echo '決済変更成功';
}


?>

