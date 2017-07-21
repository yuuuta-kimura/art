<?php

//////////////////////////////////////
// user/order.php
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

$o_smarty=new MySmarty();
$params=array();

session_start();


$token=hash('sha256', session_id());

if(empty($_SESSION['token'])){
	$_SESSION['token']=$token;
}

if(empty($_POST['token'])){
	$o_smarty->assign( 'token', $token );
}else{
	$o_smarty->assign( 'token', $_POST['token']);	
}

//GET取得
if(!empty($_GET['artist_id'])){
	$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
}else{
	$artist_id=0;
}


//戻る
if(!empty($_POST['return_btn'])){
	header(sprintf('Location:order_cart.php?artist_id=%d',$artist_id));
	exit();	
}

$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style.css');
$o_smarty->assign( 'head_tpl', 'head_order.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
$o_smarty->assign( 'body_tpl', 'body_order.tpl' );
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

	
/////////////////////////////////
//カートを表示

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
while($data=$record->fetch(PDO::FETCH_ASSOC))
{
	$html.=sprintf('<tr><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-center">%s</td><td class="text-right" style="padding:10px;">%s</td></tr>',
				 sprintf('A%08d',$data['works_id']),
				 $data['kanji_sei'].$data['kanji_mei'],
				 $data['title'],
				 '¥ '.number_format($data['price'])
				 );	
	$small_sum+=intval($data['price']);
}
$html.='<tr><td></td><td></td><td class="text-right" style="padding:10px;">小計</td><td class="text-right" style="padding:10px;">'.'¥ '.number_format($small_sum).'</td></tr>';
$html.='<tr><td></td><td></td><td class="text-right" style="padding:10px;">消費税</td><td class="text-right" style="padding:10px;">'.'¥ '.number_format(round($small_sum*0.08)).'</td></tr>';
$html.='<tr><td></td><td></td><td class="text-right" style="padding:10px;">合計</td><td class="text-right" style="padding:10px;">'.'¥ '.number_format($small_sum + round($small_sum*0.08)).'</td></tr>';


$html.='</table>';
$html.='</div>';


$db=NULL;

$params['cart']=$html;


//有効期限（年）のセレクトメニュー装填
$today = date("Y");
$yy=substr($today,2,2);	
$slt_year="";

for ($i = 0; $i <= 30; $i++)
{
	$slt_year.=sprintf('<option value="%02d">%02d</option>',$yy+$i,$yy+$i);	
}

/////////////////////////////////
//リターンの送り先

$db = dbconnect();		
$sql=sprintf('SELECT * FROM TM_DELIVER_ADDR WHERE user_id=%d', $_SESSION['user_id']);
$record=NULL;
$record=$db->query($sql);
$data=$record->fetch(PDO::FETCH_ASSOC);
$db=NULL;		

//郵便番号
if(empty($data['post'])){
	$params['text_post_left']=NULL;$params['text_post_right']=NULL;
}else{
	$post_ar=array();
	$post_ar=explode('-', $data['post']);
	$params['text_post_left']=$post_ar[0];$params['text_post_right']=$post_ar[1];			
}

//都道府県
if(empty($data['prefecture'])){$params['slt_prefecture']=NULL;}
else{$params['slt_prefecture']=$data['prefecture'];}

//市町村
if(empty($data['city'])){$params['text_city']=NULL;}
else{$params['text_city']=$data['city'];}

//番地、マンション名など
if(empty($data['banchi'])){$params['text_banchi']=NULL;}
else{$params['text_banchi']=$data['banchi'];}

//宛名
if(empty($data['atena'])){$params['text_atena']=NULL;}
else{$params['text_atena']=$data['atena'];}

//TEL
if(empty($data['tel'])){
	$params['text_tel_left']=NULL;$params['text_tel_center']=NULL;$params['text_tel_right']=NULL;
}else{

	$tel_ar=array();
	$tel_ar=explode('-', $data['tel']);
	$params['text_tel_left']=$tel_ar[0];$params['text_tel_center']=$tel_ar[1];$params['text_tel_right']=$tel_ar[2];			
}

	
if(!$error && !empty($_POST['order_btn'])){

	/////////////////////////////////
	//注文
	
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
	if($error==0)
	{		
		$login_flg ='false';
		if (!empty($_SESSION['token']) && !empty($_POST['token'])) {
			if($_SESSION['token']==$_POST['token']){
				$login_flg ='true';	
			}else{$error=1;}	
		}else{$error=1;}
		
		$_SESSION['token']=NULL;
		if(!$error){
			
		//クレジットカードチェック
		if(empty($_POST['text_cardno']) || empty($_POST['slt_month']) || empty($_POST['slt_year']) || 
		empty($_POST['text_code'])){
			$error=1;
			$error_message.="クレジットカードの情報を認識できませんでした。もう一度ログインしなおしてお試しください。<BR>";
		}else
		{

			//リターン送り先チェック
			if(empty($_POST['text_post_left']) || empty($_POST['text_post_right']) || empty($_POST['slt_prefecture']) || 
			empty($_POST['text_city']) || empty($_POST['text_banchi']) || empty($_POST['text_atena']) || 
			empty($_POST['text_tel_left']) || empty($_POST['text_tel_center']) || empty($_POST['text_tel_right']))
			{
				$error=1;
				$error_message.="リターンのお送り先を認識できませんでした。もう一度ログインしなおしてお試しください。<BR>";
			}else
			{

				//新規登録か更新かチェック
				$deliver_num=0;
				$db = dbconnect();
				$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_DELIVER_ADDR WHERE user_id=%d', $_SESSION['user_id']);
				$res = $db->query($sql);
				$deliver_num=$res->fetchColumn();
				$db=NULL;

				if($deliver_num>0){
					//更新
					$db = dbconnect();
					
					/*
					$sql = sprintf('UPDATE TM_DELIVER_ADDR SET post="%s", prefecture=%s, city=%s, banchi=%s, atena=%s, tel="%s", update_time="%s" WHERE user_id=%d',
									$_POST['text_post_left'].'-'.$_POST['text_post_right'],
									$db->quote($_POST['slt_prefecture']),$db->quote($_POST['text_city']),
									$db->quote($_POST['text_banchi']),$db->quote($_POST['text_atena']),
									$_POST['text_tel_left'].'-'.$_POST['text_tel_center'].'-'.$_POST['text_tel_right'],
									date('Y-m-d H:i:s'),
									$_SESSION['user_id']
									);
					$record=NULL;
					*/
					
					$sql = sprintf('UPDATE TM_DELIVER_ADDR SET post=?, prefecture=?, city=?, banchi=?, atena=?, tel=?, update_time="%s" WHERE user_id=%d',
									date('Y-m-d H:i:s'),
									$_SESSION['user_id']
									);
					$stmt = $db->prepare($sql);
					$postnumber = $_POST['text_post_left'].'-'.$_POST['text_post_right'];
					$tellnumber = $_POST['text_tel_left'].'-'.$_POST['text_tel_center'].'-'.$_POST['text_tel_right'];
					$stmt->bindParam(1, $postnumber, PDO::PARAM_STR);
					$stmt->bindParam(2, $_POST['slt_prefecture'], PDO::PARAM_STR);
					$stmt->bindParam(3, $_POST['text_city'], PDO::PARAM_STR);
					$stmt->bindParam(4, $_POST['text_banchi'], PDO::PARAM_STR);
					$stmt->bindParam(5, $_POST['text_atena'], PDO::PARAM_STR);
					$stmt->bindParam(6, $tellnumber, PDO::PARAM_STR);
					
					//if(!my_execute($db,$sql,$record)){
					if(!$stmt->execute()){
						$error=1;
						$error_message.="リターンのお送り先の更新に失敗しました。もう一度ログインしなおしてお試しください。<BR>";
					}
					$db=NULL;

				}else{

					//新規登録

					$db = dbconnect();
					/*
					$sql = sprintf('INSERT INTO TM_DELIVER_ADDR SET user_id=%d, post="%s", prefecture=%s, city=%s, banchi=%s, atena=%s, tel="%s", regist_time="%s", update_time="%s"',
									$_SESSION['user_id'],
									$_POST['text_post_left'].'-'.$_POST['text_post_right'],
									$db->quote($_POST['slt_prefecture']),$db->quote($_POST['text_city']),
									$db->quote($_POST['text_banchi']),$db->quote($_POST['text_atena']),
									$_POST['text_tel_left'].'-'.$_POST['text_tel_center'].'-'.$_POST['text_tel_right'],
									date('Y-m-d H:i:s'),date('Y-m-d H:i:s')
									);
					$record=NULL;
					*/

					$sql = sprintf('INSERT INTO TM_DELIVER_ADDR SET user_id=%d, post=?, prefecture=?, city=?, banchi=?, atena=?, tel=?, regist_time="%s", update_time="%s"',
									$_SESSION['user_id'],
									date('Y-m-d H:i:s'),
								    date('Y-m-d H:i:s')
									);					
					$stmt = $db->prepare($sql);
					$postnumber = $_POST['text_post_left'].'-'.$_POST['text_post_right'];
					$tellnumber = $_POST['text_tel_left'].'-'.$_POST['text_tel_center'].'-'.$_POST['text_tel_right'];
					$stmt->bindParam(1, $postnumber, PDO::PARAM_STR);
					$stmt->bindParam(2, $_POST['slt_prefecture'], PDO::PARAM_STR);
					$stmt->bindParam(3, $_POST['text_city'], PDO::PARAM_STR);
					$stmt->bindParam(4, $_POST['text_banchi'], PDO::PARAM_STR);
					$stmt->bindParam(5, $_POST['text_atena'], PDO::PARAM_STR);
					$stmt->bindParam(6, $tellnumber, PDO::PARAM_STR);

					
					//if(!my_execute($db,$sql,$record)){
					if(!$stmt->execute()){
						$error=1;
						$error_message.="リターンのお送り先の登録に失敗しました。もう一度ログインしなおしてお試しください。<BR>";
					}
					$db=NULL;
				}
				if(!$error){
					$_SESSION['text_cardno']=$_POST['text_cardno'];$_SESSION['slt_month']=$_POST['slt_month'];
					$_SESSION['slt_year']=$_POST['slt_year'];$_SESSION['text_code']=$_POST['text_code'];				
					$_SESSION['text_post_left']=$_POST['text_post_left'];$_SESSION['text_post_right']=$_POST['text_post_right'];
					$_SESSION['slt_prefecture']=$_POST['slt_prefecture'];$_SESSION['text_city']=$_POST['text_city'];
					$_SESSION['text_banchi']=$_POST['text_banchi'];$_SESSION['text_atena']=$_POST['text_atena'];
					$_SESSION['text_tel_left']=$_POST['text_tel_left'];$_SESSION['text_tel_center']=$_POST['text_tel_center'];
					$_SESSION['text_tel_right']=$_POST['text_tel_right'];
				}

				/////////////////////////			
				//次の確認画面に遷移			
				header('Location:order_check.php?artist_id='.$artist_id);
				exit;
			}
		}		
	}
	}	
}

//タイムスタンプを更新
$db = dbconnect();
$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET cart_make_time="%s" WHERE user_id_cart = %d AND cart_make_time >= "%s" AND order_id IS NULL',
			 date('Y-m-d H:i:s'),
			 $_SESSION['user_id'],
			 $time_stamp);
$record=NULL;
my_execute($db,$sql,$record);
$db=NULL;

if($error){
	$params['price']=NULL;$params['text_post_left']=NULL;
	$params['text_post_right']=NULL;$params['slt_prefecture']=NULL;$params['text_city']=NULL;
	$params['text_banchi']=NULL;$params['text_atena']=NULL;$params['text_tel_left']=NULL;
	$params['text_tel_center']=NULL;$params['text_tel_right']=NULL;$slt_year=NULL;
}


//echo($_SESSION['order_start_hash']);


$params['error_message']=$error_message;
$o_smarty->assign( 'artist_name', NULL);
$o_smarty->assign( 'metaproperty', NULL);
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'URL_GALLERY', $_SESSION['URL_GALLERY'] );
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'params', $params );
$o_smarty->assign( 'error', $error );
$o_smarty->assign( 'slt_year', $slt_year );
$o_smarty->display( 'template.tpl' );


?>

