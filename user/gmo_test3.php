<?php

ini_set("display_errors",1);
error_reporting(E_ALL);


require('func_gmo.php');


////////////////////////////////////
// 取引登録

//インプット
$Amount=20000;
$Tax=1600;
$OrderID="100000000000000000000000006";
$JobCd = "AUTH"; //CHECK:有効性チェック CAPTURE:即時売上 AUTH:仮売上 SAUTH:簡易オーソリ

//リターン変数
$AccessID='';
$AccessPass='';
$errorinfo='';

list ($AccessID, $AccessPass, $errorinfo) = gmo_entry($OrderID, $JobCd, $Amount,$Tax);

if(empty($AccessID)){
	echo '取引登録エラー：'.$AccessPass.' '.$errorinfo;
}else{
	echo '取引登録成功 AccessID:'.$AccessID.' AccessPass:'.$AccessPass;
}
echo '<BR>';

////////////////////////////////////
// 決済実行

/*

//インプット
$Method=1; //method 1:一括 2:分割 3:ボーナス一括 4:ボーナス分割 5:リボ
$Paytimes=1;
$Cardno='4111111111111111';
$Expire='1901';
$Securitycode='000';

//リターン変数
$Forward="";
$Approve="";
$TranID="";
$TranDate="";
$CheckString="";

list ($Forward, $Approve, $TranID, $TranDate, $CheckString) = gmo_exec($AccessID,$AccessPass,$OrderID,$Method,$Paytimes,$Cardno,$Expire,$Securitycode);

if(empty($Forward)){
	echo '決済実行エラー：'.$Approve;
}else{
	echo '決済実行成功';
}

*/

?>

