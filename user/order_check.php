<?php

//////////////////////////////////////
// user/order_check.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==0){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('./dbconnect.php');
require('./pdosql.php');
require_once("MySmarty.class.php");
require('func_login_user.php');
require('mymail.php');


//GET取得
$artist_id=0;
if(!empty($_GET['artist_id'])){
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}

if(!empty($_POST['return_btn'])){					
	header(sprintf('Location:order.php?artist_id=%d',$artist_id));
	exit();	
}

if(!empty($_POST['to_gallery_btn'])){					
	header(sprintf('Location:gallery.php?artist_id=%d',$artist_id));
	exit();	
}

session_start();
$o_smarty=new MySmarty();
$params=array();

//トークンチェック
$token=hash('sha256', session_id());
if(empty($_SESSION['token'])){
	$_SESSION['token']=$token;
}
if(empty($_POST['token'])){
	$o_smarty->assign( 'token', $token );
}else{
	$o_smarty->assign( 'token', $_POST['token']);	
}

$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_order_done.tpl' );
$o_smarty->assign( 'body_tpl', 'body_order_check.tpl' );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );


$error=0;
$error_message="";

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

$params['text_cardno']=$_SESSION['text_cardno'];$_SESSION['text_cardno']=NULL;
$params['text_code']=$_SESSION['text_code'];$_SESSION['text_code']=NULL;
$params['slt_month']=$_SESSION['slt_month'];$_SESSION['slt_month']=NULL;
$params['slt_year']=$_SESSION['slt_year'];$_SESSION['slt_year']=NULL;
$params['text_post_left']=$_SESSION['text_post_left'];$_SESSION['text_post_left']=NULL;
$params['text_post_right']=$_SESSION['text_post_right'];$_SESSION['text_post_right']=NULL;
$params['slt_prefecture']=$_SESSION['slt_prefecture'];$_SESSION['slt_prefecture']=NULL;
$params['text_city']=$_SESSION['text_city'];$_SESSION['text_city']=NULL;
$params['text_banchi']=$_SESSION['text_banchi'];$_SESSION['text_banchi']=NULL;
$params['text_atena']=$_SESSION['text_atena'];$_SESSION['text_atena']=NULL;
$params['text_tel_left']=$_SESSION['text_tel_left'];$_SESSION['text_tel_left']=NULL;
$params['text_tel_center']=$_SESSION['text_tel_center'];$_SESSION['text_tel_center']=NULL;
$params['text_tel_right']=$_SESSION['text_tel_right'];$_SESSION['text_tel_right']=NULL;		


//注文内容の表示
$html=NULL;

$db = dbconnect();

//先にカートに入れた人のタイムスタンプから待機時間を含めて、比較できる用のタイムスタンプ作成
$time_stamp=date('Y-m-d H:i:s', strtotime(sprintf('-%d minute',$ini['ORDER_LIMIT_MINUTE'])));

//カート内容をリスト表示
$sql=sprintf('SELECT t1.works_id, t2.title, t2.main_pic_small, t2.price, t3.kanji_sei, t3.kanji_mei FROM TT_WORKS_ZAIKO AS t1 INNER JOIN TT_WORKS As t2 ON t1.works_id= t2.works_id INNER JOIN TM_ARTIST AS t3 ON t2.artist_id=t3.artist_id WHERE t1.user_id_cart = %d AND t1.cart_make_time >= "%s" AND t1.order_id IS NULL', $_SESSION['user_id'], $time_stamp);
$record=NULL;
$record=$db->query($sql);

$html.='<div id="cart-table" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">';
$html.='<table border="1" padding="10">';
	$html.='<tr><th class="text-center" width="10%">作品ID</th><th class="text-center" width="20%">作家</th><th class="text-center width="30%"">タイトル</th><th class="text-center width="30%">価格</th></tr>';

$small_sum =0;
$cart_num=0;
$mail_naiyo='';
while($data=$record->fetch(PDO::FETCH_ASSOC))
{
	$html.=sprintf('<tr><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-right" style="padding:10px;">%s</td></tr>',
				 sprintf('A%08d',$data['works_id']),
				 $data['kanji_sei'].$data['kanji_mei'],
				 $data['title'],
				 '¥ '.number_format($data['price'])
				 );	
	
	$mail_naiyo.='作家：'.$data['kanji_sei'].' '.$data['kanji_mei'].PHP_EOL;
	$mail_naiyo.='タイトル：'.$data['title'].PHP_EOL;
	$mail_naiyo.='価格：'.'¥ '.number_format($data['price']).PHP_EOL.PHP_EOL;

	
	$small_sum=$small_sum+intval($data['price']);
	$cart_num=$cart_num+1;	
}
$html.='<tr><td></td><td></td><td class="text-right" style="padding:10px;">小計</td><td class="text-right" style="padding:10px;">'.'¥ '.number_format($small_sum).'</td></tr>';
$mail_naiyo.='小計：'.'¥ '.number_format($small_sum).PHP_EOL;
$html.='<tr><td></td><td></td><td class="text-right" style="padding:10px;">消費税</td><td class="text-right" style="padding:10px;">'.'¥ '.number_format(round($small_sum*0.08)).'</td></tr>';
$mail_naiyo.='税金：'.'¥ '.number_format(round($small_sum*0.08)).PHP_EOL;
$html.='<tr><td></td><td></td><td class="text-right" style="padding:10px;">合計</td><td class="text-right" style="padding:10px;">'.'¥ '.number_format($small_sum + round($small_sum*0.08)).'</td></tr>';
$mail_naiyo.='合計：'.'¥ '.number_format($small_sum + round($small_sum*0.08)).PHP_EOL;


$html.='</table>';
$html.='</div>';


$db=NULL;

$params['html']=$html;
$params['cart_num']=$cart_num;

/////////////////
//注文ボタンクリック

if(!empty($_POST['order_btn'])){

	//本画面にアクセスしてからORDER_LIMIT_MINUTE-1分を経過していたらリセット
	if(  strtotime(date('Y-m-d H:i:s'))  > strtotime(sprintf('+%d minute',$ini['ORDER_LIMIT_MINUTE']-1), strtotime(date($_SESSION['order_cart_stamp']))) ) 
	{
		$db = dbconnect();

		$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET user_id_cart=%d, cart_make_time="%s" WHERE user_id_cart=%d AND order_id IS NULL',
					 0,
					 "2000-01-01 00:00:00",
					 $_SESSION['user_id']
					);
		$record=NULL;
		my_execute($db,$sql,$record);

		$db=NULL;		
				
		$error_message='カートの制限時間を過ぎました。';
		$error=1;	
	}
	
	//CSRFトークンチェック
	$login_flg ='false';
	if (!empty($_SESSION['token']) && !empty($_POST['token'])) {
		if($_SESSION['token']==$_POST['token']){
			$error=0;
			$login_flg ='true';	
		}else{$error=1;}	
	}else{$error=1;}
	$order_token=$_SESSION['token'];
	$_SESSION['token']=NULL;
		
	if(!$error)
	{
		
		/////////////////////////////
		//order idは半角英数字ハイフンのみで２７桁
		$order_char='A';	//ARTのA 1桁
		$order_char.=sprintf("%08d",$_SESSION['user_id']);	//'_id 8桁
		$order_char.='-';									//  1桁
		$order_char.=substr($token,0,8); 								//token8桁
		$order_char.='-';									//  1桁
		$order_char.=sprintf("%08d",$_SESSION['order_start_hash']); 	//8桁
				
		//在庫に注文番号を挿入
		$db = dbconnect();
		
		$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET order_id="%s" WHERE user_id_cart=%d AND order_id IS NULL AND receive_time IS NULL AND send_time IS NULL',
					 $order_char,
					 $_SESSION['user_id']
					);
		
		$record=NULL;
		my_execute($db,$sql,$record);
		
		//オーダーした在庫を注文用プールにインサート
		$sql=sprintf('SELECT t1.seq_id, t1.works_id, t2.title, t2.main_pic_small, t2.price, t3.kanji_sei, t3.kanji_mei FROM TT_WORKS_ZAIKO AS t1 INNER JOIN TT_WORKS AS t2 ON t1.works_id = t2.works_id INNER JOIN TM_ARTIST AS t3 ON t2.artist_id=t3.artist_id WHERE t1.order_id="%s"', $order_char);		
		$record=NULL;
		$record=$db->query($sql);
				
		while($data=$record->fetch(PDO::FETCH_ASSOC))
		{

			$sql2 = sprintf('INSERT INTO TT_ORDER_WORKS SET order_char="%s",zaiko_seq_id=%d, works_id=%d, title="%s", artist_name="%s", picture="%s", price=%d, regist_time="%s"',
							$order_char,
							$data['seq_id'],
							$data['works_id'],
							$data['title'],
							$data['kanji_sei'].' '.$data['kanji_mei'],
							$data['main_pic_small'],
							$data['price'],
							date('Y-m-d H:i:s')
							);
			$record2=NULL;
			my_execute($db,$sql2,$record2);
				

		}		
		
		//　注文をDBに登録
		$sql = sprintf('INSERT INTO TM_ORDER SET order_char="%s", 
		small_sum_price=%d, tax=%d, all_sum_price=%d,
		user_id=%d, post=%s, prefecture=%s, city=%s, banchi=%s, atena=%s, tel=%s, regist_time="%s"',
						$order_char,
						$small_sum,
					    round($small_sum*0.08),
					    $small_sum + round($small_sum*0.08),
						$_SESSION['user_id'],
						$db->quote($_POST['text_post']),
						$db->quote($_POST['slt_prefecture']),
						$db->quote($_POST['text_city']),
						$db->quote($_POST['text_banchi']),
						$db->quote($_POST['text_atena']),
						$db->quote($_POST['text_tel']),
						date('Y-m-d H:i:s')
						);
		
		$record=NULL;
		my_execute($db,$sql,$record);
		
		/////////////////////////////
		//　本決済
		list ($kanji_sei, $kanji_mei, $kana_sei, $kana_mei)=get_user_name($_SESSION['user_id'], $_SESSION['user_pass'], $db);

		////////////////////////////////////
		// 取引登録

		//インプット
		$Amount=$small_sum + round($small_sum*0.08);
		//$Amount=0;
		$Tax=0;
		$OrderID=$order_char;

		$JobCd = "CAPTURE"; //CHECK:有効性チェック CAPTURE:即時売上 AUTH:仮売上 SAUTH:簡易オーソリ

		/////////////////////////////
		//　取引登録開始
		require_once('func_gmo.php');

		list ($AccessID, $AccessPass,$AccessError) = gmo_entry($OrderID, $JobCd, $Amount,$Tax);		
		if(empty($AccessID)){
			$error=1;
			$error_message.="決済に失敗しました。（取引登録開始）<BR>";
			$error_message.=gmo_get_error($AccessError);
		}else{

			////////////////////////////////////
			// 決済実行

			//インプット
			$Method=1; //method 1:一括 2:分割 3:ボーナス一括 4:ボーナス分割 5:リボ
			$Paytimes=1;
			$Cardno='4111111111111111';
			$Expire='1901';
			$Securitycode='000';
			//$Cardno=$_POST['text_cardno'];
			//$Expire=$_POST['slt_year'].$_POST['slt_month'];
			//$Securitycode=$_POST['text_code'];

			list ($Forward, $Approve, $TranID, $TranDate, $CheckString) = gmo_exec($AccessID,$AccessPass,$OrderID,$Method,$Paytimes,$Cardno,$Expire,$Securitycode);

			if(empty($Forward)){
				$error=1;
				$error_message.="決済に失敗しました。（決済実行）<BR>";
				$error_message.=gmo_get_error($TranID);
			}else{

				/////////////////////////////
				//　DBのステータス更新
				$sql = sprintf('UPDATE TM_ORDER SET order_flg=1 WHERE order_char="%s"', $order_char);
				$record=NULL;
				my_execute($db,$sql,$record);

				
				/////////////////////////////
				//　ユーザーにメール送信
				$sql=sprintf('SELECT * FROM TM_USER WHERE user_id=%d', $_SESSION['user_id']);
				$record=NULL;
				$record=$db->query($sql);
				$data=$record->fetch(PDO::FETCH_ASSOC);
				
				$mail_title ="【e-ART】注文完了";
				
				$mail_naiyo='注文番号：'.$order_char.PHP_EOL.PHP_EOL.$mail_naiyo;
				
				$mail_body = MailBody_order_to_user($data['kanji_sei'].' '.$data['kanji_mei'], $ini['TOIAWASE'], $mail_naiyo);
				$send_ret=MySendMailandCC($data['mailaddress'], $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']);

				
				if($send_ret){
					$error_message="決済が完了しました";
				}else{
					$error_message="決済は完了しましたが、メールの送信に失敗しました";
				}				

				/////////////////////////////
				//　作家にメール送信
				
				$sql=sprintf('SELECT t1.order_char, t4.mailaddress, t4.kanji_sei, t4.kanji_mei FROM TM_ORDER AS t1 INNER JOIN TT_WORKS_ZAIKO AS t2 ON t1.order_char = t2.order_id INNER JOIN TT_WORKS AS t3 ON t2.works_id = t3.works_id INNER JOIN TM_ARTIST AS t4 ON t3.artist_id = t4.artist_id WHERE t1.order_char = "%s" GROUP BY t4.mailaddress', $order_char);
				$record=NULL;
				$record=$db->query($sql);
				
				
				while($data=$record->fetch(PDO::FETCH_ASSOC))
				{
					sleep(3);
					$mail_title ='【重要】e-ARTの注文がありました';
					$mail_naiyo='注文番号：'.$order_char.PHP_EOL;
					$mail_body = MailBody_order_to_artist($data['kanji_sei'].' '.$data['kanji_mei'], $ini['TOIAWASE'], $mail_naiyo);
					$send_ret=MySendMailandCC($data['mailaddress'], $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']);
				}
				
			}
		}

		$params['error_message']=$error_message;
		$o_smarty->assign( 'error', $error );					
		$o_smarty->assign( 'body_tpl', 'body_order_done.tpl' );					
		$db=NULL;
	}
}

if($error)
{
	//$params['artist_id']=$_POST['artist_id'];
	$params['text_cardno']=NULL;
	$params['text_code']=NULL;
	$params['slt_month']=NULL;
	$params['slt_year']=NULL;
	$params['text_post_left']=NULL;
	$params['text_post_right']=NULL;
	$params['slt_prefecture']=NULL;
	$params['text_city']=NULL;
	$params['text_banchi']=NULL;
	$params['text_atena']=NULL;
	$params['text_tel_left']=NULL;
	$params['text_tel_center']=NULL;
	$params['text_tel_right']=NULL;	
}


//echo($_SESSION['order_start_hash']);

$o_smarty->assign( 'artist_name', "");
$o_smarty->assign( 'metaproperty', "" );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'URL_GALLERY', $_SESSION['URL_GALLERY'] );
$o_smarty->assign( 'login_flg', $login_flg );
$params['error_message']=$error_message;
$o_smarty->assign( 'params', $params );
$o_smarty->assign( 'error', $error );
//$o_smarty->assign( 'login_flg', NULL );
$o_smarty->display( 'template.tpl' );


?>

