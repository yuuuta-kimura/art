<?php

$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('func_login_user.php');

require_once("MySmarty.class.php");
$params=array();

//セッション解放
session_start();

$message="";

$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);

//$RET_USR=$_SESSION['RET_URL_USER'];
if(!empty($_POST['destroy_btn'])){

	//カートを空にする
	$db = dbconnect();

	$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET user_id_cart=%d, cart_make_time="%s" WHERE user_id_cart=%d',
				 0,
				 "2000-01-01 00:00:00",
				 $_SESSION['user_id']
				);
	$record=NULL;
	my_execute($db,$sql,$record);

	$db=NULL;	
	
	if(!empty($_SESSION['user_id'])){
		$_SESSION['user_id']="";
		$_SESSION['user_pass']="";
		$_SESSION['kanji_sei']="";
		$_SESSION['kanji_mei']="";
		$_SESSION['URL_GALLERY']="";
		$_SESSION['RET_URL_USER']="";
		$_SESSION['ORDER_URL']="";
	}
	session_destroy();
	session_start();
	//$_SESSION['RET_URL_USER']=$RET_USR;
	//$message="ログアウトしました";
	//$login_flg =NULL;
	
	header(sprintf('Location:gallery.php?artist_id=%d',$artist_id));
	exit();
	
	
}

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

$o_smarty=new MySmarty();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_user_logout.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'artist_name', NULL );
$o_smarty->assign( 'metaproperty', NULL );
$o_smarty->assign( 'message', $message );
$o_smarty->assign( 'URL_GALLERY', $_SESSION['RET_URL_USER'] );
$o_smarty->assign( 'params',$params);
$o_smarty->display( 'template.tpl' );

?>