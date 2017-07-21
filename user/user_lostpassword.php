<?php

$ini = parse_ini_file('config.ini');
//if($ini['DEBUG_MODE']==1)_{
ini_set("display_errors",1);
error_reporting(E_ALL);
//}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');

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
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_user_lostpassword.tpl' );
$o_smarty->assign( 'params', NULL );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$message=NULL;
if(!empty($_POST)){

	if($_POST['text_mailaddress']==''){
		$message = 'メールアドレスが入力されていません';
	}
	else{	
		$db = dbconnect();
	
		//メールアドレスチェック	
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

			//姓名を取得
			/*
			$sql = sprintf('SELECT kanji_sei FROM TM_USER WHERE mailaddress=%s',$db->quote($_POST['text_mailaddress']));
			$record=$db->query($sql);
			*/

			$sql = 'SELECT kanji_sei FROM TM_USER WHERE mailaddress=?';
			$stmt = $db->prepare( $sql );
			$stmt->bindParam(1, $_POST['text_mailaddress'], PDO::PARAM_STR);	
			$stmt->execute();		
						
			//if($table = $record->fetch(PDO::FETCH_ASSOC)){
			if($table = $stmt->fetch(PDO::FETCH_ASSOC)){
				$nickname = htmlspecialchars($table['kanji_sei'], ENT_QUOTES, 'UTF-8');
			}

			//パスワードの再作成
			$pass =substr(base_convert(md5(uniqid()), 16, 36), 0, 8);

			//パスワードの更新
			/*
			$sql = sprintf('UPDATE TM_USER SET password="%s" WHERE mailaddress=%s',
						hash("sha256",$pass,FALSE),
						$db->quote($_POST['text_mailaddress'])
						);
			my_execute($db,$sql,$record);
			*/

if($ini['DEBUG_MODE']==1){
	echo $pass;
}
			
			$sql = 'UPDATE TM_USER SET password=? WHERE mailaddress=?';
			$shapass = hash("sha256",$pass,FALSE);
			$stmt = $db->prepare( $sql );
			$stmt->bindParam(1, $shapass, PDO::PARAM_STR);	
			$stmt->bindParam(2, $_POST['text_mailaddress'], PDO::PARAM_STR);	
			$stmt->execute();		

			//クッキーのリセット
			if(!empty($_COOKIE['eart_user_email'])){	
				setcookie('eart_user_password', "", time()+60*60*24*14);
			}
			
			//パスワードの送付
			$mail_title ="【e-ART】パスワード変更のお知らせ";
			$mail_body = MailBody_password_user($nickname,$pass, $ini['TOIAWASE']);
		
			if(MySendMail(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES, 'UTF-8'), $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE'])))
			{
				//$message="メールを送信しました ".$pass;
				$message='<font color="red"><p>メールを送信しました。</p><p>メールにて新しいパスワードをご確認ください。</p></font>';
			}
			else{
				$message="メール送信に失敗しました";
			}
		}
		else{
			//パスワードが無い
				$message="ご指定のメールアドレスは登録されていません";
		}
	}
}else{
    $message='<p>ご登録のメールアドレスを入力してください。</p><p>新しいパスワードをメールで送信いたします。</p>';

}

$o_smarty->assign( 'artist_name', NULL );
$o_smarty->assign( 'metaproperty', NULL );
$o_smarty->assign( 'login_flg', NULL );
$o_smarty->assign( 'params', NULL );
$o_smarty->assign( 'message', $message);
$o_smarty->display( 'template.tpl' );

?>