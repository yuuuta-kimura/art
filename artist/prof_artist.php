<?php

//////////////////////////////////////
// artist/prof_artist.php
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

session_start();

//header('Location: regist_user.php');

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$errors = array();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );

if(!empty($_SESSION['artist_id'])&&!empty($_SESSION['artist_pass']))
{

	$o_smarty->assign( 'form', 'regist' );
	$error=0;
	$message="";
	$artist_id=1;

	if(!empty($_POST)){

		if($_POST['text_kanji_sei']==''){$error=1;$message="「選手　姓」が入力されていません";}
		if($_POST['text_kanji_mei']==''){$error=1;$message="「選手　名」が入力されていません";}
		if($_POST['text_kana_sei']==''){$error=1;$message="「選手　せい」が入力されていません";}
		if($_POST['text_kana_mei']==''){$error=1;$message="「選手　めい」が入力されていません";}

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
			$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_ARTIST WHERE mailaddress=%s AND artist_id != %d',
						$db->quote($_POST['text_mailaddress']),
						$artist_id
						);

			$res = $db->query($sql);
			if ($res->fetchColumn() > 0) {		
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

		if($error){
			//エラー
			$o_smarty->assign( 'head_tpl', 'head_regist_artist.tpl' );
			$o_smarty->assign( 'body_tpl', 'body_regist_artist.tpl' );

		}else{

			//挿入
			$db = dbconnect();
			
			/*
			$sql = sprintf('UPDATE TM_ARTIST SET kanji_sei=%s, kanji_mei=%s, kana_sei=%s, kana_mei=%s, mailaddress=%s, update_time="%s" WHERE artist_id=%d',
							$db->quote($_POST['text_kanji_sei']),
							$db->quote($_POST['text_kanji_mei']),
							$db->quote($_POST['text_kana_sei']),
							$db->quote($_POST['text_kana_mei']),
							$db->quote($_POST['text_mailaddress']),
							date('Y-m-d H:i:s'),
							$artist_id
							);

			$record=NULL;
			my_execute($db,$sql,$record);
			*/
			
			$sql = sprintf('UPDATE TM_ARTIST SET kanji_sei=?, kanji_mei=?, kana_sei=?, kana_mei=?, mailaddress=?, update_time="%s" WHERE artist_id=?',date('Y-m-d H:i:s'));

			
			$stmt = $db->prepare( $sql );
			
			$stmt->bindParam(1, $_POST['text_kanji_sei'], PDO::PARAM_STR);
			$stmt->bindParam(2, $_POST['text_kanji_mei'], PDO::PARAM_STR);
			$stmt->bindParam(3, $_POST['text_kana_sei'], PDO::PARAM_STR);
			$stmt->bindParam(4, $_POST['text_kana_mei'], PDO::PARAM_STR);
			$stmt->bindParam(5, $_POST['text_mailaddress'], PDO::PARAM_STR);
			$stmt->bindParam(6, $artist_id, PDO::PARAM_INT);

			$stmt->execute();	
			
			
			$db=NULL;
			
			$message="プロフィールを更新しました";

		}

		$o_smarty->assign( 'params', $params );


	}

	$db = dbconnect();
	$sql=NULL;$sql=sprintf("SELECT * FROM TM_ARTIST WHERE artist_id=%d", $artist_id);
	$record=NULL;$record=$db->query($sql);
	$data=$record->fetch(PDO::FETCH_ASSOC);
	$db=NULL;

	$params['artist_id']=$data['artist_id'];	
	$params['text_kanji_sei']=$data['kanji_sei'];
	$params['text_kanji_mei']=$data['kanji_mei'];
	$params['text_kana_sei']=$data['kana_sei'];
	$params['text_kana_mei']=$data['kana_mei'];
	$params['text_mailaddress']=$data['mailaddress'];
	$params['message']=$message;

	$o_smarty->assign( 'params', $params );

	$o_smarty->assign( 'head_tpl', 'head_regist_artist.tpl' );
	$o_smarty->assign( 'body_tpl', 'body_regist_artist.tpl' );
	$o_smarty->assign( 'frm_type', 'profile' );
	$o_smarty->display( 'template.tpl' );
	
}else
{
	$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
	$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
	$o_smarty->assign( 'body_tpl', 'body_session_out.tpl' );
	$o_smarty->assign( 'params', NULL );
	$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
	$o_smarty->display( 'template.tpl' );	
}


?>