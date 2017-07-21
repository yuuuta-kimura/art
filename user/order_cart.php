<?php

//////////////////////////////////////
// user/order_cart.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');

//if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
//}


require('./dbconnect.php');
require('./pdosql.php');
require_once("./MySmarty.class.php");
require('func_login_user.php');

session_start();

$o_smarty=new MySmarty();
$params=array();

$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_gallery.css');
$o_smarty->assign( 'body_tpl', 'body_order_cart.tpl' );
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );


$return_url= empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$return_url.=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$_SESSION['RET_URL_USER']=$return_url;

//GET取得
if(!empty($_GET['artist_id'])){
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}else{
	$artist_id=0;
}

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

$message='';


//注文
if(empty($_POST['order_btn']))
{		
	$order_start_hash = mt_rand(0,99999999);
	$_SESSION['order_start_hash'] = $order_start_hash;	
}
else
{
			
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
		
		$message='カートの制限時間を過ぎました。';
	}
	else
	{
		if($login_flg=='yes'){
			header(sprintf('Location:order.php?artist_id=%d',$artist_id));
			exit();
		}
		else{
			header('Location:user_login.php');	
			exit();			
		}		
	}
}


//戻る
if(!empty($_POST['return_btn'])){
	header(sprintf('Location:gallery.php?artist_id=%d',$artist_id));		
	exit();
}

//削除
if(!empty($_POST['delete_btn'])){

	if(!empty($_POST['works_id'])){
		$db = dbconnect();

		/*
		$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET user_id_cart=%d, cart_make_time="%s" WHERE works_id=%d AND user_id_cart=%d',
					 0,
					 "2000-01-01 00:00:00",
					 $_POST['works_id'],
					 $_SESSION['user_id']
					);
		$record=NULL;
		my_execute($db,$sql,$record);
		*/

		$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET user_id_cart=%d, cart_make_time="%s" WHERE works_id=? AND user_id_cart=%d',
					 0,
					 "2000-01-01 00:00:00",
					 $_SESSION['user_id']
					);
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $_POST['works_id'], PDO::PARAM_INT);	
		$stmt->execute();		
		
		
		$db=NULL;		
	}
	
}

if($login_flg=="yes")
{
	$db = dbconnect();

	//先にカートに入れた人のタイムスタンプから待機時間を含めて、比較できる用のタイムスタンプ作成
	$time_stamp=date('Y-m-d H:i:s', strtotime(sprintf('-%d minute',$ini['ORDER_LIMIT_MINUTE'])));

	//カート内容をリスト表示
	$sql=sprintf('SELECT t1.works_id, t2.title, t2.main_pic_small, t2.price, t3.kanji_sei, t3.kanji_mei FROM TT_WORKS_ZAIKO AS t1 INNER JOIN TT_WORKS As t2 ON t1.works_id= t2.works_id INNER JOIN TM_ARTIST AS t3 ON t2.artist_id=t3.artist_id WHERE t1.user_id_cart = %d AND t1.cart_make_time >= "%s" AND t1.order_id IS NULL', $_SESSION['user_id'], $time_stamp);
	$record=NULL;
	$record=$db->query($sql);

	$html=NULL;
	$html.='<div id="cart-table" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
	$html.='<table border="1" padding="10">';
		$html.='<tr><th class="text-center" width="10%">作品ID</th><th class="text-center" width="10%">画像</th><th class="text-center" width="20%">作家</th><th class="text-center width="30%"">タイトル</th><th class="text-center width="25%">価格</th><th class="text-center width="5%"></th></tr>';

	$cart_num=0;
	while($data=$record->fetch(PDO::FETCH_ASSOC))
	{
		$html.='<form action="" method="post" name="frm_OrderCart">';
		$del='<input type="submit" name="delete_btn" id="delete_btn" value="削除" class="smallbutton" />';

		$html.=sprintf('<input type="hidden" name="works_id" id="works_id" value="%d"/>', $data['works_id']);
		$html.=sprintf('<tr><td class="text-center">%s</td><td><img src="%s"></td><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-right" style="padding:10px;">%s</td><td class="text-center">%s</td></tr>',
					 sprintf('A%08d',$data['works_id']),
					 $data['main_pic_small'],
					 $data['kanji_sei'].$data['kanji_mei'],
					 $data['title'],
					 '¥ '.number_format($data['price']),
					 $del
					 );	
		$html.='</form>';
		$cart_num=$cart_num+1;
	}

	$html.='</table>';
	$html.='</div>';

	//タイムスタンプを更新
	$time_stamp_now = date('Y-m-d H:i:s');
	$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET cart_make_time="%s" WHERE user_id_cart = %d AND cart_make_time >= "%s" AND order_id IS NULL',
				 $time_stamp_now,
				 $_SESSION['user_id'],
				 $time_stamp);
	$record=NULL;
	my_execute($db,$sql,$record);	
}


$_SESSION['order_cart_stamp']=$time_stamp_now;


$o_smarty->assign( 'artist_name', NULL);
$o_smarty->assign( 'metaproperty', NULL);

$params['html']=$html;
$params['cart_num']=$cart_num;
		   
$db=NULL;


//echo($_SESSION['order_start_hash']);


$params['message']=$message;
$o_smarty->assign( 'URL_GALLERY', $_SESSION['URL_GALLERY'] );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->assign( 'params', $params);
$o_smarty->display( 'template.tpl' );

?>