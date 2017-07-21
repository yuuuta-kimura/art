<?php

//////////////////////////////////////
// user/artist_work.php
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
$o_smarty->assign( 'body_tpl', 'body_artist_work.tpl' );
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );


//GET取得
if(!empty($_GET['artist_id'])){
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}else{
	$artist_id=0;
}
if(!empty($_GET['works_id'])){
	$works_id=htmlspecialchars($_GET['works_id'], ENT_QUOTES);
}else{
	$works_id=0;
}
if(!empty($_GET['page'])){
	$page=htmlspecialchars($_GET['page'], ENT_QUOTES);//戻るときのページ位置
}else{
	$page=0;
}


$return_url= empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$return_url.=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$_SESSION['RET_URL_USER']=$return_url;

$message=NULL;

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

//カートに入れるボタンクリック
if(!empty($_POST['cart_btn'])){

	if($login_flg=='yes')
	{
		$db = dbconnect();

		//先にカートに入れた人のタイムスタンプから待機時間を含めて、比較できる用のタイムスタンプ作成
		$time_stamp=date('Y-m-d H:i:s', strtotime(sprintf('-%d minute',$ini['ORDER_WAIT_MINUTE'])));

		//在庫の取得
		
		$sql=sprintf('SELECT seq_id FROM TT_WORKS_ZAIKO WHERE works_id=? AND cart_make_time < "%s" AND order_id IS NULL', $time_stamp);
		$stmt = $db->prepare($sql);
		$stmt->bindParam(1, $works_id, PDO::PARAM_INT);	
		$stmt->execute();		
		$data=$stmt->fetch(PDO::FETCH_ASSOC);
		
		$db=NULL;

		if(!empty($data['seq_id']))
		{
			$seq_id=$data['seq_id'];
			$db = dbconnect();
			$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET user_id_cart=%d, cart_make_time="%s" WHERE seq_id=%d AND order_id IS NULL',
						 $_SESSION['user_id'],
						 date('Y-m-d H:i:s'),
						$seq_id);	
			
			$record=NULL;
			my_execute($db,$sql,$record);
			$db=NULL;
			header(sprintf('Location:order_cart.php?artist_id=%d',$artist_id));
			exit();		
		}
		else
		{
			$message='申し訳ありません。注文があり在庫が無くなりました。';
		}		
	}
	else
	{
		header('Location:user_login.php');	
		exit();			
	}
}

//戻るボタンクリック
if(!empty($_POST['return_btn'])){
	header(sprintf('Location:gallery.php?artist_id=%d&page=%d',$artist_id,$page));
	exit();
}


$db = dbconnect();

//作品情報の取得

$sql='SELECT * FROM TT_WORKS WHERE works_id =?';
$stmt = $db->prepare($sql);
$stmt->bindParam(1, $works_id, PDO::PARAM_INT);	
$stmt->execute();		
$data=$stmt->fetch(PDO::FETCH_ASSOC);


$og_title=$data['title'];
$og_description = mb_substr($data['comment'],0,20);
$og_main_pic =$data['main_pic'];
$og_main_pic_small =$data['main_pic_small'];
$artist_id=$data['artist_id'];
$og_size_width = $data['size_width'];
$og_size_height = $data['size_height'];
$og_tech = $data['tech'];
$og_tech_other = $data['tech_other'];
$og_base = $data['base'];
$og_base_other = $data['base_other'];
$og_comment = $data['comment'];
$og_price = $data['price'];


//先にカートに入れた人のタイムスタンプから待機時間を含めて、比較できる用のタイムスタンプ作成
$time_stamp=date('Y-m-d H:i:s', strtotime(sprintf('-%d minute',$ini['ORDER_WAIT_MINUTE'])));

//在庫の取得

$sql=sprintf('SELECT COUNT(*) AS cnt FROM TT_WORKS_ZAIKO WHERE works_id=? AND cart_make_time < "%s" AND order_id IS NULL',
$time_stamp);
$stmt = $db->prepare($sql);
$stmt->bindParam(1, $works_id, PDO::PARAM_INT);	
$stmt->execute();		
$zaiko_num=$stmt->fetchColumn();


$mycart_num=0;
$myorder_num=0;

$time_stamp2=date('Y-m-d H:i:s', strtotime(sprintf('-%d minute',$ini['ORDER_LIMIT_MINUTE'])));

if(!empty($_SESSION['user_id'])){
		
	//カートに入れているかチェック（複数個の注文は同時にできない）
	
	$sql=sprintf('SELECT COUNT(*) AS cnt FROM TT_WORKS_ZAIKO WHERE works_id=? AND user_id_cart=%d AND cart_make_time >= "%s" AND order_id IS NULL', $_SESSION['user_id'], $time_stamp);
	$stmt = $db->prepare($sql);
	$stmt->bindParam(1, $works_id, PDO::PARAM_INT);	
	$stmt->execute();		
	$mycart_num=$stmt->fetchColumn();
		
	$sql=sprintf('SELECT COUNT(*) AS cnt FROM TT_WORKS_ZAIKO WHERE works_id=? AND user_id_cart=%d AND order_id IS NOT NULL', $_SESSION['user_id']);
	$stmt = $db->prepare($sql);
	$stmt->bindParam(1, $works_id, PDO::PARAM_INT);	
	$stmt->execute();		
	$myorder_num=$stmt->fetchColumn();
	
}


//アーティスト情報の取得

$sql='SELECT * FROM TM_ARTIST WHERE artist_id = ?';
$stmt = $db->prepare($sql);
$stmt->bindParam(1, $artist_id, PDO::PARAM_INT);	
$stmt->execute();		
$data=$stmt->fetch(PDO::FETCH_ASSOC);
$og_artist_name = $data['kanji_sei'].' '.$data['kanji_mei'];

$head=sprintf('
	<meta property="og:site_name" content="%s e-ART" />
	<meta property="og:title" content="%s | %s" />
	<meta property="og:type" content="article" >
	<meta property="og:description" content="powerd by e-ART.tokyo" />
	<meta property="og:url" content="http://e-art.tokyo/user/artist_work.php?works_id=%d" />
	<meta property="og:image" content="%s" />
	<meta name="twitter:card" content="photo" />
	<meta name="twitter:site" content="@e-ART.tokyo" />
	<meta name="twitter:title" content="%s" />
	<meta name="twitter:description" content="%s" />
	<meta name="twitter:image" content="%s" />
	<meta name="twitter:url" content="content="http://e-art.tokyo/user/artist_work.php?works_id=%d" />
	<meta property="fb:app_id" content="637949606391326" />
	'			  
	,$og_artist_name
	,$og_title
	,$og_artist_name
	,$works_id
	,$og_main_pic_small
	,$og_artist_name
	,$og_title
	,$og_main_pic_small
	,$works_id
);

$o_smarty->assign( 'artist_name', $og_artist_name);
$o_smarty->assign( 'metaproperty', $head );

$html='';
$html.='<input type="hidden" name="artist_id" id="artist_id" value="'.$artist_id.'"/>'.PHP_EOL;
$html.='<input type="hidden" name="works_id" id="works_id" value="'.$works_id.'"/>'.PHP_EOL;

$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">'.PHP_EOL;

	if(!empty($og_main_pic)){
		$html.=sprintf('<div id="artist_mainpic"><img src="%s" class="artist_mainpic"></div>',$og_main_pic).PHP_EOL;
		//$html.=sprintf('<a href="%s" data-lity><img src="%s"></a>',$data['main_pic'],$data['main_pic']);

		//$html.=sprintf('<a href="%s"><img src="%s" alt="image"></a>',$og_main_pic,$og_main_pic);


	}else{
		$html.='<div id="nopicture">no image</div>'.PHP_EOL;
	}

$html.='</div>'.PHP_EOL;

$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;

	$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">'.PHP_EOL;
		$html.='作品ID '. sprintf('A%08d',$works_id).PHP_EOL;
	$html.='</div>'.PHP_EOL;

	$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
		$html.='<span class="glyphicon glyphicon-picture"></span> '.$og_title.PHP_EOL;
	$html.='</div>'.PHP_EOL;


	$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
		$html.='<div style="float:left;">'.PHP_EOL;
		$html.='<span class="glyphicon glyphicon-resize-horizontal"></span> '.PHP_EOL;
		$html.='幅 '.$og_size_width.'cm'.PHP_EOL;
		$html.='</div>'.PHP_EOL;

		$html.='<div style="float:left; margin-left:5px;">'.PHP_EOL;
		$html.='<span class="glyphicon glyphicon-resize-vertical"></span> '.PHP_EOL;
		$html.='高さ '.$og_size_height.'cm'.PHP_EOL;
		$html.='</div>'.PHP_EOL;
	$html.='</div>'.PHP_EOL;

	$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
		$html.='<span class="glyphicon glyphicon-pencil"></span> '.PHP_EOL;
		//$html.='技法 ';			
		switch ($og_tech)
		{
		case 1: 
			$html.='油画'.PHP_EOL; break;
		case 2:
			$html.='水彩画'.PHP_EOL; break;
		case 3:
			$html.='アクリル画'.PHP_EOL; break;
		case 4:
			$html.='鉛筆・ペン画'.PHP_EOL; break;
		case 5:
			$html.='クレヨン画'.PHP_EOL; break;
		case 6:
			$html.='水墨画'.PHP_EOL; break;
		case 7:
			$html.='書道'.PHP_EOL; break;
		case 8:
			$html.='木版画'.PHP_EOL; break;
		case 9:
			$html.='リトグラフ'.PHP_EOL; break;
		case 10:
			$html.='銅板画'.PHP_EOL; break;
		case 11:
			$html.='シルクスクリーン'.PHP_EOL; break;
		case 12:
			$html.='デジタルアート'.PHP_EOL; break;				
		}

		$html.=$og_tech_other;
	$html.='</div>'.PHP_EOL;

	$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
		$html.='<span class="glyphicon glyphicon-file"></span> '.PHP_EOL;
		//$html.='支持体 ';			
		switch ($og_base)
		{
			case 1:
				$html.='布'.PHP_EOL; break;
			case 2:
				$html.='紙'.PHP_EOL; break;
			case 3:
				$html.='木'.PHP_EOL; break;
		}
		$html.=$og_base_other;
	$html.='</div>'.PHP_EOL;

	if($og_price>0)
	{
		$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
			$html.='¥ '.number_format($og_price).PHP_EOL;
		$html.='</div>'.PHP_EOL;

		$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
			$html.='在庫 '.intval($zaiko_num).'個'.PHP_EOL;
		$html.='</div>'.PHP_EOL;		
	}


	$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
		$html.=nl2br($og_comment);
	$html.='</div>'.PHP_EOL;


$html.='</div>'.PHP_EOL;	

$params['price']=$og_price;
$params['html']=$html;
$params['works_id']=$works_id;
$params['page']=$page;
$params['message']=$message;

$db=NULL;

$o_smarty->assign( 'artist_id', $artist_id);
$o_smarty->assign( 'ZAIKO', intval($zaiko_num));
$o_smarty->assign( 'MYCART', intval($mycart_num));
$o_smarty->assign( 'MYORDER', intval($myorder_num));

if(!empty($_SESSION['URL_GALLERY'])){
	$o_smarty->assign( 'URL_GALLERY', $_SESSION['URL_GALLERY'] );
}else{
	$o_smarty->assign( 'URL_GALLERY', NULL );	
}

$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->assign( 'params', $params);
$o_smarty->display( 'template.tpl' );

?>