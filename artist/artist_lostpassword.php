<?php

//////////////////////////////////////
// artist/artist_lostpassword.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');


require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$errors = array();
$params=array();


// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_artist_lostpassword.tpl' );
$o_smarty->assign( 'params', NULL );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$message=NULL;
$send=NULL;
if(!empty($_POST)){

	if($_POST['text_mailaddress']==''){
		$message = 'メールアドレスが入力されていません';
	}
	else{	
		$db = dbconnect();
	
		//メールアドレスチェック	
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_ARTIST WHERE mailaddress=%s',
						$db->quote($_POST['text_mailaddress'])
						);
		$res = $db->query($sql);
		if ($res->fetchColumn() > 0) {		

			//姓名を取得
			$sql = sprintf('SELECT * FROM TM_ARTIST WHERE mailaddress=%s',$db->quote($_POST['text_mailaddress']));
			$record=$db->query($sql);
			if($table = $record->fetch(PDO::FETCH_ASSOC)){
				
				$nickname = htmlspecialchars($table['kanji_sei'], ENT_QUOTES, 'UTF-8');		
				
			}

			//パスワードの再作成
			$pass =substr(base_convert(md5(uniqid()), 16, 36), 0, 8);

			//パスワードの更新
			$sql = sprintf('UPDATE TM_ARTIST SET password="%s" WHERE mailaddress=%s',
						hash("sha256",$pass,FALSE),
						$db->quote($_POST['text_mailaddress'])
						);
			my_execute($db,$sql,$record);

			//クッキーの保存
			if(!empty($_COOKIE['eART_artist_email'])){	
				setcookie('eART_artist_password', "", time()+60*60*24*14);
			}
			
			//パスワードの送付
			$mail_title ="【eART】パスワードの再発行";
			$mail_body = MailBody_password($nickname,$pass, $ini['TOIAWASE']);
	
			if(MySendMail(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES, 'UTF-8'), $mail_title, $mail_body,sprintf("From:eART<%s>",$ini['TOIAWASE'])))
			{
				//$message="メールを送信しました ".$pass;
				$message="メールを送信しました ";
			}
			else{
				$message="メール送信に失敗しました";
			}
		}
		else{
			//パスワードが無い
			$message="ご指定のメールアドレスは登録されていません";
	
		}
		$send='done';
	}
}
$params['message']=$message;	
$params['send']=$send;	

$o_smarty->assign( 'params', $params);

$o_smarty->display( 'template.tpl' );

?>