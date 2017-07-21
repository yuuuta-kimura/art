<?php


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}


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
$o_smarty->assign( 'body_tpl', 'body_user_pass.tpl' );
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
	
	$errorflg=0;
	
	if(!empty($_POST['change_pass'])){
	
		if(mb_strlen($_POST['before_pass'])==0){
			
			$message="変更前のパスワードが入力されていません";
			$errorflg=1;
			
		}else{
	
			$sql=sprintf('SELECT mailaddress, password FROM TM_USER WHERE user_id=%d',$_SESSION['user_id']);
			$record=$db->query($sql);
			$data=$record->fetch(PDO::FETCH_ASSOC);
			$mailaddress = $data['mailaddress'];
		
			if(hash("sha256",$_POST['before_pass'],FALSE)!=$data['password']){
			
				$message="変更前のパスワードが正しくありません";
				$errorflg=1;
			}
		}
		
		if($errorflg==0){if(mb_strlen($_POST['after_pass1'])<8 || mb_strlen($_POST['after_pass1'])>32){
		
			$message="パスワードは８文字以上、３２文字以下で入力してください";
			$errorflg=1;
		}}
		
		if($errorflg==0){if(!preg_match( "/^[a-zA-Z0-9]+$/" , $_POST['after_pass1'])){
		
			$message="半角英数字のみで入力してください";
			$errorflg=1;
		}}
		
		if($errorflg==0){if($_POST['after_pass1']!=$_POST['after_pass2']){
			
			$message="確認用のパスワードが間違っています";
			$errorflg=1;
		}}
	
		if($errorflg==0){

			//パスワードの送付
			$mail_title ="【e-ART事務局】パスワード変更のお知らせ";
			$mail_body = MailBody_password_user($_SESSION['kanji_sei'],$_POST['after_pass1'], $ini['TOIAWASE']);
		
			MySendMail($mailaddress, $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']));

			//備考※ハッシュかければプレースホルダーにしなくても大丈夫だった
			$sql = sprintf('UPDATE TM_USER SET password="%s", update_time="%s" WHERE user_id=%d',
							hash("sha256",$_POST['after_pass1'],FALSE),
							date('Y-m-d H:i:s'),
							$_SESSION['user_id']
							);
					
			$record=NULL;
			my_execute($db,$sql,$record);
			
			$_SESSION['user_pass']=hash("sha256",$_POST['after_pass1'],FALSE);

			//クッキーのリセット
			if(!empty($_COOKIE['eart_user_email'])){	
				setcookie('eart_user_password', "", time()+60*60*24*14);
			}
			
			$message="パスワードの変更が完了しました";
	
		}
	}else{
		$message=NULL;
	}
	
}else{
	$message="セッションがなくなりました。再ログインしてください。";
}
	
$o_smarty->assign( 'params', $params);

$db=NULL;

$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'artist_name', NULL );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'metaproperty', NULL );
$o_smarty->assign( 'message', $message );
$o_smarty->assign( 'URL_GALLERY', $_SESSION['RET_URL_USER'] );
$o_smarty->display( 'template.tpl' );



?>