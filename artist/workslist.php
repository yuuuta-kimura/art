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
		while($data=$record->fetch(PDO::FETCH_ASSOC))
		{
			if($count<=$page_group)
			{

				$html.='<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">';
				$html.='<form action="" method="post" name="">';
				$html.='<input type="hidden" name="artist_id" id="artist_id" value="'.$artist_id.'"/>';
				$html.='<input type="hidden" name="works_id" id="works_id" value="'.$data['works_id'].'"/>';
				$html.='<div style="float:left; margin:0 10px 0 0;">';
				$html.='<input type="submit" class="smallbutton" name="edit_btn" id="edit_btn" value="編集"/>';
				$html.='</div>';	

				if($data['open_flg']){
					$html.='<div style="float:left; margin:0 10px 0 0; width:40px;">';
					$html.='<font color="red">公開中</font>';
					$html.='</div>';
				}else{
					$html.='<div style="float:left; margin:0 10px 0 0; width:40px;">';
					$html.='非公開';
					$html.='</div>';
				}
				
				if($data['top_open_flg']){
					$html.='<div style="float:left; width:40px;">TOP</div>';
				}else{
					$html.='<div style="float:left; width:40px;">---</div>';
				}

				
				$html.='<div style="float:left; margin:0 0 0 10px;">';

				if(!empty($data['main_pic'])){
					$html.=sprintf('<img src="%s">',$data['main_pic']);
				}else{
					$html.='<div id="nopicture">no image</div>';
				}

				$html.='</div>';
				$html.='<div style="float:left; margin:0 0 0 20px;">';
				$html.=$data['title'];
				$html.='</div>';
				$html.='</form>';	
				$html.='</div>';	

				$count=$count+1;
			}else{
				$over=1;
				break;
			}
		}
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