<?php

//////////////////////////////////////
// artist/order_list.php
//////////////////////////////////////


ini_set("display_errors",1);
error_reporting(E_ALL);

require('dbconnect.php');
require('pdosql.php');
require('func_login_artist.php');

session_start();

require_once("MySmarty.class.php");
$o_smarty=new MySmarty();
$params=array();

// ひな形のSmartyテンプレ
//ートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_workslist.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );


if(!empty($_SESSION['artist_id'])&&!empty($_SESSION['artist_pass']))
{
	$artist_id=$_SESSION['artist_id'];	

	$db = dbconnect();

	if(artist_login($_SESSION['artist_id'], $_SESSION['artist_pass'], $db))
	{

		//ページ数取得
		if(empty($_GET['page']))
		{
			$v_page=1;
		}else{
			$v_page=htmlspecialchars($_GET['page'], ENT_QUOTES);
		}

		$page_group=10;
		
		$i_page =intval($v_page);
		$_v_startpage = strval(($i_page*$page_group)-$page_group);

		
		//発送ボタン
		if(!empty($_POST['detail_btn']))
		{
			if(!empty($_POST['seq_id']))
			{
				header(sprintf('Location:order_detail.php?seq_id=%d&page=%d', $_POST['seq_id'], $v_page));		
				exit();
			}
		}
		
		
		//件数
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM vw_order_list WHERE artist_id=%d',
					$artist_id
					);
		$res = $db->query($sql);
		$CNT = $res->fetchColumn();
		

		$html='';
		$sql=sprintf("SELECT * FROM vw_order_list WHERE artist_id=%d ORDER BY regist_time DESC LIMIT %d, %d",$artist_id,$_v_startpage,10);
		$record=$db->query($sql);

		
		
		$html=NULL;
		$html.='<div id="cart-table" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$html.='<table border="1" padding="10">';
			$html.='<tr><th class="text-center" width="10%">注文日時</th>
			<th class="text-center" width="10%">受注処理日時</th>
			<th class="text-center" width="10%">発送処理日時</th>
			<th class="text-center" width="20%">注文番号</th>
			<th class="text-center" width="10%">画像</th>
			<th class="text-center width="10%">注文価格</th>
			<th class="text-center width="10%">現在価格</th>
			<th class="text-center width="10%"></th></tr>';
		
		$count=1;
		$over=0;
		while($data=$record->fetch(PDO::FETCH_ASSOC))
		{
			if($count<=$page_group)
			{
				$html.='<form action="" method="post" name="frm_OrderList">';
				$html.=sprintf('<input type="hidden" name="seq_id" id="seq_id" value="%d"/>', $data['seq_id']);
				if(empty($data['receive_time'])){
					$detail='<input type="submit" name="detail_btn" id="detail_btn" value="受注確定" class="smallbutton" style="color:#FF0000"/>';
				}else{
					if(empty($data['send_time'])){
						$detail='<input type="submit" name="detail_btn" id="detail_btn" value="発送" class="smallbutton" style="color:#FF0000"/>';
					}else{
						$detail='<input type="submit" name="detail_btn" id="detail_btn" value="発送済" class="smallbutton"  style="color:#00FF00" /';	
					}
				}

				$html.=sprintf('<tr><td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td><img src="%s"></td>
								<td class="text-right" style="padding:10px;">%s</td>
								<td class="text-right" style="padding:10px;">%s</td>
								<td class="text-center">%s</td></tr>',
							 	$data['regist_time'],
							 	$data['receive_time'],
							    $data['send_time'],
							 	$data['order_char'],
							 	$data['main_pic_small'],
							 	'¥ '.number_format($data['price']),
							 	'¥ '.number_format($data['now_price']),
							 	$detail
							 	);	
				$html.='</form>';

				$count=$count+1;
			}else{
				$over=$over+1;
			}
		}
		$record=NULL;		
		
		$html.='</table>';
		$html.='</div>';
	
		
		$params['html']=$html;

		//ページング
		$paging=NULL;
		if($count>$page_group){
			
			if($page_group!=$CNT)
			{
				if($i_page<2){
					$paging=sprintf('<a href="order_list.php?page=%d">',$i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
				}
				else{
					if($over){
						$paging=sprintf('<a href="order_list.php?page=%d">',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>'.sprintf('<a href="order_list.php?page=%d">',$i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
					}else{
						$paging=sprintf('<a href="order_list.php?page=%d">',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';			
					}
				}				
			}
		}
		else{
			if($i_page>1){	
				$paging=sprintf('<a href="order_list.php?page=%d">',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';
			}
		}
		$params['paging']=$paging;

		$o_smarty->assign( 'body_tpl', 'body_order_list.tpl' );
		$o_smarty->assign( 'params', $params );

	}else{
		$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
		$o_smarty->assign( 'body_tpl', 'body_session_out.tpl' );
		$o_smarty->assign( 'params', NULL );
	}
	$db=NULL;		

	$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
	$o_smarty->display( 'template.tpl' );


}else{
	$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
	$o_smarty->assign( 'body_tpl', 'body_session_out.tpl' );
	$o_smarty->assign( 'params', NULL );
	$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
	$o_smarty->display( 'template.tpl' );	
}


?>