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
$o_smarty=new MySmarty();

$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_user_profile.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );


//セッション開始
session_start();

$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);

//ログインチェック
$ret=0;$login_flg ='no';

if(!empty($_SESSION['user_id']) && !empty($_SESSION['user_pass'])){

	$db = dbconnect();
	$ret =user_login_check($_SESSION['user_id'], $_SESSION['user_pass'], $db);
	$db = NULL;


	if($ret){
		$login_flg ='yes';
	}
}

$db = dbconnect();
if($ret)
{
	if(empty($_POST))
	{
		$message=NULL;
	}
	else
	{
			
		$error=0;
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
			/*
			$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_USER WHERE mailaddress=%s',
						$db->quote($_POST['text_mailaddress'])
						);
			$res = $db->query($sql);
			*/
			
			$sql = 'SELECT COUNT(*) AS cnt FROM TM_USER WHERE mailaddress=?';
			$stmt = $db->prepare( $sql );
			$stmt->bindParam(1, $_POST['text_mailaddress'], PDO::PARAM_STR);	
			$stmt->execute();		
			
			//if ($res->fetchColumn() > 0) {		
			if($stmt->fetchColumn() > 0){
				$error=1;
				$message="すでに登録されているメールアドレスです";
			}

			$params['text_mailaddress']=$_POST['text_mailaddress'];

			if(!$error)
			{

				//パスワードの送付
				$mail_title ="【e-ART事務局】メールアドレス変更のお知らせ";
				$mail_body = MailBody_changeemail_user($_SESSION['kanji_sei'], $ini['TOIAWASE']);

				MySendMail($_POST['text_mailaddress'], $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']));				
				
				$sql = sprintf('UPDATE TM_USER SET mailaddress=%s, update_time="%s" WHERE user_id=%d',
								$db->quote($_POST['text_mailaddress']),
								date('Y-m-d H:i:s'),
								$_SESSION['user_id']
								);

				$record=NULL;
				my_execute($db,$sql,$record);

				//クッキーのリセット
				if(!empty($_COOKIE['eart_user_email'])){	
					setcookie('eart_user_email', "", time()+60*60*24*14);
				}

				$message="メールアドレスの変更が完了しました";
			}
		}
	}
	
}
else
{
	$message="セッションがなくなりました。再ログインしてください。";
}
	

$db=NULL;

$o_smarty->assign( 'params', NULL);
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'artist_name', NULL );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'metaproperty', NULL );
$o_smarty->assign( 'message', $message );
$o_smarty->assign( 'URL_GALLERY', $_SESSION['RET_URL_USER'] );
$o_smarty->display( 'template.tpl' );



?>