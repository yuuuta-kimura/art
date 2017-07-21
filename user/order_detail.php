<?php

//////////////////////////////////////
// user/order_detail.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('func_login_user.php');
require('mymail.php');

session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_gallery.css');
$o_smarty->assign( 'head_tpl', 'head_order_detail.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );

$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
$page = htmlspecialchars($_GET['page'], ENT_QUOTES);

$return_url= empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$return_url.=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$_SESSION['RET_URL_USER']=$return_url;
$_SESSION['URL_GALLERY']=$return_url;
$message='';
$cancel_enable=false;
$cancel_time='';

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
	header(sprintf('Location:order_list.php?artist_id=%d&page=%d',$artist_id,$page));
	exit();	
}


if($login_flg=='yes')
{
		
	$db = dbconnect();
	$order_char=htmlspecialchars($_GET['order_char'], ENT_QUOTES);
	$sql = 'SELECT COUNT(*) AS cnt FROM TM_ORDER WHERE order_char=? AND first_receive_time IS NULL AND cancel_time IS NULL';
	$stmt = $db->prepare($sql);
	$stmt->bindParam(1, $order_char, PDO::PARAM_STR);	
	$stmt->execute();		
	$CNT = $stmt->fetchColumn();
	
	if($CNT>0){
		$cancel_enable=true;
	}			
	
	 //注文リストを、作品ごとにリスト表示	
	
	$sql='SELECT * FROM TT_ORDER_WORKS AS t1 INNER JOIN TM_ORDER AS t2 ON t1.order_char = t2.order_char WHERE t1.order_char=? ORDER BY t1.works_id';	
	$stmt = $db->prepare($sql);
	$stmt->bindParam(1, $order_char, PDO::PARAM_STR);	
	$stmt->execute();
	
	
	$html=NULL;
	$order_time=NULL;
	$all_sum_price=NULL;
	$small_sum_price=NULL;
	$tax=NULL;
		
	$html.='<table border="1" padding="10">';
		$html.='<tr><th class="text-center" width="10%">作品ID</th>
		<th class="text-center" width="20%">タイトル</th>
		<th class="text-center" width="20%">アーティスト名</th>
		<th class="text-center" width="20%">発送日時</th>
		<th class="text-center" width="10%">画像</th>
		<th class="text-center width="20%">価格</th></tr>';
	
	$mail_naiyo='注文番号：'.$order_char.PHP_EOL.PHP_EOL;
	
	//while($data=$record->fetch(PDO::FETCH_ASSOC))
	while($data=$stmt->fetch(PDO::FETCH_ASSOC))
	{
		$send_time=NULL;
		if(!empty($data['send_time'])){
			if($data['send_time']!='0000-00-00 00:00:00'){
				$send_time=$data['send_time'];
			}
		}
			
		$html.=sprintf('<tr><td class="text-center">%d</td>
						<td class="text-center">%s</td>
						<td class="text-center">%s</td>
						<td class="text-center">%s</td>
						<td><img src="%s"></td>
						<td class="text-right" style="padding:10px;">%s</td></tr>',
						$data['works_id'],
						$data['title'],
						$data['artist_name'],
						$send_time,
						$data['picture'],
						'¥ '.number_format($data['price'])
						);
		
		if($order_time==NULL){$order_time = $data['regist_time'];}
		if($cancel_time==NULL){$cancel_time = $data['cancel_time'];}
		if(empty($all_sum_price)){$all_sum_price = '¥ '.number_format($data['all_sum_price']);}
		if(empty($small_sum_price)){$small_sum_price = '¥ '.number_format($data['small_sum_price']);}
		if(empty($tax)){$tax = '¥ '.number_format($data['tax']);}
		
		$mail_naiyo.='作家：'.$data['artist_name'].PHP_EOL;
		$mail_naiyo.='タイトル：'.$data['title'].PHP_EOL;
		$mail_naiyo.='価格：'.'¥ '.number_format($data['price']).PHP_EOL.PHP_EOL;		
	}
	$html.='</table>';
	

	if(!empty($_POST['cancel_btn']))
	{
		$order_char=htmlspecialchars($_GET['order_char'], ENT_QUOTES);
		$sql = 'SELECT COUNT(*) AS cnt FROM TM_ORDER WHERE order_char=? AND first_receive_time IS NULL AND cancel_time IS NULL';
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $order_char, PDO::PARAM_STR);	
		$stmt->execute();		
		$CNT = $stmt->fetchColumn();
				
		//注文取消
		if($CNT>0)
		{
			$cancel_enable=false;
			$cancel_time = date('Y-m-d H:i:s');
			
			$sql=sprintf('UPDATE TM_ORDER SET cancel=1, cancel_time="%s" WHERE order_char = ?',
						 $cancel_time);			
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $order_char, PDO::PARAM_STR);	
			$stmt->execute();		
			
						
			$sql='UPDATE TT_WORKS_ZAIKO SET user_id_cart=0, cart_make_time="2000-01-01 00:00:00", order_id=NULL WHERE order_id = ?';
			$stmt = $db->prepare($sql);
			$stmt->bindParam(1, $order_char, PDO::PARAM_STR);	
			$stmt->execute();
			
			
			/////////////////////////////
			//　ユーザーにメール送信
			$sql=sprintf('SELECT * FROM TM_USER WHERE user_id=%d', $_SESSION['user_id']);
			$record=NULL;
			$record=$db->query($sql);
			$data=$record->fetch(PDO::FETCH_ASSOC);

			$mail_title ="【e-ART】キャンセル完了";
			$mail_body = MailBody_cancel_to_user($data['kanji_sei'].' '.$data['kanji_mei'], $ini['TOIAWASE'], $mail_naiyo);
			$send_ret=MySendMailandCC($data['mailaddress'], $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']);



			/////////////////////////////
			//　作家にメール送信

			$sql=sprintf('SELECT t1.order_char, t4.mailaddress, t4.kanji_sei, t4.kanji_mei FROM TM_ORDER AS t1 INNER JOIN TT_ORDER_WORKS AS t2 ON t1.order_char = t2.order_char INNER JOIN TT_WORKS AS t3 ON t2.works_id = t3.works_id INNER JOIN TM_ARTIST AS t4 ON t3.artist_id = t4.artist_id WHERE t1.order_char = "%s" GROUP BY t4.mailaddress', $order_char);
			$record=NULL;
			$record=$db->query($sql);

			
			while($data=$record->fetch(PDO::FETCH_ASSOC))
			{
				$mail_title ='【重要】e-ARTのキャンセルがありました';
				$mail_naiyo='注文番号：'.$order_char.PHP_EOL.PHP_EOL;
				$mail_body = MailBody_cancel_to_artist($data['kanji_sei'].' '.$data['kanji_mei'], $ini['TOIAWASE'], $mail_naiyo);
				$send_ret=MySendMailandCC($data['mailaddress'], $mail_title, $mail_body,sprintf("From:e-ART事務局<%s>",$ini['TOIAWASE']), $ini['TOIAWASE']);
				sleep(3);
			}
			
			header(sprintf('Location:order_list.php?artist_id=%d&page=%d',$artist_id,$page));
			exit();				
			
		}else{
			$message='受注確定処理が行われたため、キャンセル処理ができません。';
			$cancel_enable=false;
		}
	}
	
	if(!empty($_POST['receipt_btn']))
	{

		require_once('tcpdf/tcpdf.php');

		$pdf = new TCPDF("P", "mm", "A4", true, "UTF-8" );
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage();
		$pdf->SetFont('kozminproregular', '', 20);


		$pdf->Image("images/logo_eart.png", 0, 5, 140, 20, 'png', '', 'M', false, 300, 'L', false, false, 0, true, false, false );
		$pdf->Text( 95, 30, "領収書" );
		$pdf->SetFont('kozminproregular', '', 10);
		$pdf->Text( 120, 50, "発行日　：".date('Y年n月j日') );
		$pdf->Text( 120, 55, "注文番号：".$order_char );
		$date = new DateTime($order_time);
		$pdf->Text( 120, 60, "注文日　：".$date->format('Y年n月j日') );
		
		$pdf->Text( 120, 70, "〒102-0084" );
		$pdf->Text( 120, 75, "東京都千代田区二番町５番地２麹町駅プラザ９階" );
		$pdf->Text( 120, 80, "株式会社ニューディメンション" );

		$pdf->Image("images/syaban.png", 130, 70, 20, 20, 'png', '', 'M', false, 300, 'R', false, false, 0, true, false, false );

		$pdf->Text( 10, 120, "作品タイトル" );
		$pdf->Text( 60, 120, "作者" );
		$pdf->Text( 100, 120, "作品番号" );
		$pdf->Text( 130, 120, "単価" );
		$pdf->Text( 155, 120, "数量" );
		$pdf->Text( 175, 120, "価格" );
		
		$sql='SELECT * FROM TT_ORDER_WORKS AS t1 INNER JOIN TM_ORDER AS t2 ON t1.order_char = t2.order_char WHERE t1.order_char=? ORDER BY t1.works_id';	
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $order_char, PDO::PARAM_STR);	
		$stmt->execute();		
		
			
		$margin = 120;
		$small_sum_price=NULL;
		$tax=NULL;
		$all_sum_price=NULL;
		
		while($data=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			$margin += 10;

			$pdf->Text( 10, $margin, $data['title'] );
			$pdf->Text( 60, $margin, $data['artist_name'] );
			$pdf->Text( 100, $margin, $data['works_id'] );
			$pdf->Text( 130, $margin, '¥ '.number_format($data['price']) );
			$pdf->Text( 155, $margin, "1" );
			$pdf->Text( 175, $margin, '¥ '.number_format($data['price']) );
			
			$small_sum_price = $data['small_sum_price'];
			$tax = $data['tax'];
			$all_sum_price = $data['all_sum_price'];
		}
		
		$margin += 10;
		$pdf->Text( 155, $margin, "小計" );
		$pdf->Text( 175, $margin, '¥ '.number_format($small_sum_price));

		$margin += 10;
		$pdf->Text( 155, $margin, "消費税" );
		$pdf->Text( 175, $margin, '¥ '.number_format($tax) );

		$margin += 10;
		$pdf->Text( 155, $margin, "合計" );
		$pdf->Text( 175, $margin, '¥ '.number_format($all_sum_price));

		$pdf->Output("receipt.pdf", "I");

	}	

	$params['html']=$html;
	$params['order_char']=$order_char;
	$params['order_time']=$order_time;
	$params['all_sum_price']=$all_sum_price;
	$params['small_sum_price']=$small_sum_price;
	$params['tax']=$tax;		   
	$params['message']=$message;
	$params['cancel_enable']=$cancel_enable;
	$params['cancel_time']=$cancel_time;

	$db=NULL;
	
}else{
	$params=NULL;	
}

$o_smarty->assign( 'artist_name', NULL);
$o_smarty->assign( 'metaproperty', NULL);
$o_smarty->assign( 'params', $params );
$o_smarty->assign( 'URL_GALLERY', $_SESSION['URL_GALLERY'] );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'body_tpl', 'body_order_detail.tpl' );
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->display( 'template.tpl' );


?>