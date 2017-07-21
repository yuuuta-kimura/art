<?php

//////////////////////////////////////
// artist/order_detail.php
//////////////////////////////////////


ini_set("display_errors",1);
$ini = parse_ini_file('config.ini');

if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('func_login_artist.php');

session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$params=array();
$message='';

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_workslist.css');
$o_smarty->assign( 'head_tpl', 'head_order_detail.tpl' );
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );


//ログインチェック
$login_flg="";
$artist_id=NULL;
$seq_id=NULL;
$send=NULL;
if(!empty($_SESSION['artist_id'])&&!empty($_SESSION['artist_pass']))
{
	$artist_id=$_SESSION['artist_id'];	
	$db = dbconnect();
	if(artist_login($_SESSION['artist_id'], $_SESSION['artist_pass'], $db))
	{
		$login_flg="yes";
		$artist_id=$_SESSION['artist_id'];
		$seq_id=htmlspecialchars($_GET['seq_id'], ENT_QUOTES);
	}
	$db=NULL;		
}

//ページ数取得
if(empty($_GET['page']))
{
	$v_page=1;
}else{
	$v_page=htmlspecialchars($_GET['page'], ENT_QUOTES);
}	

if(!empty($_POST['return_btn'])){
	header(sprintf('Location:order_list.php?artist_id=%d&page=%d',$artist_id, $v_page));
	exit();	
}


if($login_flg=='yes')
{
	//受注確定
	if(!empty($_POST['receive_btn']))
	{
		$db = dbconnect();
		
		$sql=sprintf("SELECT first_receive_time, receive_time, order_char FROM vw_order_list WHERE artist_id=%d AND seq_id=%d ",$artist_id,$seq_id);	
		$record=$db->query($sql);
		$data=$record->fetch(PDO::FETCH_ASSOC);
		
		
		$db = NULL;

		
		if(!empty($data['order_char']) && empty($data['receive_time']))
		{
			
			$order_char = $data['order_char'];
			$first_receive_time = $data['first_receive_time'];
			$receive_time = $data['receive_time'];
			
			$db = dbconnect();
			
			//注文データに、受注のタイムスタンプ
			$sql=sprintf('UPDATE TM_ORDER SET first_receive_time="%s" WHERE order_char="%s"',
						 date('Y-m-d H:i:s'),
						 $order_char
						);
			$record=NULL;
			my_execute($db,$sql,$record);			

			
			//在庫データに、受注のタイムスタンプ
			$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET receive_time="%s" WHERE seq_id=%d',
						 date('Y-m-d H:i:s'),
						 $seq_id
						);
			$record=NULL;
			my_execute($db,$sql,$record);
			
			$db = NULL;
			
			header(sprintf('Location:order_list.php?artist_id=%d&page=%d',$artist_id, $v_page));
			exit();				
			
		}
		else
		{
			$message = '画面を開いている間に、注文がキャンセルされました';	
		}		
	}
	
	//発送
	if(!empty($_POST['send_btn']))	
	{
		$db = dbconnect();
		
		//在庫データに、発送のタイムスタンプ
		$sql=sprintf('UPDATE TT_WORKS_ZAIKO SET send_time="%s" WHERE seq_id=%d',
					 date('Y-m-d H:i:s'),
					 $seq_id
					);
		$record=NULL;
		my_execute($db,$sql,$record);
		
		//注文データに、発送のタイムスタンプ
		$sql=sprintf('UPDATE TT_ORDER_WORKS SET send_time="%s" WHERE zaiko_seq_id=%d',
					 date('Y-m-d H:i:s'),
					 $seq_id
					);
		$record=NULL;
		my_execute($db,$sql,$record);
		
		$db = NULL;
		
		header(sprintf('Location:order_list.php?artist_id=%d&page=%d',$artist_id, $v_page));
		exit();	
		
	}
	
	$db = dbconnect();

	$sql=sprintf("SELECT * FROM vw_order_list WHERE artist_id=%d AND seq_id=%d ORDER BY regist_time ",$artist_id,$seq_id);	
	$record=$db->query($sql);
	$data=$record->fetch(PDO::FETCH_ASSOC);

	$db=NULL;

	$receive=NULL;
	$receivelimit=NULL;
		
	if(!empty($data['receive_time'])){
		$receive = 'yes';		
	}else{		
		//本画面にアクセスしてからORDER_LIMIT_MINUTE分を経過していたら、キャンセル可能		
		if(  strtotime(date('Y-m-d H:i:s'))  > strtotime(sprintf('+%d minute',$ini['ORDER_LIMIT_CANCEL_MINUTES']), strtotime(date($data['regist_time']))) )
		{
			$receivelimit='yes';
		}
	}
	$send=NULL;
	if(!empty($data['send_time'])){
		$send = 'yes';
	}
	
	$html='';
	
	if(!empty($data['order_char'])){
		
		
		$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='受注確定日時: '. $data['receive_time'].PHP_EOL;
		$html.='</div>'.PHP_EOL;

		$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='発送日時: '. $data['send_time'].PHP_EOL;
		$html.='</div>'.PHP_EOL;


		$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;

			if(!empty($data['main_pic'])){
				$html.=sprintf('<div id="artist_mainpic"><img src="%s" class="artist_mainpic"></div>',$data['main_pic']).PHP_EOL;
			}
			else
			{
				$html.='<div id="nopicture">no image</div>'.PHP_EOL;
			}

		$html.='</div>'.PHP_EOL;

		$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">'.PHP_EOL;
				$html.='作品ID: '. sprintf('A%08d',$data['works_id']).PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='<span class="glyphicon glyphicon-picture"></span> '.$data['title'].PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='¥ '.number_format($data['price']).PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='注文者氏名: '.$data['kanji_sei'].' '.$data['kanji_mei'].PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='ふりがな: '.$data['kana_sei'].' '.$data['kana_mei'].PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='郵便番号: '.$data['post'].PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='住所: '.$data['prefecture'].$data['city'].$data['banchi'].PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='送り先宛名: '.$data['atena'].PHP_EOL;
			$html.='</div>'.PHP_EOL;

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:30px;">'.PHP_EOL;
				$html.='電話番号: '.$data['tel'].PHP_EOL;
			$html.='</div>'.PHP_EOL;	

		$html.='</div>'.PHP_EOL;	
	}else{
		$message='画面を開いている間に、キャンセルが行なわれました';
	}
	
	$params['html']=$html;
	$params['message']=$message;
	$params['receive']=$receive;
	$params['send']=$send;
	$params['receivelimit']=$receivelimit;
		
	$o_smarty->assign( 'body_tpl', 'body_order_detail.tpl' );
	$o_smarty->assign( 'params', $params );
	$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
	$o_smarty->display( 'template.tpl' );	
}
else	
{
	$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
	$o_smarty->assign( 'body_tpl', 'body_session_out.tpl' );
	$o_smarty->assign( 'params', NULL );
	$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
	$o_smarty->display( 'template.tpl' );		
}


?>