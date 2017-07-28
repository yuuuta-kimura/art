<?php

$ini = parse_ini_file('config.ini');

if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require_once("MySmarty.class.php");
require('func_login_user.php');


$o_smarty=new MySmarty();
$params=array();

$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'body_tpl', 'body_teikei.tpl' );
$o_smarty->assign( 'head_tpl', 'head_teikei.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );


session_start();

$ptn=htmlspecialchars($_GET['ptn'], ENT_QUOTES);
if(empty($_GET['artist_id'])){
	//ゆくゆくは、アーティストが増えたら、まとめのインデックスページを作って飛ばす
	$artist_id=1;
}else{
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}
$params['artist_id']=$artist_id;


//ログインチェック
$ret=0;$login_flg ='no';
if(!empty($_SESSION['user_id']) && !empty($_SESSION['user_pass'])){
	$db = dbconnect();
	$ret =user_login_check($_SESSION['user_id'], $_SESSION['user_pass'], $db);
	$db = NULL;
	
	if($ret){
		$login_flg ='yes';
	}
}

if($ptn=='b'){
	$kiyaku = file_get_contents('kiyaku_torihiki.txt');
	$o_smarty->assign( 'naiyo', $kiyaku );	
}


if($ptn=='c'){
	$kiyaku = file_get_contents('kiyaku_user.txt');
	$o_smarty->assign( 'naiyo', $kiyaku );	
}

if($ptn=='d'){
	$kiyaku = file_get_contents('kiyaku_privacy.txt');
	$o_smarty->assign( 'naiyo', $kiyaku );	
}


$o_smarty->assign( 'artist_name', NULL);
$o_smarty->assign( 'metaproperty', NULL );
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'artist_name', NULL);
$o_smarty->assign( 'artist_id', $artist_id );

$o_smarty->assign( 'ptn', $ptn);

$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->assign( 'params', NULL);
$o_smarty->display( './templates/template.tpl' );

?>