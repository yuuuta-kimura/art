<?php

//////////////////////////////////////
// artist/order_cancel.php
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
		
		
		//件数
		$sql = sprintf('SELECT COUNT(*) FROM TM_ORDER AS t1 INNER JOIN TT_ORDER_WORKS AS t2 ON t1.order_char = t2.order_char INNER JOIN TM_USER AS t3 ON t1.user_id = t3.user_id INNER JOIN TT_WORKS AS t4 ON t2.works_id = t4.works_id WHERE t1.cancel=1 AND t4.artist_id=%d',
					$artist_id
					);
		$res = $db->query($sql);
		$CNT = $res->fetchColumn();
		

		$html='';
		$sql=sprintf("SELECT t1.user_id, t1.order_char, t1.cancel, t1.cancel_time, t2.works_id, t2.title, t2.picture, t2.regist_time, t3.kanji_sei, t3.kanji_mei, t4.artist_id FROM TM_ORDER AS t1 INNER JOIN TT_ORDER_WORKS AS t2 ON t1.order_char = t2.order_char INNER JOIN TM_USER AS t3 ON t1.user_id = t3.user_id INNER JOIN TT_WORKS AS t4 ON t2.works_id = t4.works_id WHERE t1.cancel=1 AND t4.artist_id=%d ORDER BY t2.regist_time DESC LIMIT %d, %d",$artist_id,$_v_startpage,10);
				
		$record=$db->query($sql);

		$html=NULL;
		$html.='<div id="cart-table" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$html.='<table border="1" padding="10">';
			$html.='<tr><th class="text-center" width="10%">注文日時</th>
			<th class="text-center" width="10%">キャンセル日時</th>
			<th class="text-center" width="10%">キャンセル者</th>
			<th class="text-center" width="20%">注文番号</th>
			<th class="text-center" width="20%">作品番号</th>
			<th class="text-center" width="20%">タイトル</th>
			<th class="text-center" width="10%">画像</th>
			</tr>';
		
		$count=1;
		$over=0;
		while($data=$record->fetch(PDO::FETCH_ASSOC))
		{
			if($count<=$page_group)
			{
				$html.='<form action="" method="post" name="frm_OrderList">';
				$html.=sprintf('<tr><td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td><img src="%s"></td>
								</tr>',
							 	$data['regist_time'],
							 	$data['cancel_time'],
							    $data['kanji_sei'].' '.$data['kanji_mei'],
							 	$data['order_char'],
							 	$data['works_id'],
							 	$data['title'],
							 	$data['picture']
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

		$o_smarty->assign( 'body_tpl', 'body_order_cancel.tpl' );
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