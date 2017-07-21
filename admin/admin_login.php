<?php

//////////////////////////////////////
// artist/artist_login.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
	if($ini['DEBUG_MODE']==1){
	ini_set("display_errors",1);
	error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('func_login_admin.php');

session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_admin_login.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$params['text_mailaddress'] = NULL;
$params['text_password'] = NULL;
$params['login'] = NULL;


if(!empty($_POST)){

	if($_POST['text_mailaddress']!='' && $_POST['text_password']!=''){
			
		$login=admin_login(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES,'UTF-8'), hash("sha256", htmlspecialchars($_POST['text_password'], ENT_QUOTES,'UTF-8') ,FALSE));
		if($login)
		{
			//ログイン成功
			$_SESSION['admin_pass']=hash("sha256", htmlspecialchars($_POST['text_password'], ENT_QUOTES,'UTF-8') ,FALSE);
			$_SESSION['time']=time();
						
			header('Location:admin_artist.php');
			
		}
		else{
			$params['login'] = "error";
		}
	}
	$db=NULL;
}


$o_smarty->assign( 'params', $params );

$o_smarty->display( 'template.tpl' );

?>