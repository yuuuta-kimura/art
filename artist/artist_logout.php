<?php

//////////////////////////////////////
// artist/artist_logout.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}


require_once("MySmarty.class.php");
$o_smarty=new MySmarty();

session_start();

if(!empty($_POST["logout"])){
	$_SESSION['artist_id']=NULL;
	$_SESSION['artist_pass']=NULL;
	header('Location:artist_login.php');
	exit();
}



// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_artist_logout.tpl' );
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->assign( 'params', NULL );





$o_smarty->display( 'template.tpl' );

?>