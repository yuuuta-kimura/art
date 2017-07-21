<?php

$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');
require('func_login_admin.php');


session_start();

//header('Location: regist_user.php');


require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );

$params['done']=NULL;


//ログインチェック
$login_flg=0;
if(!empty($_SESSION['admin_pass']))
{
	if(admin_login_session($_SESSION['admin_pass']))
	{
		$login_flg=1;
	}
}



if(!empty($_SESSION['artist_id']) && $login_flg)
{

	if(!empty($_POST['bt_OKNG']))
	{	
		if($_POST['bt_OKNG']==1){
			$db = dbconnect();
			$sql=sprintf('UPDATE TM_ARTIST SET check_flg=1 WHERE %d', $_SESSION['artist_id']);
			$record=NULL;
			my_execute($db,$sql,$record);
			$params['done']='OK更新しました';
		}
		if($_POST['bt_OKNG']==2){
			$db = dbconnect();
			$sql=sprintf('UPDATE TM_ARTIST SET check_flg=0 WHERE %d', $_SESSION['artist_id']);
			$record=NULL;
			my_execute($db,$sql,$record);		
			$params['done']='NG更新しました';
		}
	}	
	
	$db = dbconnect();
	$sql=sprintf('SELECT * FROM TM_ARTIST WHERE artist_id=%d',$_SESSION['artist_id']);
	$record=$db->query($sql);
	$data=$record->fetch(PDO::FETCH_ASSOC);

	if(!empty($data)){
		$params['artist_id']=$data['artist_id'];
		switch($data['check_flg'])
		{
			case 0:
				$params['check_flg']='NG';
				break;
			case 1:
				$params['check_flg']='OK';
				break;
			default:
				$params['check_flg']='未';
				break;
		}

		$params['kanji_sei']=$data['kanji_sei'];
		$params['kanji_mei']=$data['kanji_mei'];
		$params['kana_sei']=$data['kana_sei'];
		$params['kana_mei']=$data['kana_mei'];
		$params['mailaddress']=$data['mailaddress'];
		$params['tel']=$data['tel'];
		$params['birthday']=date('Y年m月d日', strtotime($data['birthday']));
		switch($data['gender'])
		{
			case 1:
				$params['gender']='男';
				break;
			case 2:
				$params['gender']='女';
				break;
			default:
				$params['gender']='未';
				break;
		}

		$params['main_record']=$data['main_record'];
		$params['sub_record']=$data['sub_record'];
		$params['kiji_link']=$data['kiji_link'];
		$params['post']=$data['post'];
		$params['jyusyo']=$data['jyusyo'];
		$params['password']=$data['password'];
		$params['regist_time']=$data['regist_time'];
		$params['update_time']=$data['update_time'];
		
	}
	$db=NULL;
	
}
else
{
	$params=NULL;
}


if(!empty($_POST['bt_Mail']) && $login_flg)
{

	$name = htmlspecialchars($_POST['text_name'], ENT_QUOTES, 'UTF-8');
	$pass =substr(base_convert(md5(uniqid()), 16, 36), 0, 8);
	if($_POST['bt_Mail']==1){
		if($params['check_flg']=='OK'){
			$mail_title ="【e-ART】申請完了のご案内";
			$mail_body = MailBody_ok($name, $pass, $ini['TOIAWASE']);
			MySendMailandCC(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES, 'UTF-8'), $mail_title,
			$mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']);
						
			$db = dbconnect();
			$sql=sprintf('UPDATE TM_ARTIST SET password="%s" WHERE %d', hash("sha256", $pass,FALSE), $_SESSION['artist_id']);
			$record=NULL;
			my_execute($db,$sql,$record);
			
			$params['done']='OKのメールを送信しました';			
		}else{
			$params['done']='OKになっていません';						
		}
			
	}
	if($_POST['bt_Mail']==2){
		if($params['check_flg']=='NG'){
			$mail_title ="【e-ART】審査結果のご案内";	
			$mail_body = MailBody_ng($name, $pass, $ini['TOIAWASE']);
			MySendMailandCC(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES, 'UTF-8'), $mail_title,
			$mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']);
			$params['done']='NGのメールを送信しました';
		}else{
			$params['done']='NGになっていません';						
		}
	}

}

if(!empty($_POST['bt_Ret']))
{
	if(!empty($_SESSION['page'])){
		$urlret = sprintf('Location:admin_artist.php?page=%d',$_SESSION['page']);
	}else{
		$urlret = 'Location:admin_artist.php';	
	}
	header($urlret);
	exit();
}

$o_smarty->assign( 'body_tpl', 'body_admin_artist_detail.tpl' );
$o_smarty->assign( 'params', $params );

$o_smarty->display( 'template.tpl' );

?>