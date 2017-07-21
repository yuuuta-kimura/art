<?php

//////////////////////////////////////
// artist/artist_changepassword.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}


require('dbconnect.php');
require('pdosql.php');
require('mymail.php');
require('func_login_artist.php');


require_once("MySmarty.class.php");
$o_smarty=new MySmarty();

$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );
$o_smarty->assign( 'body_tpl', 'body_artist_changepassword.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );


//セッション開始
session_start();

//ログインチェック

$send=NULL;
	
$db = dbconnect();
if(!empty($_SESSION['artist_id'])&&!empty($_SESSION['artist_pass']))
{
	
	$errorflg=0;
	
	if(!empty($_POST['change_pass'])){
	
		if(mb_strlen($_POST['before_pass'])==0){
			
			$params['message']="変更前のパスワードが入力されていません";
			$errorflg=1;
			
		}else{
	
			$sql=sprintf('SELECT mailaddress, password FROM TM_ARTIST WHERE artist_id=%d',$_SESSION['artist_id']);
			$record=$db->query($sql);
			$data=$record->fetch(PDO::FETCH_ASSOC);
			$mailaddress = $data['mailaddress'];
		
			if(hash("sha256",$_POST['before_pass'],FALSE)!=$data['password']){
			
				$params['message']="変更前のパスワードが正しくありません";
				$errorflg=1;
			}
		}
		
		if($errorflg==0){if(mb_strlen($_POST['after_pass1'])<8 || mb_strlen($_POST['after_pass1'])>32){
		
			$params['message']="パスワードは８文字以上、３２文字以下で入力してください";
			$errorflg=1;
		}}
		
		if($errorflg==0){if(!preg_match( "/^[a-zA-Z0-9]+$/" , $_POST['after_pass1'])){
		
			$params['message']="半角英数字のみで入力してください";
			$errorflg=1;
		}}
		
		if($errorflg==0){if($_POST['after_pass1']!=$_POST['after_pass2']){
			
			$params['message']="確認用のパスワードが間違っています";
			$errorflg=1;
		}}
	
		if($errorflg==0){

			//パスワードの送付
			$mail_title ="【e-ART】パスワード変更のお知らせ";
			$mail_body = MailBody_password_change($_SESSION['kanji_sei'],$_POST['after_pass1'], $ini['TOIAWASE']);
		
			MySendMail($mailaddress, $mail_title, $mail_body,sprintf("From:e-ART<%s>",$ini['TOIAWASE']));
			
			/*
			$sql = sprintf('UPDATE TM_ARTIST SET password="%s", update_time="%s" WHERE artist_id=%d',
							hash("sha256",$_POST['after_pass1'],FALSE),
							date('Y-m-d H:i:s'),
							$_SESSION['artist_id']
							);		
			$record=NULL;
			my_execute($db,$sql,$record);
			*/

			$sql = sprintf('UPDATE TM_ARTIST SET password = :pswd, update_time="%s" WHERE artist_id=%d',
							date('Y-m-d H:i:s'),
							$_SESSION['artist_id']
							);		
			$stmt = $db->prepare( $sql );
			$shapass = hash("sha256",$_POST['after_pass1'],FALSE);
			$stmt->bindParam(':pswd', $shapass, PDO::PARAM_STR);	
			$stmt->execute();
			
			$_SESSION['artist_pass']=$shapass;

			//クッキーのリセット
			if(!empty($_COOKIE['eART_artist_email'])){	
				setcookie('eART_artist_password', "", time()+60*60*24*14);
			}
			
			$params['message']="パスワードの変更が完了しました";
			$send ='done';
			
		}
	}else{
		$params['message']=NULL;
	}
	
}else{
	$params['message']="セッションがなくなりました。再ログインしてください。";
}

$params['send']=$send;
$o_smarty->assign( 'params', $params);

$db=NULL;

$o_smarty->display( 'template.tpl' );



?>