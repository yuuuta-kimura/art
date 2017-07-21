<?php

$ini = parse_ini_file('config.ini');
//if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
//}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');
require('func_login_user.php');
require_once("MySmarty.class.php");

session_start();

if(!empty($_POST['return_btn'])){
	if(!empty($_SESSION['RET_URL_USER'])){
		header(sprintf('Location:%s',$_SESSION['RET_URL_USER']));
		exit;
	}else{
		header('Location:user_login.php');
		exit;		
	}
}

if(!empty($_POST['make_user_btn'])){
	header('Location:regist_user.php');
	exit;
}

$return_url= empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$return_url.=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$_SESSION['RET_URL_LOGIN']=$return_url;


$o_smarty=new MySmarty();
$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_user_login.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$params['text_mailaddress'] = NULL;
$params['text_password'] = NULL;
$params['autosave'] = NULL;
$params['login'] = NULL;


if(!empty($_POST)){

	$db = dbconnect();

	if($_POST['text_mailaddress']!='' && $_POST['text_password']!=''){
			
		list ($user_id, $kanji_sei, $kanji_mei)  =user_login(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES,'UTF-8'), hash("sha256", htmlspecialchars($_POST['text_password'], ENT_QUOTES,'UTF-8') ,FALSE),$db);

		if($user_id != "")
		{
		
			//ログイン成功
			session_regenerate_id();
			$_SESSION['user_id']=$user_id;
			$_SESSION['user_pass']=hash("sha256", htmlspecialchars($_POST['text_password'], ENT_QUOTES,'UTF-8') ,FALSE);
			$_SESSION['kanji_sei']=$kanji_sei;			
			$_SESSION['kanji_mei']=$kanji_mei;			
			$_SESSION['time']=time();
						
			//ログイン情報をクッキーに保存する
			if (!empty($_POST['autosave']))
			{		
				setcookie('eart_user_email', $_POST['text_mailaddress'], time()+60*60*24*30);
				setcookie('eart_user_password', $_POST['text_password'], time()+60*60*24*30);

			}else{
				setcookie('eart_user_email','',time()-3600);
				setcookie('eart_user_password','',time()-3600);
			}
			if(!empty($_SESSION['ORDER_URL'])){				
				header(sprintf('Location:%s',$_SESSION['ORDER_URL']));
				exit;			
			}
			if(!empty($_SESSION['RET_URL_USER'])){
				header(sprintf('Location:%s',$_SESSION['RET_URL_USER']));
				exit;
			}
			
		}
		else{
			$params['login'] = "error";
		}
	}
	$db=NULL;
}

if(!empty($_COOKIE['eart_user_email'])){	
	$params['text_mailaddress'] = $_COOKIE['eart_user_email'];
	$params['text_password'] = $_COOKIE['eart_user_password'];
	$params['autosave'] = 'on';

}
$o_smarty->assign( 'artist_name', NULL );
$o_smarty->assign( 'metaproperty', NULL );
$o_smarty->assign( 'login_flg', NULL );
$o_smarty->assign( 'params', $params );
$o_smarty->display( 'template.tpl' );

?>