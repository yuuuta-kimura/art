<?php

//////////////////////////////////////
// user/order_list.php
//////////////////////////////////////


$ini = parse_ini_file('config.ini');
if($ini['DEBUG_MODE']==1){
ini_set("display_errors",1);
error_reporting(E_ALL);
}

require('dbconnect.php');
require('pdosql.php');
require('func_login_user.php');

session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$params=array();

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_gallery.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_none.tpl' );


$artist_id=htmlspecialchars($_GET['artist_id'], ENT_QUOTES);
	
if(empty($_GET['page']))
{
	$v_page=1;
}else{
	$v_page=htmlspecialchars($_GET['page'], ENT_QUOTES);
}

$page_group=10;

$i_page =intval($v_page);
$_v_startpage = strval(($i_page*$page_group)-$page_group);



$return_url= empty($_SERVER["HTTPS"]) ? "http://" : "https://";
$return_url.=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$_SESSION['RET_URL_USER']=$return_url;
$_SESSION['URL_GALLERY']=$return_url;


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

if($login_flg=='yes')
{
	if(!empty($_POST['detail_btn']))
	{
		$order_char=htmlspecialchars($_POST['order_char'], ENT_QUOTES);
		if(!empty($order_char))
		{
			header(sprintf('Location:order_detail.php?order_char=%s&artist_id=%d&page=%d',$order_char, $artist_id, $i_page));
			exit();			
		}
	}
		
	$db = dbconnect();

	$o_smarty->assign( 'artist_name', NULL);
	$o_smarty->assign( 'metaproperty', NULL);


	//件数
	$sql = sprintf('SELECT COUNT(*) AS cnt FROM TM_ORDER WHERE user_id=%d',$_SESSION['user_id']);
	$record=NULL;
	$record=$db->query($sql);
	$CNT=$record->fetchColumn();

	
	$html='';
	$sql=sprintf("SELECT * FROM TM_ORDER WHERE user_id=%d ORDER BY regist_time DESC LIMIT %d, %d",
				 $_SESSION['user_id'],
				 $_v_startpage,
				 10
				);
	
	$record=$db->query($sql);

	$count=1;
	$over=0;


	$today = new DateTime();

	while($data=$record->fetch(PDO::FETCH_ASSOC))
	{
		if($count<=$page_group)
		{

			$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$html.='<form action="" method="post" name="frm_OrderList">';
			$html.=sprintf('<input type="hidden" name="order_char" id="order_char" value="%s"/>', $data['order_char']);

				$html.='<div>【注文番号】'.$data['order_char'].'</div>';
				$html.='<div>【注文金額】'.'¥ '.number_format($data['all_sum_price']).'</div>';
				$html.='<div>【注文日時】'.$data['regist_time'].'</div>';
				if(!empty($data['cancel_time'])){
					$html.='<div class="text-danger">【キャンセル日時】'.$data['cancel_time'].'</div>';
				}
			
				$html.='　<input type="submit" name="detail_btn" id="detail_btn" value="詳細" class="smallbutton" />';

				$html.='<div"><hr/></div>';

			$html.='</form>';
			$html.='</div>';


			$count=$count+1;

		}else{
			//$over=$over+1;
			$over=1;
			break;
		}
	}


	$record=NULL;

	$params['html']=$html;

	//ページング
	$paging=NULL;
	if($count>=$page_group){

		if($page_group!=$CNT)
		{
			if($i_page<2){
				$paging=sprintf('<a href="order_list.php?artist_id=%d&page=%d">',$artist_id, $i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
			}
			else{

				if($over){
					$paging=sprintf('<a href="order_list.php?artist_id=%d&page=%d">',$artist_id, $i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>'.sprintf('<a href="order_list.php?artist_id=%d&page=%d">',$artist_id, $i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
				}else{
					$paging=sprintf('<a href="order_list.php?artist_id=%d&page=%d">',$artist_id, $i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';			
				}
			}		
		}

	}
	else{
		if($i_page>1){	
			$paging=sprintf('<a href="order_list.php?artist_id=%d&page=%d">',$artist_id, $i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';
		}
	}

	$db=NULL;		
	$params['paging']=$paging;

	
}else{
	$params=NULL;	
}

$o_smarty->assign( 'params', $params );
$o_smarty->assign( 'URL_GALLERY', $_SESSION['URL_GALLERY'] );
$o_smarty->assign( 'artist_id', $artist_id );
$o_smarty->assign( 'body_tpl', 'body_gallery.tpl' );
$o_smarty->assign( 'login_flg', $login_flg );
$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
$o_smarty->display( 'template.tpl' );


?>