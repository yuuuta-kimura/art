<?php

//////////////////////////////////////
// user/order_done.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require_once("MySmarty.class.php");
require('func_login_user.php');

//GET取得
$artist_id=0;
if(!empty($_GET['artist_id'])){
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}


if(!empty($_POST['to_gallery_btn'])){
	header('Location:gallery.php?artist_id='.$artist_id);
	exit;
}

session_start();
$o_smarty=new MySmarty();
$params=array();
$error=0;
$error_message="";

//ログインチェック
$ret=0;$params['login_flg'] ='no';
if(!empty($_SESSION['user_id']) && !empty($_SESSION['user_pass'])){
	$db = dbconnect();
	$ret =user_login_check($_SESSION['user_id'], $_SESSION['user_pass'], $db);
	$db = NULL;
	
	if($ret){
		$params['login_flg'] ='yes';
		$params['login_name'] =$_SESSION['kanji_sei'].$_SESSION['kanji_mei'];
	}
}


$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_order.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_order.tpl' );
$o_smarty->assign( 'body_tpl', 'body_order_done.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$params['page_type']=$_SESSION['page_type'];
$params['error_message']=$_SESSION['done_message'];

$_SESSION['done_message']=NULL;
$_SESSION['page_type']=NULL;

$o_smarty->assign( 'params', $params );
$o_smarty->assign( 'error', $error );
$o_smarty->display( 'template_index.tpl' );


?>

