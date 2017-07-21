<?php

$ini = parse_ini_file('config.ini');
//if($ini['DEBUG_MODE']==0){
ini_set("display_errors",1);
error_reporting(E_ALL);
//}

require('dbconnect.php');
require('pdosql.php');
require('mymail.php');
require('func_login_user.php');


require_once("MySmarty.class.php");


session_start();

$o_smarty=new MySmarty();
$params=array();

if(empty($_GET['artist_id'])){
	//ゆくゆくは、アーティストが増えたら、まとめのインデックスページを作って飛ばす
	$artist_id=1;
}else{
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}
$params['artist_id']=$artist_id;

$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'head_tpl', 'head_toiawase.tpl' );
$o_smarty->assign( 'body_tpl', 'body_toiawase.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

$error=0;
$message="";

$db = dbconnect();	
$sql=sprintf('SELECT kanji_sei, kanji_mei, wp_url FROM TM_ARTIST WHERE artist_id =%d', $artist_id);
$record=NULL;
$record=$db->query($sql);
$data=$record->fetch(PDO::FETCH_ASSOC);
$db=NULL;

$artist_name = $data['kanji_sei'].' '.$data['kanji_mei'];
$wp_url = $data['wp_url'];

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


if(!empty($_POST['return_btn'])){
	header(sprintf('Location:%s',$wp_url));
	exit();	
}

if(!empty($_POST['send_btn'])){

	if($_POST['text_kenmei']==''){$error=1;$message="「件名」が入力されていません";}
	if($_POST['text_sei']==''){$error=1;$message="「姓」が入力されていません";}
	if($_POST['text_mei']==''){$error=1;$message="「名」が入力されていません";}
	if($_POST['slt_customer']==''){$error=1;$message="「個人／法人名」が選択されていません";}
	if($_POST['text_naiyo']==''){$error=1;$message="「内容」が入力されていません";}

	if($_POST['text_mailaddress']==''){
		$error=1;
   		$message="メールアドレスが入力されていません";
	 }
	else
	{
		$_POST['text_mailaddress'] = mb_convert_kana($_POST['text_mailaddress'], "a", "UTF-8");			
		if (!preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $_POST['text_mailaddress'])) {
			$message="不正なメールアドレスです";
			$error=1;
		}
	}

	$params['text_kenmei']=$_POST['text_kenmei'];
	$params['text_sei']=$_POST['text_sei'];
	$params['text_mei']=$_POST['text_mei'];
	$params['text_hojin']=$_POST['text_hojin'];
	$params['slt_customer']=$_POST['slt_customer'];
	
	$params['text_naiyo']=$_POST['text_naiyo'];	
	$params['text_mailaddress']=$_POST['text_mailaddress'];
	
	if(!$error)
	{
		$naiyo="";
		$naiyo .= "アーティスト名：".$artist_name.PHP_EOL;
		$naiyo .= "氏名：".$_POST['text_sei'].' '.$_POST['text_mei'].'様'.PHP_EOL;
		if($_POST['slt_customer']=="法人"){
			$naiyo .="法人名：".$_POST['text_hojin'].PHP_EOL;
		}
		$naiyo .= "メールアドレス：".$_POST['text_mailaddress'].PHP_EOL;
		$naiyo .= PHP_EOL;
		$naiyo .= "件名：".$_POST['text_kenmei'].PHP_EOL;
		$naiyo .= PHP_EOL;
		$naiyo .= $_POST['text_naiyo'];
	
		$mail_title ="【e-ART】お問い合わせを承りました";
		$mail_body = MailBody_toiawase($ini['TOIAWASE'], $naiyo);
	
		if(MySendMailandCC(htmlspecialchars($_POST['text_mailaddress'], ENT_QUOTES, 'UTF-8'), $mail_title, $mail_body,sprintf("From:eART<%s>",$ini['TOIAWASE']),$ini['TOIAWASE']))
		{		
			//挿入
			$db = dbconnect();
			$sql = sprintf('INSERT INTO TT_TOIAWASE_OUTER SET title=%s, customer=%s, hojin=%s, sei=%s, mei=%s, mailaddress=%s, naiyo=%s, regist_time="%s", update_time="%s"',
							$db->quote($_POST['text_kenmei']),
							$db->quote($_POST['slt_customer']),
							$db->quote($_POST['text_hojin']),
							$db->quote($_POST['text_sei']),
							$db->quote($_POST['text_mei']),
							$db->quote($_POST['text_mailaddress']),
							$db->quote($_POST['text_naiyo']),
							date('Y-m-d H:i:s'),
							date('Y-m-d H:i:s')
							);
						
			$record=NULL;
			my_execute($db,$sql,$record);
			$db=NULL;
			
			$message="<p>お問い合わせありがとうございました。</p>
			<p>お問い合わせ内容については、内容を確認の上、e-ART事務局スよりメールにてご回答いたします。</p>
			<p>スパム及び営業行為については、返信は控えさせていただきます。予めご了承ください。</p>";
		}
		else
		{
			$message="送信に失敗しました";
		}

		$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
		$o_smarty->assign( 'body_tpl', 'body_toiawase_done.tpl' );
		
	
		//★★★後でreCAPTHCAを実装する★★★
		//https://syncer.jp/how-to-introduction-recaptcha
	
	}
	
}
else
{
	$params['text_kenmei']=NULL;
	$params['slt_customer']=NULL;
	$params['text_hojin']=NULL;
	$params['text_sei']=NULL;
	$params['text_mei']=NULL;
	$params['text_mailaddress']=NULL;
	$params['text_naiyo']=NULL;
	$params['message']=NULL;
}

$params['message']=$message;

$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'artist_name', 'お問い合わせ');
$o_smarty->assign( 'metaproperty', '' );
$o_smarty->assign( 'params', $params);
$o_smarty->assign( 'error', $error );
//$o_smarty->assign( 'login_flg', NULL );
$o_smarty->display( 'template.tpl' );


?>

