<?php

//////////////////////////////////////
// user/regist_user.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
//if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
//}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');
require('func_login_user.php');

session_start();


if(!empty($_POST['return_btn'])){
	header(sprintf('Location:%s',$_SESSION['RET_URL_LOGIN']));
	exit;
}

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$kiyaku = file_get_contents('kiyaku_user.txt');
$o_smarty->assign( 'kiyaku', $kiyaku );
$error=0;
$message="登録に失敗しました";


if(!empty($_POST)){
	
	if($_POST['text_kanji_sei']==''){$error=1;$message="「姓」が入力されていません";}
	if($_POST['text_kanji_mei']==''){$error=1;$message="「名」が入力されていません";}
	if($_POST['text_kana_sei']==''){$error=1;$message="「せい」が入力されていません";}
	if($_POST['text_kana_mei']==''){$error=1;$message="「めい」が入力されていません";}

	if($_POST['slt_gender']==''){$error=1;$message="性別が入力されていません";}
	if($_POST['slt_birth_year']==''){$error=1;$message="年が入力されていません";}
	if($_POST['slt_prefecture']==''){$error=1;$message="出身地が入力されていません";}
	

	if($_POST['text_mailaddress']==''){
		$error=1;
   		$message="メールアドレスが入力されていません";
	 }
	else
	{
		$_POST['text_mailaddress'] = mb_convert_kana($_POST['text_mailaddress'], "a", "UTF-8");			
		if (!preg_match('|^[0-9a-z_./?+-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $_POST['text_mailaddress'])) {
			$message="不正なメールアドレスです";
			$error=1;
		}
		//メールアドレスの重複チェック
		$db = dbconnect();

		/*
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_USER WHERE mailaddress=%s',
					$db->quote($_POST['text_mailaddress'])
					);

		$res = $db->query($sql);
		*/
		
		$sql ='SELECT COUNT(*) AS cnt FROM TM_USER WHERE mailaddress=?';
		$stmt = $db->prepare( $sql );
		$stmt->bindParam(1, $_POST['text_mailaddress'], PDO::PARAM_STR);	
		$stmt->execute();		
		
		//if ($res->fetchColumn() > 0) {
		if($stmt->fetchColumn() > 0){
			
			$error=1;
			$message="すでに登録されているメールアドレスです";
		}
		$db=NULL;

	}

	$params['text_kanji_sei']=$_POST['text_kanji_sei'];
	$params['text_kanji_mei']=$_POST['text_kanji_mei'];
	$params['text_kana_sei']=$_POST['text_kana_sei'];
	$params['text_kana_mei']=$_POST['text_kana_mei'];
	
	$params['text_mailaddress']=$_POST['text_mailaddress'];
	$params['slt_gender']=$_POST['slt_gender'];
	$params['slt_birth_year']=$_POST['slt_birth_year'];
	$params['slt_prefecture']=$_POST['slt_prefecture'];

	$params['message']=$message;
	

	if($error){
		//エラー
		$o_smarty->assign( 'head_tpl', 'head_regist_user.tpl' );
		$o_smarty->assign( 'body_tpl', 'body_regist_user.tpl' );
		
	}else{

		$naiyo="";	
		$naiyo .= "氏名：".$_POST['text_kanji_sei'].' '.$_POST['text_kanji_mei'].PHP_EOL;
		$pass =substr(base_convert(md5(uniqid()), 16, 36), 0, 8);		
		$naiyo .= "パスワード：".$pass;
		
		$mail_title ="【e-ART】申請手続き完了のお知らせ";
		$mail_body = MailBody_user(htmlspecialchars($params['text_kanji_sei'], ENT_QUOTES, 'UTF-8'), $ini['TOIAWASE'], $naiyo);
	
	
		if(MySendMailandCC(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES, 'UTF-8'), $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']))
		{
		
			//挿入
			$db = dbconnect();
			
			/*
			$sql = sprintf('INSERT INTO TM_USER SET kanji_sei=%s, kanji_mei=%s, kana_sei=%s, kana_mei=%s, mailaddress=%s, gender=%d, birth_year=%d, syussin_pref=%s, password="%s", regist_time="%s", update_time="%s"',
							$db->quote($_POST['text_kanji_sei']),
							$db->quote($_POST['text_kanji_mei']),
							$db->quote($_POST['text_kana_sei']),
							$db->quote($_POST['text_kana_mei']),
							$db->quote($_POST['text_mailaddress']),
							$_POST['slt_gender'],
							$_POST['slt_birth_year'],
							$db->quote($_POST['slt_prefecture']),
							hash("sha256", $pass ,FALSE),
							date('Y-m-d H:i:s'),
							date('Y-m-d H:i:s')
							);
					
			$record=NULL;
			my_execute($db,$sql,$record);
			*/

			$sql = sprintf('INSERT INTO TM_USER SET kanji_sei=?, kanji_mei=?, kana_sei=?, kana_mei=?, mailaddress=?, gender=?, birth_year=?, syussin_pref=?, password=?, regist_time="%s", update_time="%s"',
							date('Y-m-d H:i:s'),
							date('Y-m-d H:i:s')
							);
			$shapass = hash("sha256", $pass ,FALSE);
			$stmt = $db->prepare( $sql );
			$stmt->bindParam(1, $_POST['text_kanji_sei'], PDO::PARAM_STR);	
			$stmt->bindParam(2, $_POST['text_kanji_mei'], PDO::PARAM_STR);	
			$stmt->bindParam(3, $_POST['text_kana_sei'], PDO::PARAM_STR);	
			$stmt->bindParam(4, $_POST['text_kana_mei'], PDO::PARAM_STR);	
			$stmt->bindParam(5, $_POST['text_mailaddress'], PDO::PARAM_STR);	
			$stmt->bindParam(6, $_POST['slt_gender'], PDO::PARAM_INT);	
			$stmt->bindParam(7, $_POST['slt_birth_year'], PDO::PARAM_INT);	
			$stmt->bindParam(8, $_POST['slt_prefecture'], PDO::PARAM_STR);	
			$stmt->bindParam(9, $shapass, PDO::PARAM_STR);	
			$stmt->execute();
			
			$db=NULL;
			
		}
		else
		{
			$params['message']="ユーザー登録に失敗しました";
		}

		$db = dbconnect();
		list ($user_id, $kanji_sei, $kanji_mei)  =user_login(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES,'UTF-8'), hash("sha256", $pass,FALSE),$db);
		$db = NULL;

		//ユーザー登録成功
		$_SESSION['user_id']=$user_id;
		$_SESSION['user_pass']=hash("sha256",$pass,FALSE);
		$_SESSION['kanji_sei']=$kanji_sei;
		$_SESSION['kanji_mei']=$kanji_mei;	
		$_SESSION['time']=time();

		if(!empty($_SESSION['ORDER_URL'])){
			header(sprintf('Location:%s',$_SESSION['ORDER_URL']));
			exit;			
		}else{
			header('Location:gallery.php');
			exit;			
		}
		
	}

	$o_smarty->assign( 'params', $params );

}else{
	$o_smarty->assign( 'head_tpl', 'head_regist_user.tpl' );
	$o_smarty->assign( 'body_tpl', 'body_regist_user.tpl' );
	$o_smarty->assign( 'params', NULL );
}

$o_smarty->assign( 'login_flg', NULL);
$o_smarty->assign( 'artist_name', "ユーザー登録");
$o_smarty->assign( 'metaproperty', "" );

$o_smarty->display( 'template.tpl' );


?>