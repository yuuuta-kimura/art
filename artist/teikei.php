<?php

$ini = parse_ini_file('config.ini');

if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require_once("MySmarty.class.php");


$o_smarty=new MySmarty();
$params=array();

$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'body_tpl', 'body_teikei.tpl' );
$o_smarty->assign( 'head_tpl', 'head_teikei.tpl' );
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );


$ptn=htmlspecialchars($_GET['ptn'], ENT_QUOTES);

if($ptn=='a'){
	$o_smarty->assign( 'limit_min', $ini['ORDER_LIMIT_CANCEL_MINUTES'] );
}
	
	
if($ptn=='b'){
	$kiyaku = file_get_contents('../user/kiyaku_torihiki.txt');
	$o_smarty->assign( 'naiyo', $kiyaku );	
}


if($ptn=='c'){
	$kiyaku = file_get_contents('kiyaku_artist.txt');
	$o_smarty->assign( 'naiyo', $kiyaku );	
}

if($ptn=='d'){
	$kiyaku = file_get_contents('../user/kiyaku_privacy.txt');
	$o_smarty->assign( 'naiyo', $kiyaku );	
}


$o_smarty->assign( 'ptn', $ptn);

$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->assign( 'params', NULL);
$o_smarty->display( './templates/template.tpl' );

?>