<?php

//////////////////////////////////////
// artist/workslist.php
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

// ひな形のSmartyテンプレートでincludeするテンプレートを指定
$o_smarty->default_modifiers=array('escape');
$o_smarty->assign('css_file','css/style_workslist.css');
$o_smarty->assign( 'head_tpl', 'head_none.tpl' );
$o_smarty->assign( 'header_tpl', 'header_menu.tpl' );


if(!empty($_SESSION['artist_id'])&&!empty($_SESSION['artist_pass']))
{
	$artist_id=$_SESSION['artist_id'];	

	$db = dbconnect();

	if(artist_login($_SESSION['artist_id'], $_SESSION['artist_pass'], $db)){


		if(!empty($_POST['newregist_btn']))
		{
			$sql = sprintf('INSERT INTO TT_WORKS SET artist_id=%d, title="新規作成", regist_time="%s"',
							$artist_id,
							date('Y-m-d H:i:s')
							);

			$record=NULL;
			my_execute($db,$sql,$record);
		}

		if(!empty($_POST['edit_btn']))
		{
			//一覧画面は戻るの対象
			$return_url= empty($_SERVER["HTTPS"]) ? "http://" : "https://";
			$return_url.=$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
			$_SESSION['RET_URL_WORKSLIST']=$return_url;

			$_SESSION['artist_id']=$_POST['artist_id'];
			$_SESSION['works_id']=$_POST['works_id'];
			header('Location:editworks.php');
			exit();
		}

		$page_group=10;

		
		if(empty($_GET['page']))
		{
			$v_page=1;
		}else{
			$v_page=htmlspecialchars($_GET['page'], ENT_QUOTES);
		}

		$i_page =intval($v_page);
		$_v_startpage = strval(($i_page*$page_group)-$page_group);

		
		//件数
		$sql = sprintf('SELECT COUNT(*) AS cnt FROM TT_WORKS WHERE artist_id=%d',
					$artist_id
					);
		$res = $db->query($sql);
		$CNT = $res->fetchColumn();
		

		$html='';
		$sql=sprintf("SELECT * FROM TT_WORKS WHERE artist_id=%d ORDER BY regist_time DESC LIMIT %d, %d",$artist_id,$_v_startpage,$page_group+1);
		$record=$db->query($sql);

		$count=1;
		$over=0;
		
		$html='<table border="1" padding="10">';
		$html.='<tr><th class="text-center" width="10%"></th>
		<th class="text-center" width="10%">ステータス</th>
		<th class="text-center" width="10%">TOP</th>
		<th class="text-center" width="10%">アップ画像</th>
		<th class="text-center" width="40%">タイトル</th>
		<th class="text-center" width="5%">注文数</th>
		<th class="text-center width="5%">在庫数</th>
		<th class="text-center" width="10%">登録日時</th></tr>
		';
		
		
		while($data=$record->fetch(PDO::FETCH_ASSOC))
		{
			if($count<=$page_group)
			{
				//注文数
				$sql2 =sprintf('SELECT COUNT(zaiko_seq_id) FROM TT_ORDER_WORKS AS t1 INNER JOIN TM_ORDER AS t2 ON t1.order_char = t2.order_char WHERE t1.works_id=%d',$data['works_id']);
				$res2 = $db->query($sql2);
				$CNT2 = $res2->fetchColumn();

				//在庫数
				$sql3 =sprintf('SELECT COUNT(seq_id) FROM TT_WORKS_ZAIKO WHERE order_id IS NULL AND works_id=%d',$data['works_id']);
				$res3 = $db->query($sql3);
				$CNT3 = $res3->fetchColumn();
				
				
				$html.='<form action="" method="post" name="">';
				$html.='<input type="hidden" name="artist_id" id="artist_id" value="'.$artist_id.'"/>';
				$html.='<input type="hidden" name="works_id" id="works_id" value="'.$data['works_id'].'"/>';

				if($data['open_flg']){
					$open_flg='公開中';
				}else{
					$open_flg='非公開';
				}
				
				if($data['top_open_flg']){
					$TOP_flg='TOP';
				}else{
					$TOP_flg='---';
				}
				
				if(!empty($data['main_pic'])){
					$mainpic=sprintf('<img src="%s">', $data['main_pic']);
				}else{
					$mainpic='no image';
				}
				
				$html.=sprintf('<tr><td class="text-center"><input type="submit" class="smallbutton" name="edit_btn" id="edit_btn" value="編集"/></td>
								<td class="text-center">%s</td>
								<td class="text-center">%s</td>
								<td class="text-center" style="padding:3px;">%s</td>
								<td class="text-left" style="padding:10px;">%s</td>
								<td class="text-right" style="padding:10px;">%s</td>
								<td class="text-right" style="padding:10px;">%s</td>
								<td class="text-center">%s</td>
								</tr>',
							 	$open_flg,
							 	$TOP_flg,
							    $mainpic,
							    $data['title'],
							    $CNT2,
							    $CNT3,
							    $data['regist_time']
							 	);					

				$html.='</form>';

				$count=$count+1;
			}else{
				$over=1;
				break;
			}
		}
		$html.='</table>';
		$record=NULL;

		$params['html']=$html;

		//ページング
		$paging=NULL;
		if($count>$page_group){

			if($page_group!=$CNT){

				if($i_page<2){
					$paging=sprintf('<a href="workslist.php?page=%d">',$i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
				}
				else{

					if($over){
						$paging=sprintf('<a href="workslist.php?page=%d">',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>'.sprintf('<a href="workslist.php?page=%d">',$i_page+1).'<span class="glyphicon glyphicon-chevron-right"></a>';
					}else{
						$paging=sprintf('<a href="workslist.php?page=%d">',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';			
					}
				}
			}
		}
		else{
			if($i_page>1){	
				$paging=sprintf('<a href="workslist.php?page=%d">',$i_page-1).'<span class="glyphicon glyphicon-chevron-left"></a>';
			}
		}
		$params['paging']=$paging;

		$o_smarty->assign( 'body_tpl', 'body_workslist.tpl' );
		$o_smarty->assign( 'params', $params );

	}else{
		$o_smarty->assign( 'header_tpl', 'header_none.tpl' );
		$o_smarty->assign( 'body_tpl', 'body_session_out.tpl' );
		$o_smarty->assign( 'params', NULL );
		$o_smarty->assign( 'footer_tpl', 'footer.tpl' );
		$o_smarty->display( 'template.tpl' );	
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