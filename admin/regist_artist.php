<?php

$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');

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

$kiyaku = file_get_contents('kiyaku.txt');
$o_smarty->assign( 'kiyaku', $kiyaku );
$o_smarty->assign( 'form', 'regist' );
$error=0;
$error_message="更新に失敗しました";


if(!empty($_POST)){
	
	if($_POST['text_kanji_sei']==''){$error=1;$error_message="「選手　姓」が入力されていません";}
	if($_POST['text_kanji_mei']==''){$error=1;$error_message="「選手　名」が入力されていません";}
	if($_POST['text_kana_sei']==''){$error=1;$error_message="「選手　せい」が入力されていません";}
	if($_POST['text_kana_mei']==''){$error=1;$error_message="「選手　めい」が入力されていません";}

	if($_POST['slt_gender']==''){$error=1;$error_message="性別が入力されていません";}
	if($_POST['slt_birth_year']==''){$error=1;$error_message="年が入力されていません";}
	if($_POST['slt_birth_month']==''){$error=1;$error_message="月が入力されていません";}
	if($_POST['slt_birth_day']==''){$error=1;$error_message="日が入力されていません";}

	if($_POST['text_main_record']==''){$error=1;$error_message="受賞歴など主な実績が入力されていません";}
	if($_POST['text_sub_record']==''){$error=1;$error_message="美術に関わる出身大学、または職歴が入力されていません";}

	if($_POST['text_mailaddress']==''){
		$error=1;
   		$error_message="メールアドレスが入力されていません";
	 }
	else
	{
		$_POST['text_mailaddress'] = mb_convert_kana($_POST['text_mailaddress'], "a", "UTF-8");			
		if (!preg_match('|^[0-9a-z_./?-+]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $_POST['text_mailaddress'])) {
			$error_message="不正なメールアドレスです";
			$error=1;
		}
		//メールアドレスの重複チェック
		$db = dbconnect();
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_ARTIST WHERE mailaddress=%s',
					$db->quote($_POST['text_mailaddress'])
					);

		$res = $db->query($sql);
		if ($res->fetchColumn() > 0) {		
			$error=1;
			$error_message="すでに登録されているメールアドレスです";
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
	$params['slt_birth_month']=$_POST['slt_birth_month'];
	$params['slt_birth_day']=$_POST['slt_birth_day'];

	$params['text_main_record']=$_POST['text_main_record'];
	$params['text_sub_record']=$_POST['text_sub_record'];
	$params['text_kiji_link']=$_POST['text_kiji_link'];
	
	$params['done']='info';
	$params['regist']="error";
	$params['error_message']=$error_message;
	

	if($error){
		//エラー
		$o_smarty->assign( 'head_tpl', 'head_regist_artist.tpl' );
		$o_smarty->assign( 'body_tpl', 'body_regist_artist.tpl' );
		
	}else{

		$naiyo="";
		$naiyo .= "名前：".$_POST['text_kanji_sei'].' '.$_POST['text_kanji_mei'].PHP_EOL;
		$naiyo .= "なまえ：".$_POST['text_kana_sei'].' '.$_POST['text_kana_mei'].PHP_EOL;		
		$naiyo .= "メールアドレス：".$_POST['text_mailaddress'].PHP_EOL;

		switch ($_POST['slt_gender']){
		case "1":
			$naiyo .= "性別：男".PHP_EOL;break;
		case "2":
			$naiyo .= "性別：女".PHP_EOL;break;
		default:
			$naiyo .= "性別：".PHP_EOL;break;
		}

		$naiyo .= "生年月日：".$_POST['slt_birth_year']."/".$_POST['slt_birth_month']."/".$_POST['slt_birth_day'].PHP_EOL;
		$naiyo .= "主な受賞歴：".$_POST['text_main_record'].PHP_EOL;
		$naiyo .= "関係する出身大学またはが職歴：".$_POST['text_sub_record'].PHP_EOL;
		$naiyo .= "HP：".$_POST['text_kiji_link'].PHP_EOL;
	
		$mail_title ="【eART】申請手続き完了のお知らせ";
		$mail_body = MailBody_first(htmlspecialchars($params['text_kanji_sei'], ENT_QUOTES, 'UTF-8'), $ini['TOIAWASE'], $naiyo);
	
	
		if(MySendMailandCC(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES, 'UTF-8'), $mail_title, $mail_body,sprintf("From:eART<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']))
		{
		
			//挿入
			$db = dbconnect();
			$sql = sprintf('INSERT INTO TM_ARTIST SET kanji_sei=%s, kanji_mei=%s, kana_sei=%s, kana_mei=%s, mailaddress=%s, gender=%d, birthday="%s", main_record=%s, sub_record=%s, kiji_link=%s, regist_time="%s", update_time="%s"',
							$db->quote($_POST['text_kanji_sei']),
							$db->quote($_POST['text_kanji_mei']),
							$db->quote($_POST['text_kana_sei']),
							$db->quote($_POST['text_kana_mei']),
							$db->quote($_POST['text_mailaddress']),
							$_POST['slt_gender'],
							sprintf("%d-%0d-%0d", $_POST['slt_birth_year'], $_POST['slt_birth_month'], $_POST['slt_birth_day']),
							$db->quote($_POST['text_main_record']),
							$db->quote($_POST['text_sub_record']),
							$db->quote($_POST['text_kiji_link']),							
							date('Y-m-d H:i:s'),
							date('Y-m-d H:i:s')
							);
					
			$record=NULL;
			my_execute($db,$sql,$record);
			$db=NULL;
			
			$params['message']="<p>申請ありがとうございました。</p><p>いただいたメールアドレスに確認メールを送信しましたのでご確認ください。</p><p>申請内容については、審査の後、３営業日以内にスタッフよりメールにてご連絡いたします。</p>";
		}
		else
		{
			$params['message']="ユーザー登録に失敗しました";
		}

		$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
		$o_smarty->assign( 'body_tpl', 'body_regist_artist_done.tpl' );
	}

	$o_smarty->assign( 'params', $params );


}else{
	$o_smarty->assign( 'head_tpl', 'head_regist_artist.tpl' );
	$o_smarty->assign( 'body_tpl', 'body_regist_artist.tpl' );
	$o_smarty->assign( 'params', NULL );
}

$o_smarty->display( 'template.tpl' );


?>