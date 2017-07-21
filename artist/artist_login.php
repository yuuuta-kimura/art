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
require('func_login_artist.php');


session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_artist_login.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$params['text_mailaddress'] = NULL;
$params['text_password'] = NULL;
$params['autosave'] = NULL;
$params['login'] = NULL;


if(!empty($_POST)){

	$db = dbconnect();

	if($_POST['text_mailaddress']!='' && $_POST['text_password']!=''){
			
		list ($artist_id, $kanji_sei)  =artist_login(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES,'UTF-8'), hash("sha256", htmlspecialchars($_POST['text_password'], ENT_QUOTES,'UTF-8') ,FALSE),$db);
		if($artist_id != "")
		{
			//ログイン成功
			$_SESSION['artist_id']=$artist_id;
			$_SESSION['artist_pass']=hash("sha256", htmlspecialchars($_POST['text_password'], ENT_QUOTES,'UTF-8') ,FALSE);
			$_SESSION['kanji_sei']=$kanji_sei;			
			$_SESSION['time']=time();
						
			//ログイン情報をクッキーに保存する
			if (!empty($_POST['autosave']))
			{		
				setcookie('eART_artist_email', $_POST['text_mailaddress'], time()+60*60*24*30);
				setcookie('eART_artist_password', $_POST['text_password'], time()+60*60*24*30);

			}else{
				setcookie('eART_artist_email','',time()-3600);
				setcookie('eART_artist_password','',time()-3600);
			}		

			header('Location:workslist.php');
			
			/*
			if($ini['DEBUG_MODE']==1){
				header('Location:http://localhost/magnolia/open/myathlete/mypage_ath_top.php');
			}
			else{
				//どうやらサブドメインでは独自SSL証明書で対応できないようなので、athleteフォルダーはuser配下にしないといけなさそう
				header('Location:https://farm-sportsfunding.com/myathlete/mypage_ath_top.php');
			}
			*/

		}
		else{
			$params['login'] = "error";
		}
	}
	$db=NULL;
}

if(!empty($_COOKIE['eART_artist_email'])){	
	$params['text_mailaddress'] = $_COOKIE['eART_artist_email'];
	$params['text_password'] = $_COOKIE['eART_artist_password'];
	$params['autosave'] = 'on';

}

$o_smarty->assign( 'params', $params );



$o_smarty->display( 'template.tpl' );

?>